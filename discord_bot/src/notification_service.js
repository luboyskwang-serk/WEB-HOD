// Notification service for sending various alerts
const { EmbedBuilder, WebhookClient } = require('discord.js');
const winston = require('./utils/logger');
const config = require('../config/config.json');

// Webhook clients for different notification types
const notificationClients = {
    orders: new WebhookClient({ url: process.env.ORDER_WEBHOOK_URL || config.discord.orderWebhookUrl }),
    topups: new WebhookClient({ url: process.env.TOPUP_WEBHOOK_URL || config.discord.topupWebhookUrl }),
    inventory: new WebhookClient({ url: process.env.INVENTORY_WEBHOOK_URL || config.discord.inventoryWebhookUrl }),
    security: new WebhookClient({ url: process.env.SECURITY_WEBHOOK_URL || config.discord.securityWebhookUrl }),
    general: new WebhookClient({ url: process.env.GENERAL_WEBHOOK_URL || config.discord.generalWebhookUrl })
};

// Notification service class
class NotificationService {
    
    // Send new order notification
    static async sendNewOrder(orderData) {
        if (!config.notifications.newOrder) {
            winston.info('NEW_ORDER_NOTIFICATION_DISABLED');
            return;
        }
        
        try {
            const embed = new EmbedBuilder()
                .setTitle('🛒 คำสั่งซื้อใหม่')
                .setDescription('มีคำสั่งซื้อใหม่ในระบบ')
                .setColor(0x2ecc71)
                .addFields(
                    { name: 'ไอดีคำสั่งซื้อ', value: orderData.orderId.toString(), inline: true },
                    { name: 'สินค้า', value: orderData.productName, inline: true },
                    { name: 'จำนวน', value: orderData.quantity.toString(), inline: true },
                    { name: 'ราคา', value: `${orderData.price.toLocaleString()} บาท`, inline: true },
                    { name: 'ผู้สั่งซื้อ', value: `${orderData.userName} (ID: ${orderData.userId})`, inline: true }
                )
                .setTimestamp()
                .setFooter({ text: 'Dedazen Store Notification', iconURL: 'https://yourwebsite.com/logo.png' });
            
            await notificationClients.orders.send({
                embeds: [embed],
                username: 'Dedazen Store Orders',
                avatarURL: 'https://yourwebsite.com/logo.png'
            });
            
            winston.info('NEW_ORDER_NOTIFICATION_SENT', { orderId: orderData.orderId });
        } catch (error) {
            winston.error('ERROR_SENDING_NEW_ORDER_NOTIFICATION', error);
        }
    }
    
    // Send new topup notification
    static async sendNewTopup(topupData) {
        if (!config.notifications.newTopup) {
            winston.info('NEW_TOPUP_NOTIFICATION_DISABLED');
            return;
        }
        
        try {
            const embed = new EmbedBuilder()
                .setTitle('💰 การเติมเงินใหม่')
                .setDescription('มีการเติมเงินใหม่ในระบบ')
                .setColor(0xf1c40f)
                .addFields(
                    { name: 'ไอดีการเติมเงิน', value: topupData.topupId.toString(), inline: true },
                    { name: 'จำนวนเงิน', value: `${topupData.amount.toLocaleString()} บาท`, inline: true },
                    { name: 'ผู้เติมเงิน', value: `${topupData.userName} (ID: ${topupData.userId})`, inline: true },
                    { name: 'วิธีการชำระเงิน', value: topupData.paymentMethod, inline: true }
                )
                .setTimestamp()
                .setFooter({ text: 'Dedazen Store Notification', iconURL: 'https://yourwebsite.com/logo.png' });
            
            await notificationClients.topups.send({
                embeds: [embed],
                username: 'Dedazen Store Topups',
                avatarURL: 'https://yourwebsite.com/logo.png'
            });
            
            winston.info('NEW_TOPUP_NOTIFICATION_SENT', { topupId: topupData.topupId });
        } catch (error) {
            winston.error('ERROR_SENDING_NEW_TOPUP_NOTIFICATION', error);
        }
    }
    
    // Send low stock notification
    static async sendLowStock(stockData) {
        if (!config.notifications.lowStock) {
            winston.info('LOW_STOCK_NOTIFICATION_DISABLED');
            return;
        }
        
        try {
            const embed = new EmbedBuilder()
                .setTitle('⚠️ สต็อกสินค้าต่ำ')
                .setDescription('สินค้าใกล้หมดสต็อก')
                .setColor(0xe74c3c)
                .addFields(
                    { name: 'ไอดีสินค้า', value: stockData.productId.toString(), inline: true },
                    { name: 'ชื่อสินค้า', value: stockData.productName, inline: true },
                    { name: 'สต็อกปัจจุบัน', value: stockData.currentStock.toString(), inline: true },
                    { name: 'ขั้นต่ำที่กำหนด', value: stockData.threshold.toString(), inline: true }
                )
                .setTimestamp()
                .setFooter({ text: 'Dedazen Store Notification', iconURL: 'https://yourwebsite.com/logo.png' });
            
            await notificationClients.inventory.send({
                embeds: [embed],
                username: 'Dedazen Store Inventory',
                avatarURL: 'https://yourwebsite.com/logo.png'
            });
            
            winston.info('LOW_STOCK_NOTIFICATION_SENT', { productId: stockData.productId });
        } catch (error) {
            winston.error('ERROR_SENDING_LOW_STOCK_NOTIFICATION', error);
        }
    }
    
    // Send security alert notification
    static async sendSecurityAlert(alertData) {
        if (!config.notifications.securityAlert) {
            winston.info('SECURITY_ALERT_NOTIFICATION_DISABLED');
            return;
        }
        
        try {
            const embed = new EmbedBuilder()
                .setTitle('🔒 แจ้งเตือนความปลอดภัย')
                .setDescription('ตรวจพบกิจกรรมที่น่าสงสัย')
                .setColor(0xe74c3c)
                .addFields(
                    { name: 'ประเภทเหตุการณ์', value: alertData.eventType, inline: true },
                    { name: 'ไอดีเหตุการณ์', value: alertData.eventId.toString(), inline: true },
                    { name: 'ผู้ใช้', value: alertData.userId ? `ID: ${alertData.userId}` : 'ไม่ระบุ', inline: true },
                    { name: 'ที่อยู่ IP', value: alertData.ipAddress || 'ไม่ระบุ', inline: true },
                    { name: 'รายละเอียด', value: alertData.details || 'ไม่มีข้อมูลเพิ่มเติม', inline: false }
                )
                .setTimestamp()
                .setFooter({ text: 'Dedazen Store Security', iconURL: 'https://yourwebsite.com/logo.png' });
            
            await notificationClients.security.send({
                embeds: [embed],
                username: 'Dedazen Store Security',
                avatarURL: 'https://yourwebsite.com/logo.png'
            });
            
            winston.info('SECURITY_ALERT_NOTIFICATION_SENT', { eventId: alertData.eventId, userId: alertData.userId });
        } catch (error) {
            winston.error('ERROR_SENDING_SECURITY_ALERT_NOTIFICATION', error);
        }
    }
    
    // Send new user notification
    static async sendNewUser(userData) {
        if (!config.notifications.newUser) {
            winston.info('NEW_USER_NOTIFICATION_DISABLED');
            return;
        }
        
        try {
            const embed = new EmbedBuilder()
                .setTitle('👥 ผู้ใช้ใหม่')
                .setDescription('มีผู้ใช้ใหม่ลงทะเบียนในระบบ')
                .setColor(0x3498db)
                .addFields(
                    { name: 'ไอดีผู้ใช้', value: userData.userId.toString(), inline: true },
                    { name: 'ชื่อผู้ใช้', value: userData.username, inline: true },
                    { name: 'อีเมล', value: userData.email || 'ไม่ระบุ', inline: true },
                    { name: 'วันที่ลงทะเบียน', value: userData.registrationDate, inline: true }
                )
                .setTimestamp()
                .setFooter({ text: 'Dedazen Store Notification', iconURL: 'https://yourwebsite.com/logo.png' });
            
            await notificationClients.general.send({
                embeds: [embed],
                username: 'Dedazen Store',
                avatarURL: 'https://yourwebsite.com/logo.png'
            });
            
            winston.info('NEW_USER_NOTIFICATION_SENT', { userId: userData.userId });
        } catch (error) {
            winston.error('ERROR_SENDING_NEW_USER_NOTIFICATION', error);
        }
    }
    
    // Send daily report
    static async sendDailyReport(reportData) {
        try {
            const embed = new EmbedBuilder()
                .setTitle('📊 รายงานประจำวัน Dedazen Store')
                .setDescription(`สถิติของวันที่ ${reportData.date}`)
                .setColor(0xff6b35)
                .addFields(
                    { name: 'ผู้ใช้ใหม่', value: reportData.newUsers.toString(), inline: true },
                    { name: 'คำสั่งซื้อใหม่', value: reportData.newOrders.toString(), inline: true },
                    { name: 'การเติมเงิน', value: reportData.newTopups.toString(), inline: true },
                    { name: 'รายได้รวม', value: `${reportData.totalRevenue.toLocaleString()} บาท`, inline: true },
                    { name: 'สินค้าขายดี', value: reportData.bestSellingProduct || 'ไม่มีข้อมูล', inline: true }
                )
                .setTimestamp()
                .setFooter({ text: 'Dedazen Store Bot', iconURL: 'https://yourwebsite.com/logo.png' });
            
            await notificationClients.general.send({
                embeds: [embed],
                username: 'Dedazen Store Reports',
                avatarURL: 'https://yourwebsite.com/logo.png'
            });
            
            winston.info('DAILY_REPORT_SENT');
        } catch (error) {
            winston.error('ERROR_SENDING_DAILY_REPORT', error);
        }
    }
    
    // Send custom notification
    static async sendCustomNotification(title, description, color = 0x3498db, fields = [], channel = 'general') {
        try {
            const embed = new EmbedBuilder()
                .setTitle(title)
                .setDescription(description)
                .setColor(color)
                .addFields(fields)
                .setTimestamp()
                .setFooter({ text: 'Dedazen Store Notification', iconURL: 'https://yourwebsite.com/logo.png' });
            
            const client = notificationClients[channel] || notificationClients.general;
            
            await client.send({
                embeds: [embed],
                username: 'Dedazen Store',
                avatarURL: 'https://yourwebsite.com/logo.png'
            });
            
            winston.info('CUSTOM_NOTIFICATION_SENT', { title, channel });
        } catch (error) {
            winston.error('ERROR_SENDING_CUSTOM_NOTIFICATION', error);
        }
    }
}

module.exports = NotificationService;