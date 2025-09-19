require('dotenv').config();
const { Client, GatewayIntentBits, Partials, Collection, EmbedBuilder } = require('discord.js');
const fs = require('fs');
const path = require('path');
const { connectToDatabase } = require('./database');
const logger = require('./utils/logger');
const WebhookSystem = require('./monitoring/webhooks');

// Initialize Discord Client
const client = new Client({
  intents: [
    GatewayIntentBits.Guilds,
    GatewayIntentBits.GuildMessages,
    GatewayIntentBits.GuildMembers,
    GatewayIntentBits.MessageContent,
    GatewayIntentBits.GuildMessageReactions
  ],
  partials: [Partials.Channel, Partials.Message, Partials.User, Partials.GuildMember]
});

// Collections for commands and cooldowns
client.commands = new Collection();
client.cooldowns = new Collection();

// Database connection
let database;

// Function to initialize the bot
async function initializeBot() {
  try {
    // Connect to database
    database = await connectToDatabase();
    logger.info('Connected to database successfully');

    // Initialize webhook system
    client.webhookSystem = new WebhookSystem();

    // Load command files
    const commandsPath = path.join(__dirname, 'commands');
    const commandFiles = fs.readdirSync(commandsPath).filter(file => file.endsWith('.js'));

    for (const file of commandFiles) {
      const filePath = path.join(commandsPath, file);
      const command = require(filePath);
      
      if ('data' in command && 'execute' in command) {
        client.commands.set(command.data.name, command);
        logger.info(`Loaded command: ${command.data.name}`);
      } else {
        logger.warn(`Command at ${filePath} is missing required "data" or "execute" property.`);
      }
    }

    // Load event files
    const eventsPath = path.join(__dirname, 'events');
    const eventFiles = fs.readdirSync(eventsPath).filter(file => file.endsWith('.js'));

    for (const file of eventFiles) {
      const filePath = path.join(eventsPath, file);
      const event = require(filePath);
      
      if (event.once) {
        client.once(event.name, (...args) => event.execute(...args, client));
      } else {
        client.on(event.name, (...args) => event.execute(...args, client));
      }
      
      logger.info(`Loaded event: ${event.name}`);
    }

    // Login to Discord
    await client.login(process.env.DISCORD_TOKEN);
    logger.info('Discord bot logged in successfully');

  } catch (error) {
    logger.error('Failed to initialize bot:', error);
    process.exit(1);
  }
}

// Graceful shutdown
process.on('SIGINT', async () => {
  logger.info('Shutting down bot...');
  if (database) {
    await database.end();
    logger.info('Database connection closed');
  }
  client.destroy();
  process.exit(0);
});

// Initialize the bot
initializeBot();

module.exports = { client, database };