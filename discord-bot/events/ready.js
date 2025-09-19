const { REST, Routes } = require('discord.js');
const fs = require('fs');
const path = require('path');
const logger = require('../utils/logger');
const WebsiteMonitor = require('../monitoring/website');

module.exports = {
  name: 'ready',
  once: true,
  async execute(client) {
    logger.info(`Ready! Logged in as ${client.user.tag}`);
    
    // Register slash commands
    try {
      const commands = [];
      const commandsPath = path.join(__dirname, '..', 'commands');
      const commandFiles = fs.readdirSync(commandsPath).filter(file => file.endsWith('.js'));

      for (const file of commandFiles) {
        const filePath = path.join(commandsPath, file);
        const command = require(filePath);
        commands.push(command.data.toJSON());
      }

      const rest = new REST({ version: '10' }).setToken(process.env.DISCORD_TOKEN);

      logger.info(`Started refreshing ${commands.length} application (/) commands.`);

      const data = await rest.put(
        Routes.applicationGuildCommands(process.env.CLIENT_ID, process.env.GUILD_ID),
        { body: commands }
      );

      logger.info(`Successfully reloaded ${data.length} application (/) commands.`);
    } catch (error) {
      logger.error('Error registering commands:', error);
    }
    
    // Store database connection in client
    const { connectToDatabase } = require('../database');
    client.database = await connectToDatabase();
    
    // Initialize website monitor
    client.websiteMonitor = new WebsiteMonitor(client, client.database);
    client.websiteMonitor.startMonitoring();
    
    logger.info('Bot initialization complete');
  }
};