const { SlashCommandBuilder, EmbedBuilder } = require('discord.js');

module.exports = {
  data: new SlashCommandBuilder()
    .setName('help')
    .setDescription('แสดงคำสั่งทั้งหมดของบอท'),
  
  async execute(interaction) {
    const embed = new EmbedBuilder()
      .setTitle('📖 คำสั่งทั้งหมดของ Dedazen Monitor Bot')
      .setColor(0x0099ff)
      .setDescription('นี่คือคำสั่งทั้งหมดที่คุณสามารถใช้ได้:')
      .addFields(
        { name: '/stats', value: 'แสดงสถิติของเว็บไซต์', inline: false },
        { name: '/user [id]', value: 'ดูข้อมูลผู้ใช้ตาม ID', inline: false },
        { name: '/product [id]', value: 'ดูข้อมูลสินค้าตาม ID', inline: false },
        { name: '/recent', value: 'ดูกิจกรรมล่าสุดในเว็บไซต์', inline: false },
        { name: '/topup [amount] [user]', value: 'เติมเงินให้ผู้ใช้ (สำหรับแอดมิน)', inline: false },
        { name: '/help', value: 'แสดงหน้านี้', inline: false }
      )
      .setFooter({ text: 'Dedazen Store Monitoring Bot' })
      .setTimestamp();

    await interaction.reply({ embeds: [embed] });
  }
};