// Dedazen Store Discord Bot - Main Entry Point
// Version: 1.0.0

require('dotenv').config();
const { Client, Collection, GatewayIntentBits, Partials, Events, REST, Routes } = require('discord.js');
const fs = require('fs');
const path = require('path');
const moment = require('moment');
const winston = require('winston');

// Configure Winston Logger
const logger = winston.createLogger({
  level: 'info',
  format: winston.format.combine(
    winston.format.timestamp(),
    winston.format.printf(({ timestamp, level, message }) => {
      return `[${timestamp}] ${level.toUpperCase()}: ${message}`;
    })
  ),
  transports: [
    new winston.transports.Console(),
    new winston.transports.File({ filename: 'logs/bot.log' })
  ]
});

// Initialize Discord Client
const client = new Client({
  intents: [
    GatewayIntentBits.Guilds,
    GatewayIntentBits.GuildMessages,
    GatewayIntentBits.GuildMembers,
    GatewayIntentBits.MessageContent,
    GatewayIntentBits.GuildPresences
  ],
  partials: [
    Partials.Message,
    Partials.Channel,
    Partials.Reaction
  ]
});

// Collections for commands and cooldowns
client.commands = new Collection();
client.cooldowns = new Collection();

// Load configuration
const config = require('../config/config.json');

// Load command files
const commandsPath = path.join(__dirname, 'commands');
const commandFolders = fs.readdirSync(commandsPath);

// Register commands
async function registerCommands() {
  const commands = [];
  
  for (const folder of commandFolders) {
    const folderPath = path.join(commandsPath, folder);
    if (!fs.statSync(folderPath).isDirectory()) continue;
    
    const commandFiles = fs.readdirSync(folderPath).filter(file => file.endsWith('.js'));
    
    for (const file of commandFiles) {
      const filePath = path.join(folderPath, file);
      const command = require(filePath);
      
      if ('data' in command && 'execute' in command) {
        client.commands.set(command.data.name, command);
        commands.push(command.data.toJSON());
        logger.info(`Loaded command: ${command.data.name}`);
      } else {
        logger.warn(`The command at ${filePath} is missing a required "data" or "execute" property.`);
      }
    }
  }
  
  // Register commands with Discord
  const rest = new REST().setToken(process.env.DISCORD_TOKEN || config.discord.token);
  
  try {
    logger.info('Started refreshing application (/) commands.');
    
    await rest.put(
      Routes.applicationGuildCommands(
        process.env.CLIENT_ID || config.discord.clientId,
        process.env.GUILD_ID || config.discord.guildId
      ),
      { body: commands }
    );
    
    logger.info('Successfully reloaded application (/) commands.');
  } catch (error) {
    logger.error('Error registering commands:', error);
  }
}

// Event handling
const eventsPath = path.join(__dirname, 'events');
const eventFiles = fs.readdirSync(eventsPath).filter(file => file.endsWith('.js'));

for (const file of eventFiles) {
  const filePath = path.join(eventsPath, file);
  const event = require(filePath);
  
  if (event.once) {
    client.once(event.name, (...args) => event.execute(client, ...args));
  } else {
    client.on(event.name, (...args) => event.execute(client, ...args));
  }
  
  logger.info(`Loaded event: ${event.name}`);
}

// Initialize the bot
client.once(Events.ClientReady, async () => {
  logger.info(`Ready! Logged in as ${client.user.tag}`);
  
  // Set status
  client.user.setActivity('Dedazen Store', { type: 'WATCHING' });
  
  // Register commands
  await registerCommands();
  
  // Start periodic tasks
  startPeriodicTasks();
});

// Handle command interactions
client.on(Events.InteractionCreate, async interaction => {
  if (!interaction.isChatInputCommand()) return;

  const command = client.commands.get(interaction.commandName);

  if (!command) {
    logger.warn(`No command matching ${interaction.commandName} was found.`);
    return;
  }

  // Check permissions
  if (command.permissions) {
    const hasPermission = await checkPermissions(interaction, command.permissions);
    if (!hasPermission) {
      await interaction.reply({
        content: 'คุณไม่มีสิทธิ์ในการใช้คำสั่งนี้',
        ephemeral: true
      });
      return;
    }
  }

  // Handle cooldowns
  const { cooldowns } = client;
  if (!cooldowns.has(command.data.name)) {
    cooldowns.set(command.data.name, new Collection());
  }

  const now = Date.now();
  const timestamps = cooldowns.get(command.data.name);
  const cooldownAmount = (command.cooldown || 3) * 1000;

  if (timestamps.has(interaction.user.id)) {
    const expirationTime = timestamps.get(interaction.user.id) + cooldownAmount;

    if (now < expirationTime) {
      const timeLeft = (expirationTime - now) / 1000;
      await interaction.reply({
        content: `กรุณารอ ${timeLeft.toFixed(1)} วินาทีก่อนใช้คำสั่ง \`${command.data.name}\` อีกครั้ง`,
        ephemeral: true
      });
      return;
    }
  }

  timestamps.set(interaction.user.id, now);
  setTimeout(() => timestamps.delete(interaction.user.id), cooldownAmount);

  try {
    await command.execute(interaction);
  } catch (error) {
    logger.error(`Error executing command ${command.data.name}:`, error);
    const errorMessage = {
      content: 'มีข้อผิดพลาดในการดำเนินการคำสั่งนี้!',
      ephemeral: true
    };
    
    if (interaction.replied || interaction.deferred) {
      await interaction.followUp(errorMessage);
    } else {
      await interaction.reply(errorMessage);
    }
  }
});

// Permission checking function
async function checkPermissions(interaction, permissions) {
  // Check if user has required permissions
  if (permissions.adminOnly && interaction.member.permissions.has('ADMINISTRATOR')) {
    return true;
  }
  
  if (permissions.roles) {
    const memberRoles = interaction.member.roles.cache.map(role => role.id);
    return permissions.roles.some(role => memberRoles.includes(role));
  }
  
  return false;
}

// Periodic tasks
function startPeriodicTasks() {
  // Daily report task
  setInterval(async () => {
    // Check if it's 9 AM
    const now = moment();
    if (now.hour() === 9 && now.minute() === 0) {
      await sendDailyReport();
    }
  }, 60000); // Check every minute
  
  logger.info('Periodic tasks started');
}

// Send daily report
async function sendDailyReport() {
  try {
    // Get guild and send report to specific channel
    const guild = client.guilds.cache.get(process.env.GUILD_ID || config.discord.guildId);
    if (!guild) return;
    
    const channel = guild.channels.cache.find(ch => ch.name === 'reports');
    if (!channel) return;
    
    // Generate and send daily report
    const report = await generateDailyReport();
    await channel.send({
      embeds: [report]
    });
    
    logger.info('Daily report sent');
  } catch (error) {
    logger.error('Error sending daily report:', error);
  }
}

// Generate daily report
async function generateDailyReport() {
  // This would connect to your API to get real data
  const embed = {
    title: 'รายงานประจำวัน Dedazen Store',
    description: 'สถิติและการดำเนินงานของวันที่ ' + moment().format('DD/MM/YYYY'),
    color: 0xff6b35,
    fields: [
      {
        name: 'ผู้ใช้ใหม่',
        value: '0',
        inline: true
      },
      {
        name: 'คำสั่งซื้อใหม่',
        value: '0',
        inline: true
      },
      {
        name: 'การเติมเงิน',
        value: '0',
        inline: true
      },
      {
        name: 'รายได้รวม',
        value: '0 บาท',
        inline: true
      }
    ],
    timestamp: new Date(),
    footer: {
      text: 'Dedazen Store Bot'
    }
  };
  
  return embed;
}

// Graceful shutdown
process.on('SIGINT', async () => {
  logger.info('Gracefully shutting down...');
  await client.destroy();
  process.exit(0);
});

// Error handling
process.on('unhandledRejection', error => {
  logger.error('Unhandled promise rejection:', error);
});

process.on('uncaughtException', error => {
  logger.error('Uncaught exception:', error);
  process.exit(1);
});

// Login to Discord
const token = process.env.DISCORD_TOKEN || config.discord.token;
if (!token) {
  logger.error('No Discord token provided!');
  process.exit(1);
}

client.login(token).catch(error => {
  logger.error('Failed to login to Discord:', error);
  process.exit(1);
});

module.exports = client;