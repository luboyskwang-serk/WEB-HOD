// Webhook handler for receiving notifications from the PHP system
const express = require('express');
const { WebhookClient, EmbedBuilder } = require('discord.js');
const winston = require('./utils/logger');
const config = require('../config/config.json');

// Create Express app
const app = express();
const port = process.env.WEBHOOK_PORT || 3000;

// Middleware
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Webhook client for sending messages to Discord
const webhookClient = new WebhookClient({ url: process.env.WEBHOOK_URL || config.discord.webhookUrl });

// Routes for different types of notifications
app.post('/webhook/new-order', authenticateRequest, async (req, res) => {
    try {
        const { orderId, productName, quantity, price, userId, userName } = req.body;
        
        // Create embed for new order notification
        const embed = new EmbedBuilder()
            .setTitle('🛒 คำสั่งซื้อใหม่')
            .setDescription(`มีคำสั่งซื้อใหม่ในระบบ`)
            .setColor(0x2ecc71)
            .addFields(
                { name: 'ไอดีคำสั่งซื้อ', value: orderId.toString(), inline: true },
                { name: 'สินค้า', value: productName, inline: true },
                { name: 'จำนวน', value: quantity.toString(), inline: true },
                { name: 'ราคา', value: `${price.toLocaleString()} บาท`, inline: true },
                { name: 'ผู้สั่งซื้อ', value: `${userName} (ID: ${userId})`, inline: true }
            )
            .setTimestamp()
            .setFooter({ text: 'Dedazen Store Notification', iconURL: 'https://yourwebsite.com/logo.png' });
        
        // Send notification to Discord
        await webhookClient.send({
            embeds: [embed],
            username: 'Dedazen Store',
            avatarURL: 'https://yourwebsite.com/logo.png'
        });
        
        // Log the notification
        winston.info('NEW_ORDER_NOTIFICATION_SENT', { orderId, userId });
        
        res.status(200).json({ success: true, message: 'Notification sent successfully' });
    } catch (error) {
        winston.error('ERROR_SENDING_NEW_ORDER_NOTIFICATION', error);
        res.status(500).json({ success: false, message: 'Failed to send notification' });
    }
});

app.post('/webhook/new-topup', authenticateRequest, async (req, res) => {
    try {
        const { topupId, amount, userId, userName, paymentMethod } = req.body;
        
        // Create embed for new topup notification
        const embed = new EmbedBuilder()
            .setTitle('💰 การเติมเงินใหม่')
            .setDescription(`มีการเติมเงินใหม่ในระบบ`)
            .setColor(0xf1c40f)
            .addFields(
                { name: 'ไอดีการเติมเงิน', value: topupId.toString(), inline: true },
                { name: 'จำนวนเงิน', value: `${amount.toLocaleString()} บาท`, inline: true },
                { name: 'ผู้เติมเงิน', value: `${userName} (ID: ${userId})`, inline: true },
                { name: 'วิธีการชำระเงิน', value: paymentMethod, inline: true }
            )
            .setTimestamp()
            .setFooter({ text: 'Dedazen Store Notification', iconURL: 'https://yourwebsite.com/logo.png' });
        
        // Send notification to Discord
        await webhookClient.send({
            embeds: [embed],
            username: 'Dedazen Store',
            avatarURL: 'https://yourwebsite.com/logo.png'
        });
        
        // Log the notification
        winston.info('NEW_TOPUP_NOTIFICATION_SENT', { topupId, userId });
        
        res.status(200).json({ success: true, message: 'Notification sent successfully' });
    } catch (error) {
        winston.error('ERROR_SENDING_NEW_TOPUP_NOTIFICATION', error);
        res.status(500).json({ success: false, message: 'Failed to send notification' });
    }
});

app.post('/webhook/low-stock', authenticateRequest, async (req, res) => {
    try {
        const { productId, productName, currentStock, threshold } = req.body;
        
        // Create embed for low stock notification
        const embed = new EmbedBuilder()
            .setTitle('⚠️ สต็อกสินค้าต่ำ')
            .setDescription(`สินค้าใกล้หมดสต็อก`)
            .setColor(0xe74c3c)
            .addFields(
                { name: 'ไอดีสินค้า', value: productId.toString(), inline: true },
                { name: 'ชื่อสินค้า', value: productName, inline: true },
                { name: 'สต็อกปัจจุบัน', value: currentStock.toString(), inline: true },
                { name: 'ขั้นต่ำที่กำหนด', value: threshold.toString(), inline: true }
            )
            .setTimestamp()
            .setFooter({ text: 'Dedazen Store Notification', iconURL: 'https://yourwebsite.com/logo.png' });
        
        // Send notification to Discord
        await webhookClient.send({
            embeds: [embed],
            username: 'Dedazen Store',
            avatarURL: 'https://yourwebsite.com/logo.png'
        });
        
        // Log the notification
        winston.info('LOW_STOCK_NOTIFICATION_SENT', { productId });
        
        res.status(200).json({ success: true, message: 'Notification sent successfully' });
    } catch (error) {
        winston.error('ERROR_SENDING_LOW_STOCK_NOTIFICATION', error);
        res.status(500).json({ success: false, message: 'Failed to send notification' });
    }
});

app.post('/webhook/security-alert', authenticateRequest, async (req, res) => {
    try {
        const { eventId, eventType, userId, ipAddress, details } = req.body;
        
        // Create embed for security alert notification
        const embed = new EmbedBuilder()
            .setTitle('🔒 แจ้งเตือนความปลอดภัย')
            .setDescription(`ตรวจพบกิจกรรมที่น่าสงสัย`)
            .setColor(0xe74c3c)
            .addFields(
                { name: 'ประเภทเหตุการณ์', value: eventType, inline: true },
                { name: 'ไอดีเหตุการณ์', value: eventId.toString(), inline: true },
                { name: 'ผู้ใช้', value: userId ? `ID: ${userId}` : 'ไม่ระบุ', inline: true },
                { name: 'ที่อยู่ IP', value: ipAddress || 'ไม่ระบุ', inline: true },
                { name: 'รายละเอียด', value: details || 'ไม่มีข้อมูลเพิ่มเติม', inline: false }
            )
            .setTimestamp()
            .setFooter({ text: 'Dedazen Store Security', iconURL: 'https://yourwebsite.com/logo.png' });
        
        // Send notification to Discord
        await webhookClient.send({
            embeds: [embed],
            username: 'Dedazen Store Security',
            avatarURL: 'https://yourwebsite.com/logo.png'
        });
        
        // Log the notification
        winston.info('SECURITY_ALERT_NOTIFICATION_SENT', { eventId, userId });
        
        res.status(200).json({ success: true, message: 'Notification sent successfully' });
    } catch (error) {
        winston.error('ERROR_SENDING_SECURITY_ALERT_NOTIFICATION', error);
        res.status(500).json({ success: false, message: 'Failed to send notification' });
    }
});

// Authentication middleware
function authenticateRequest(req, res, next) {
    const authHeader = req.headers.authorization;
    const expectedToken = process.env.WEBHOOK_AUTH_TOKEN || config.api.token;
    
    if (!authHeader || authHeader !== `Bearer ${expectedToken}`) {
        winston.warn('UNAUTHORIZED_WEBHOOK_REQUEST', { ip: req.ip, userAgent: req.get('User-Agent') });
        return res.status(401).json({ success: false, message: 'Unauthorized' });
    }
    
    next();
}

// Error handling middleware
app.use((err, req, res, next) => {
    winston.error('WEBHOOK_SERVER_ERROR', err);
    res.status(500).json({ success: false, message: 'Internal server error' });
});

// Start the webhook server
function startWebhookServer() {
    app.listen(port, () => {
        winston.info(`Webhook server listening on port ${port}`);
    });
}

module.exports = { startWebhookServer, app };