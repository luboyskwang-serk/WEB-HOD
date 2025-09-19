const { SlashCommandBuilder, EmbedBuilder } = require('discord.js');
const logger = require('../utils/logger');

module.exports = {
  data: new SlashCommandBuilder()
    .setName('webhook')
    .setDescription('จัดการ Webhook ภายนอก (สำหรับแอดมิน)')
    .addSubcommand(subcommand =>
      subcommand
        .setName('add')
        .setDescription('เพิ่ม Webhook ใหม่')
        .addStringOption(option =>
          option.setName('url')
            .setDescription('URL ของ Webhook')
            .setRequired(true))
        .addStringOption(option =>
          option.setName('events')
            .setDescription('เหตุการณ์ที่จะส่ง (คั่นด้วยคอมม่า)')))
    .addSubcommand(subcommand =>
      subcommand
        .setName('remove')
        .setDescription('ลบ Webhook')
        .addStringOption(option =>
          option.setName('url')
            .setDescription('URL ของ Webhook')
            .setRequired(true)))
    .addSubcommand(subcommand =>
      subcommand
        .setName('list')
        .setDescription('แสดงรายการ Webhook ทั้งหมด'))
    .addSubcommand(subcommand =>
      subcommand
        .setName('test')
        .setDescription('ทดสอบ Webhook')
        .addStringOption(option =>
          option.setName('url')
            .setDescription('URL ของ Webhook')
            .setRequired(true))),
  
  async execute(interaction, client) {
    // Check if user has admin role
    if (!interaction.member.roles.cache.has(process.env.ADMIN_ROLE_ID)) {
      return await interaction.reply({ content: '❌ คุณไม่มีสิทธิ์ในการใช้คำสั่งนี้', ephemeral: true });
    }
    
    const subcommand = interaction.options.getSubcommand();
    
    try {
      switch (subcommand) {
        case 'add':
          await handleAddWebhook(interaction, client);
          break;
        case 'remove':
          await handleRemoveWebhook(interaction, client);
          break;
        case 'list':
          await handleListWebhooks(interaction, client);
          break;
        case 'test':
          await handleTestWebhook(interaction, client);
          break;
        default:
          await interaction.reply({ content: '❌ คำสั่งย่อยไม่ถูกต้อง', ephemeral: true });
      }
    } catch (error) {
      logger.error(`Error in webhook ${subcommand} command:`, error);
      await interaction.reply({ content: '❌ เกิดข้อผิดพลาดในการดำเนินการ', ephemeral: true });
    }
  }
};

async function handleAddWebhook(interaction, client) {
  await interaction.deferReply();
  
  const url = interaction.options.getString('url');
  const events = interaction.options.getString('events');
  
  // Validate URL format
  try {
    new URL(url);
  } catch (error) {
    return await interaction.editReply({ content: '❌ URL ของ Webhook ไม่ถูกต้อง' });
  }
  
  // Add webhook to system
  if (client.webhookSystem) {
    client.webhookSystem.addWebhook(url, events ? events.split(',').map(e => e.trim()) : []);
    
    const embed = new EmbedBuilder()
      .setTitle('✅ เพิ่ม Webhook สำเร็จ')
      .setColor(0x00ff00)
      .addFields(
        { name: 'URL', value: url, inline: false },
        { name: 'เหตุการณ์', value: events || 'ทั้งหมด', inline: false }
      )
      .setTimestamp();
    
    await interaction.editReply({ embeds: [embed] });
    logger.info(`Webhook added by ${interaction.user.tag}: ${url}`);
  } else {
    await interaction.editReply({ content: '❌ ระบบ Webhook ยังไม่ได้ถูกกำหนดค่า' });
  }
}

async function handleRemoveWebhook(interaction, client) {
  await interaction.deferReply();
  
  const url = interaction.options.getString('url');
  
  // Remove webhook from system
  if (client.webhookSystem) {
    client.webhookSystem.removeWebhook(url);
    
    const embed = new EmbedBuilder()
      .setTitle('✅ ลบ Webhook สำเร็จ')
      .setColor(0x00ff00)
      .addFields(
        { name: 'URL', value: url, inline: false }
      )
      .setTimestamp();
    
    await interaction.editReply({ embeds: [embed] });
    logger.info(`Webhook removed by ${interaction.user.tag}: ${url}`);
  } else {
    await interaction.editReply({ content: '❌ ระบบ Webhook ยังไม่ได้ถูกกำหนดค่า' });
  }
}

async function handleListWebhooks(interaction, client) {
  await interaction.deferReply();
  
  if (client.webhookSystem) {
    const webhooks = client.webhookSystem.getWebhooks();
    
    if (webhooks.length === 0) {
      return await interaction.editReply({ content: '❌ ไม่มี Webhook ที่ถูกกำหนดค่า' });
    }
    
    const webhookFields = webhooks.map((webhook, index) => ({
      name: `Webhook #${index + 1}`,
      value: `URL: ${webhook.url}\nสถานะ: ${webhook.enabled ? 'เปิดใช้งาน' : 'ปิดใช้งาน'}\nเหตุการณ์: ${webhook.events.length > 0 ? webhook.events.join(', ') : 'ทั้งหมด'}`,
      inline: false
    }));
    
    const embed = new EmbedBuilder()
      .setTitle('📋 รายการ Webhook ทั้งหมด')
      .setColor(0x0099ff)
      .addFields(webhookFields)
      .setTimestamp();
    
    await interaction.editReply({ embeds: [embed] });
  } else {
    await interaction.editReply({ content: '❌ ระบบ Webhook ยังไม่ได้ถูกกำหนดค่า' });
  }
}

async function handleTestWebhook(interaction, client) {
  await interaction.deferReply();
  
  const url = interaction.options.getString('url');
  
  if (client.webhookSystem) {
    // Send test payload
    const success = await client.webhookSystem.sendToWebhook(url, {
      event: 'test',
      message: 'This is a test webhook from Dedazen Store Bot',
      timestamp: new Date().toISOString()
    });
    
    if (success) {
      const embed = new EmbedBuilder()
        .setTitle('✅ ทดสอบ Webhook สำเร็จ')
        .setColor(0x00ff00)
        .addFields(
          { name: 'URL', value: url, inline: false },
          { name: 'สถานะ', value: 'ส่งข้อมูลสำเร็จ', inline: false }
        )
        .setTimestamp();
      
      await interaction.editReply({ embeds: [embed] });
    } else {
      await interaction.editReply({ content: '❌ ไม่สามารถส่งข้อมูลไปยัง Webhook ได้' });
    }
  } else {
    await interaction.editReply({ content: '❌ ระบบ Webhook ยังไม่ได้ถูกกำหนดค่า' });
  }
}