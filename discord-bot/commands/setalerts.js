const { SlashCommandBuilder, EmbedBuilder } = require('discord.js');
const logger = require('../utils/logger');

module.exports = {
  data: new SlashCommandBuilder()
    .setName('setalerts')
    .setDescription('ตั้งค่าช่องสำหรับแจ้งเตือน (สำหรับแอดมิน)')
    .addChannelOption(option =>
      option.setName('channel')
        .setDescription('ช่องที่จะใช้สำหรับแจ้งเตือน')
        .setRequired(true)),
  
  async execute(interaction, client) {
    // Check if user has admin role
    if (!interaction.member.roles.cache.has(process.env.ADMIN_ROLE_ID)) {
      return await interaction.reply({ content: '❌ คุณไม่มีสิทธิ์ในการใช้คำสั่งนี้', ephemeral: true });
    }
    
    try {
      await interaction.deferReply();
      
      // Get channel from command
      const channel = interaction.options.getChannel('channel');
      
      // Check if bot has permission to send messages in that channel
      const botMember = await interaction.guild.members.fetch(client.user.id);
      const botPermissions = channel.permissionsFor(botMember);
      
      if (!botPermissions.has('SendMessages')) {
        return await interaction.editReply({ content: '❌ บอทไม่มีสิทธิ์ในการส่งข้อความในช่องนี้' });
      }
      
      // Set alerts channel in monitor
      if (client.websiteMonitor) {
        const success = await client.websiteMonitor.setAlertsChannel(channel.id);
        
        if (success) {
          const embed = new EmbedBuilder()
            .setTitle('✅ ตั้งค่าช่องแจ้งเตือนสำเร็จ')
            .setColor(0x00ff00)
            .addFields(
              { name: 'ช่อง', value: `<#${channel.id}>`, inline: true },
              { name: 'ประเภท', value: channel.type, inline: true }
            )
            .setTimestamp()
            .setFooter({ text: 'Dedazen Store Monitoring Bot' });
          
          await interaction.editReply({ embeds: [embed] });
          logger.info(`Alerts channel set to: ${channel.name} (${channel.id}) by ${interaction.user.tag}`);
        } else {
          await interaction.editReply({ content: '❌ ไม่สามารถตั้งค่าช่องแจ้งเตือนได้' });
        }
      } else {
        await interaction.editReply({ content: '❌ ระบบตรวจสอบยังไม่ได้ถูกกำหนดค่า' });
      }
    } catch (error) {
      logger.error('Error in setalerts command:', error);
      await interaction.editReply({ content: '❌ เกิดข้อผิดพลาดในการตั้งค่าช่องแจ้งเตือน' });
    }
  }
};