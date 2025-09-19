// Command: /stats - Show store statistics
const { SlashCommandBuilder, EmbedBuilder } = require('discord.js');
const axios = require('axios');
const moment = require('moment');

module.exports = {
    data: new SlashCommandBuilder()
        .setName('stats')
        .setDescription('แสดงสถิติเว็บไซต์')
        .addStringOption(option =>
            option.setName('period')
                .setDescription('ช่วงเวลา')
                .setRequired(false)
                .addChoices(
                    { name: 'วันนี้', value: 'today' },
                    { name: 'สัปดาห์นี้', value: 'week' },
                    { name: 'เดือนนี้', value: 'month' }
                )),
    permissions: {
        adminOnly: true
    },
    async execute(interaction) {
        await interaction.deferReply();

        try {
            // Get period from options
            const period = interaction.options.getString('period') || 'today';
            
            // Get stats from API (replace with your actual API endpoint)
            const stats = await getStoreStats(period);
            
            // Create embed
            const embed = new EmbedBuilder()
                .setTitle('📊 สถิติ Dedazen Store')
                .setDescription(`สถิติ ${getPeriodText(period)}`)
                .setColor(0xff6b35)
                .addFields(
                    { name: '👥 ผู้ใช้ทั้งหมด', value: stats.totalUsers.toString(), inline: true },
                    { name: '🛒 คำสั่งซื้อทั้งหมด', value: stats.totalOrders.toString(), inline: true },
                    { name: '💰 การเติมเงินทั้งหมด', value: stats.totalTopups.toString(), inline: true },
                    { name: '📈 รายได้รวม', value: `${stats.totalRevenue.toLocaleString()} บาท`, inline: true },
                    { name: '📦 สินค้าคงคลัง', value: stats.totalStock.toString(), inline: true },
                    { name: '⭐ ผู้ใช้ VIP', value: stats.vipUsers.toString(), inline: true }
                )
                .setTimestamp()
                .setFooter({ text: 'Dedazen Store Bot', iconURL: interaction.client.user.displayAvatarURL() });

            await interaction.editReply({ embeds: [embed] });
        } catch (error) {
            console.error('Error in stats command:', error);
            await interaction.editReply({ content: 'เกิดข้อผิดพลาดในการดึงสถิติ' });
        }
    },
};

// Function to get store stats from API
async function getStoreStats(period) {
    // This is a mock implementation - replace with actual API call
    // Example API call:
    /*
    const response = await axios.get(`${process.env.API_BASE_URL || 'https://yourwebsite.com/api'}/stats/${period}`, {
        headers: {
            'Authorization': `Bearer ${process.env.API_TOKEN || 'your-api-token'}`
        }
    });
    return response.data;
    */
    
    // Mock data for demonstration
    return {
        totalUsers: 1250,
        totalOrders: 342,
        totalTopups: 298,
        totalRevenue: 45670,
        totalStock: 1567,
        vipUsers: 89,
        period: period
    };
}

// Function to get period text
function getPeriodText(period) {
    switch (period) {
        case 'today': return 'วันนี้';
        case 'week': return 'สัปดาห์นี้';
        case 'month': return 'เดือนนี้';
        default: return 'ทั้งหมด';
    }
}