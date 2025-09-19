const axios = require('axios');
const logger = require('../utils/logger');
const { getWebsiteStats } = require('../database');
const AlertSystem = require('./alerts');

class WebsiteMonitor {
  constructor(client, database) {
    this.client = client;
    this.database = database;
    this.monitoringInterval = null;
    this.alertSystem = new AlertSystem(client);
    this.previousStatus = true; // Assume website was online initially
  }

  // Start monitoring website
  startMonitoring() {
    this.monitoringInterval = setInterval(async () => {
      try {
        await this.checkWebsiteStatus();
        await this.checkDatabaseStatus();
      } catch (error) {
        logger.error('Error in website monitoring:', error);
      }
    }, parseInt(process.env.CHECK_INTERVAL) || 300000); // Default 5 minutes
    
    logger.info('Website monitoring started');
  }

  // Stop monitoring
  stopMonitoring() {
    if (this.monitoringInterval) {
      clearInterval(this.monitoringInterval);
      logger.info('Website monitoring stopped');
    }
  }

  // Check website status
  async checkWebsiteStatus() {
    try {
      // Check if website is accessible
      const response = await axios.get(process.env.WEBSITE_URL, { timeout: 10000 });
      const isOnline = response.status === 200;
      
      // Get website stats
      const stats = await getWebsiteStats(this.database);
      
      logger.info(`Website status check: ${isOnline ? 'Online' : 'Offline'}`);
      
      // Send alert if website status changed
      if (this.previousStatus && !isOnline) {
        // Website went down
        await this.alertSystem.sendWebsiteDownAlert('Website is unreachable');
      } else if (!this.previousStatus && isOnline) {
        // Website came back up
        // You could send an "up" alert here if needed
      }
      
      this.previousStatus = isOnline;
      
      return { isOnline, stats };
    } catch (error) {
      logger.error('Website status check failed:', error.message);
      
      // Send alert if website went down
      if (this.previousStatus) {
        await this.alertSystem.sendWebsiteDownAlert(error.message);
        this.previousStatus = false;
      }
      
      return { isOnline: false, error: error.message };
    }
  }

  // Check database connection
  async checkDatabaseStatus() {
    try {
      // Simple query to test connection
      const [result] = await this.database.execute('SELECT 1 as test');
      return { connected: true };
    } catch (error) {
      logger.error('Database connection check failed:', error);
      
      // Send alert for database error
      await this.alertSystem.sendDatabaseErrorAlert(error.message);
      
      return { connected: false, error: error.message };
    }
  }
  
  // Set alerts channel
  async setAlertsChannel(channelId) {
    return await this.alertSystem.setAlertsChannel(channelId);
  }
}

module.exports = WebsiteMonitor;