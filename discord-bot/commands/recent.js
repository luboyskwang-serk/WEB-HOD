const { SlashCommandBuilder, EmbedBuilder } = require('discord.js');
const { getRecentActivities } = require('../database');
const logger = require('../utils/logger');

module.exports = {
  data: new SlashCommandBuilder()
    .setName('recent')
    .setDescription('ดูกิจกรรมล่าสุดในเว็บไซต์'),
  
  async execute(interaction, client) {
    try {
      await interaction.deferReply();
      
      // Get database connection
      const database = client.database;
      
      // Get recent activities
      const activities = await getRecentActivities(database, 10);
      
      if (activities.length === 0) {
        return await interaction.editReply({ content: '❌ ไม่มีกิจกรรมล่าสุด' });
      }
      
      // Format activities for display
      const activityFields = activities.slice(0, 10).map((activity, index) => {
        const typeEmoji = activity.type === 'topup' ? '💳' : '🛒';
        const typeName = activity.type === 'topup' ? 'เติมเงิน' : 'สั่งซื้อ';
        const value = activity.type === 'topup' 
          ? `${parseFloat(activity.value).toLocaleString('th-TH')} บาท` 
          : `${parseFloat(activity.value).toLocaleString('th-TH')} บาท`;
        
        return {
          name: `${typeEmoji} ${typeName} #${activity.id}`,
          value: `ผู้ใช้: ${activity.username}\nจำนวน: ${value}\nเวลา: ${new Date(activity.timestamp).toLocaleString('th-TH')}`,
          inline: false
        };
      });
      
      // Create embed
      const embed = new EmbedBuilder()
        .setTitle('🕒 กิจกรรมล่าสุดในเว็บไซต์')
        .setColor(0xff9900)
        .addFields(activityFields)
        .setTimestamp()
        .setFooter({ text: 'Dedazen Store Monitoring Bot' });
      
      await interaction.editReply({ embeds: [embed] });
    } catch (error) {
      logger.error('Error in recent command:', error);
      await interaction.editReply({ content: '❌ เกิดข้อผิดพลาดในการดึงกิจกรรมล่าสุด' });
    }
  }
};