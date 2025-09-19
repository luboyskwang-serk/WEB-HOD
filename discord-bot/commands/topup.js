const { SlashCommandBuilder, EmbedBuilder } = require('discord.js');
const { updateUserPoints, getUserInfo } = require('../database');
const logger = require('../utils/logger');

module.exports = {
  data: new SlashCommandBuilder()
    .setName('topup')
    .setDescription('เติมเงินให้ผู้ใช้ (สำหรับแอดมิน)')
    .addIntegerOption(option =>
      option.setName('amount')
        .setDescription('จำนวนเงินที่ต้องการเติม')
        .setRequired(true))
    .addIntegerOption(option =>
      option.setName('user')
        .setDescription('ID ของผู้ใช้ที่ต้องการเติมเงิน')
        .setRequired(true)),
  
  async execute(interaction, client) {
    try {
      // Check if user has admin role
      if (!interaction.member.roles.cache.has(process.env.ADMIN_ROLE_ID)) {
        return await interaction.reply({ content: '❌ คุณไม่มีสิทธิ์ในการใช้คำสั่งนี้', ephemeral: true });
      }
      
      await interaction.deferReply();
      
      // Get parameters
      const amount = interaction.options.getInteger('amount');
      const userId = interaction.options.getInteger('user');
      
      // Validate amount
      if (amount <= 0) {
        return await interaction.editReply({ content: '❌ จำนวนเงินต้องมากกว่า 0' });
      }
      
      // Get database connection
      const database = client.database;
      
      // Get user information
      const user = await getUserInfo(database, userId);
      
      if (!user) {
        return await interaction.editReply({ content: '❌ ไม่พบผู้ใช้ที่มี ID นี้' });
      }
      
      // Update user points
      await updateUserPoints(database, userId, amount);
      
      // Create embed
      const embed = new EmbedBuilder()
        .setTitle('✅ เติมเงินสำเร็จ')
        .setColor(0x00ff00)
        .addFields(
          { name: 'ผู้ใช้', value: `${user.username} (ID: ${userId})`, inline: true },
          { name: 'จำนวนเงิน', value: `${amount.toLocaleString('th-TH')} บาท`, inline: true },
          { name: 'แอดมิน', value: `<@${interaction.user.id}>`, inline: true }
        )
        .setTimestamp()
        .setFooter({ text: 'Dedazen Store Monitoring Bot' });
      
      await interaction.editReply({ embeds: [embed] });
      
      // Log the action
      logger.info(`Admin ${interaction.user.tag} topped up ${amount} THB to user ${user.username} (ID: ${userId})`);
    } catch (error) {
      logger.error('Error in topup command:', error);
      await interaction.editReply({ content: '❌ เกิดข้อผิดพลาดในการเติมเงิน' });
    }
  }
};