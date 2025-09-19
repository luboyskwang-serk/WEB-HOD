const { SlashCommandBuilder, EmbedBuilder } = require('discord.js');
const { getWebsiteStats } = require('../database');
const logger = require('../utils/logger');

module.exports = {
  data: new SlashCommandBuilder()
    .setName('stats')
    .setDescription('แสดงสถิติของเว็บไซต์'),
  
  async execute(interaction, client) {
    try {
      await interaction.deferReply();
      
      // Get database connection
      const database = client.database;
      
      // Get website statistics
      const stats = await getWebsiteStats(database);
      
      // Create embed
      const embed = new EmbedBuilder()
        .setTitle('📊 สถิติเว็บไซต์ Dedazen Store')
        .setColor(0x00ff00)
        .addFields(
          { name: '👥 จำนวนผู้ใช้ทั้งหมด', value: `${stats.users.toLocaleString()} คน`, inline: true },
          { name: '📦 จำนวนสินค้าทั้งหมด', value: `${stats.products.toLocaleString()} ชิ้น`, inline: true },
          { name: '🛒 จำนวนคำสั่งซื้อทั้งหมด', value: `${stats.orders.toLocaleString()} รายการ`, inline: true },
          { name: '💳 จำนวนการเติมเงินทั้งหมด', value: `${stats.topups.toLocaleString()} รายการ`, inline: true },
          { name: '💰 รายได้ทั้งหมด', value: `${parseFloat(stats.revenue).toLocaleString('th-TH', { style: 'currency', currency: 'THB' })}`, inline: true }
        )
        .setTimestamp()
        .setFooter({ text: 'Dedazen Store Monitoring Bot' });
      
      await interaction.editReply({ embeds: [embed] });
    } catch (error) {
      logger.error('Error in stats command:', error);
      await interaction.editReply({ content: '❌ เกิดข้อผิดพลาดในการดึงข้อมูลสถิติ' });
    }
  }
};