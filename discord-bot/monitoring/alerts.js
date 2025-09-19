const logger = require('../utils/logger');

class AlertSystem {
  constructor(client) {
    this.client = client;
    this.alertsChannel = null;
  }

  // Set the alerts channel
  async setAlertsChannel(channelId) {
    try {
      this.alertsChannel = await this.client.channels.fetch(channelId);
      logger.info(`Alerts channel set to: ${channelId}`);
      return true;
    } catch (error) {
      logger.error('Failed to set alerts channel:', error);
      return false;
    }
  }

  // Send website down alert
  async sendWebsiteDownAlert(error) {
    if (!this.alertsChannel) {
      logger.warn('Alerts channel not set, cannot send website down alert');
      return;
    }

    try {
      await this.alertsChannel.send({
        content: '@here ❌ **เว็บไซต์หยุดทำงาน!**',
        embeds: [{
          title: '🚨 แจ้งเตือนเว็บไซต์หยุดทำงาน',
          color: 0xff0000,
          fields: [
            {
              name: 'ข้อผิดพลาด',
              value: error || 'ไม่สามารถระบุข้อผิดพลาดได้',
              inline: false
            },
            {
              name: 'เวลา',
              value: new Date().toLocaleString('th-TH'),
              inline: false
            }
          ],
          timestamp: new Date()
        }]
      });
      
      logger.info('Website down alert sent');
    } catch (error) {
      logger.error('Failed to send website down alert:', error);
    }
  }

  // Send database error alert
  async sendDatabaseErrorAlert(error) {
    if (!this.alertsChannel) {
      logger.warn('Alerts channel not set, cannot send database error alert');
      return;
    }

    try {
      await this.alertsChannel.send({
        content: '<@&' + process.env.ADMIN_ROLE_ID + '> ❌ **ฐานข้อมูลมีข้อผิดพลาด!**',
        embeds: [{
          title: '🚨 แจ้งเตือนฐานข้อมูลมีข้อผิดพลาด',
          color: 0xff0000,
          fields: [
            {
              name: 'ข้อผิดพลาด',
              value: error || 'ไม่สามารถระบุข้อผิดพลาดได้',
              inline: false
            },
            {
              name: 'เวลา',
              value: new Date().toLocaleString('th-TH'),
              inline: false
            }
          ],
          timestamp: new Date()
        }]
      });
      
      logger.info('Database error alert sent');
    } catch (error) {
      logger.error('Failed to send database error alert:', error);
    }
  }

  // Send large transaction alert
  async sendLargeTransactionAlert(type, amount, user) {
    if (!this.alertsChannel) {
      logger.warn('Alerts channel not set, cannot send large transaction alert');
      return;
    }

    try {
      await this.alertsChannel.send({
        content: '<@&' + process.env.ADMIN_ROLE_ID + '> 💰 **การทำธุรกรรมจำนวนมาก!**',
        embeds: [{
          title: '💰 แจ้งเตือนการทำธุรกรรมจำนวนมาก',
          color: 0xff9900,
          fields: [
            {
              name: 'ประเภท',
              value: type,
              inline: true
            },
            {
              name: 'จำนวนเงิน',
              value: `${amount.toLocaleString('th-TH')} บาท`,
              inline: true
            },
            {
              name: 'ผู้ใช้',
              value: user,
              inline: true
            },
            {
              name: 'เวลา',
              value: new Date().toLocaleString('th-TH'),
              inline: false
            }
          ],
          timestamp: new Date()
        }]
      });
      
      logger.info(`Large transaction alert sent: ${type} ${amount} THB for ${user}`);
    } catch (error) {
      logger.error('Failed to send large transaction alert:', error);
    }
  }

  // Send new user registration alert
  async sendNewUserAlert(username, userId) {
    if (!this.alertsChannel) {
      logger.warn('Alerts channel not set, cannot send new user alert');
      return;
    }

    try {
      await this.alertsChannel.send({
        embeds: [{
          title: '🆕 ผู้ใช้ใหม่สมัครสมาชิก',
          color: 0x00ff00,
          fields: [
            {
              name: 'ชื่อผู้ใช้',
              value: username,
              inline: true
            },
            {
              name: 'ID',
              value: userId.toString(),
              inline: true
            },
            {
              name: 'เวลา',
              value: new Date().toLocaleString('th-TH'),
              inline: false
            }
          ],
          timestamp: new Date()
        }]
      });
      
      logger.info(`New user alert sent: ${username} (${userId})`);
    } catch (error) {
      logger.error('Failed to send new user alert:', error);
    }
  }
}

module.exports = AlertSystem;