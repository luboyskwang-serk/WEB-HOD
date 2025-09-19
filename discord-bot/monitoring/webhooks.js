const axios = require('axios');
const logger = require('../utils/logger');

class WebhookSystem {
  constructor() {
    this.webhooks = [];
  }

  // Add a webhook URL
  addWebhook(url, events = []) {
    this.webhooks.push({
      url,
      events,
      enabled: true
    });
    logger.info(`Webhook added: ${url}`);
  }

  // Remove a webhook
  removeWebhook(url) {
    this.webhooks = this.webhooks.filter(webhook => webhook.url !== url);
    logger.info(`Webhook removed: ${url}`);
  }

  // Send payload to all relevant webhooks
  async sendEvent(eventType, payload) {
    const promises = this.webhooks
      .filter(webhook => 
        webhook.enabled && 
        (webhook.events.length === 0 || webhook.events.includes(eventType))
      )
      .map(webhook => this.sendToWebhook(webhook.url, { event: eventType, ...payload }));

    try {
      await Promise.all(promises);
    } catch (error) {
      logger.error('Error sending webhook notifications:', error);
    }
  }

  // Send data to a specific webhook
  async sendToWebhook(url, data) {
    try {
      const response = await axios.post(url, data, {
        headers: {
          'Content-Type': 'application/json'
        },
        timeout: 5000
      });
      
      if (response.status === 200 || response.status === 204) {
        logger.info(`Webhook sent successfully to ${url}`);
        return true;
      } else {
        logger.warn(`Webhook returned status ${response.status} for ${url}`);
        return false;
      }
    } catch (error) {
      logger.error(`Failed to send webhook to ${url}:`, error.message);
      return false;
    }
  }

  // Get all webhooks
  getWebhooks() {
    return this.webhooks;
  }

  // Enable/disable a webhook
  toggleWebhook(url, enabled) {
    const webhook = this.webhooks.find(w => w.url === url);
    if (webhook) {
      webhook.enabled = enabled;
      logger.info(`Webhook ${url} ${enabled ? 'enabled' : 'disabled'}`);
      return true;
    }
    return false;
  }
}

module.exports = WebhookSystem;