const { SlashCommandBuilder, EmbedBuilder } = require('discord.js');
const { getProductInfo } = require('../database');
const logger = require('../utils/logger');

module.exports = {
  data: new SlashCommandBuilder()
    .setName('product')
    .setDescription('ดูข้อมูลสินค้า')
    .addIntegerOption(option =>
      option.setName('id')
        .setDescription('ID ของสินค้า')
        .setRequired(true)),
  
  async execute(interaction, client) {
    try {
      await interaction.deferReply();
      
      // Get product ID from command
      const productId = interaction.options.getInteger('id');
      
      // Get database connection
      const database = client.database;
      
      // Get product information
      const product = await getProductInfo(database, productId);
      
      if (!product) {
        return await interaction.editReply({ content: '❌ ไม่พบสินค้าที่มี ID นี้' });
      }
      
      // Create embed
      const embed = new EmbedBuilder()
        .setTitle(`📦 ข้อมูลสินค้า: ${product.name}`)
        .setColor(0x00ff00)
        .addFields(
          { name: '🆔 ID', value: product.id.toString(), inline: true },
          { name: '🏷️ ชื่อสินค้า', value: product.name, inline: true },
          { name: '💰 ราคาปกติ', value: `${parseFloat(product.price).toLocaleString('th-TH')} บาท`, inline: true },
          { name: '💎 ราคา VIP', value: `${parseFloat(product.price_vip).toLocaleString('th-TH')} บาท`, inline: true },
          { name: '📊 เปอร์เซ็นต์', value: `${product.percent}%`, inline: true },
          { name: '🏷️ หมวดหมู่', value: product.c_type, inline: true },
          { name: '🎁 ของรางวัลไม่ได้รับ', value: product.salt_prize, inline: true }
        )
        .setTimestamp()
        .setFooter({ text: 'Dedazen Store Monitoring Bot' });
      
      await interaction.editReply({ embeds: [embed] });
    } catch (error) {
      logger.error('Error in product command:', error);
      await interaction.editReply({ content: '❌ เกิดข้อผิดพลาดในการดึงข้อมูลสินค้า' });
    }
  }
};