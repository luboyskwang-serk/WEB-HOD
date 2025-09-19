const { SlashCommandBuilder, EmbedBuilder } = require('discord.js');
const { getUserInfo } = require('../database');
const logger = require('../utils/logger');

module.exports = {
  data: new SlashCommandBuilder()
    .setName('user')
    .setDescription('ดูข้อมูลผู้ใช้')
    .addIntegerOption(option =>
      option.setName('id')
        .setDescription('ID ของผู้ใช้')
        .setRequired(true)),
  
  async execute(interaction, client) {
    try {
      await interaction.deferReply();
      
      // Get user ID from command
      const userId = interaction.options.getInteger('id');
      
      // Get database connection
      const database = client.database;
      
      // Get user information
      const user = await getUserInfo(database, userId);
      
      if (!user) {
        return await interaction.editReply({ content: '❌ ไม่พบผู้ใช้ที่มี ID นี้' });
      }
      
      // Create embed
      const embed = new EmbedBuilder()
        .setTitle(`👥 ข้อมูลผู้ใช้: ${user.username}`)
        .setColor(0x0099ff)
        .addFields(
          { name: '🆔 ID', value: user.id.toString(), inline: true },
          { name: '👤 ชื่อผู้ใช้', value: user.username, inline: true },
          { name: '💰 เครดิต', value: `${parseFloat(user.point).toLocaleString('th-TH')} บาท`, inline: true },
          { name: '💵 ยอดเติมสะสม', value: `${parseFloat(user.total).toLocaleString('th-TH')} บาท`, inline: true },
          { name: '📅 วันที่สมัคร', value: new Date(user.date).toLocaleDateString('th-TH'), inline: true },
          { name: '👑 ระดับผู้ใช้', value: user.rank === 1 ? 'แอดมิน' : 'สมาชิก', inline: true },
          { name: '⭐ สมาชิก VIP', value: user.vip_role === 1 ? 'ใช่' : 'ไม่ใช่', inline: true }
        )
        .setTimestamp()
        .setFooter({ text: 'Dedazen Store Monitoring Bot' });
      
      await interaction.editReply({ embeds: [embed] });
    } catch (error) {
      logger.error('Error in user command:', error);
      await interaction.editReply({ content: '❌ เกิดข้อผิดพลาดในการดึงข้อมูลผู้ใช้' });
    }
  }
};