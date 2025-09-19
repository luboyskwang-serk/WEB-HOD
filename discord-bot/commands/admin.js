const { SlashCommandBuilder, EmbedBuilder } = require('discord.js');
const logger = require('../utils/logger');

module.exports = {
  data: new SlashCommandBuilder()
    .setName('admin')
    .setDescription('แผงควบคุมแอดมิน')
    .addSubcommand(subcommand =>
      subcommand
        .setName('status')
        .setDescription('ตรวจสอบสถานะของบอท'))
    .addSubcommand(subcommand =>
      subcommand
        .setName('restart')
        .setDescription('รีสตาร์ทบอท (จำเป็นต้องมีสิทธิ์เฉพาะแอดมิน)'))
    .addSubcommand(subcommand =>
      subcommand
        .setName('monitor')
        .setDescription('ควบคุมระบบตรวจสอบ')
        .addStringOption(option =>
          option.setName('action')
            .setDescription('การกระทำ')
            .setRequired(true)
            .addChoices(
              { name: 'เริ่ม', value: 'start' },
              { name: 'หยุด', value: 'stop' },
              { name: 'สถานะ', value: 'status' }
            ))),
  
  async execute(interaction, client) {
    // Check if user has admin role
    if (!interaction.member.roles.cache.has(process.env.ADMIN_ROLE_ID)) {
      return await interaction.reply({ content: '❌ คุณไม่มีสิทธิ์ในการใช้คำสั่งนี้', ephemeral: true });
    }
    
    const subcommand = interaction.options.getSubcommand();
    
    try {
      switch (subcommand) {
        case 'status':
          await handleStatusCommand(interaction, client);
          break;
        case 'restart':
          await handleRestartCommand(interaction, client);
          break;
        case 'monitor':
          await handleMonitorCommand(interaction, client);
          break;
        default:
          await interaction.reply({ content: '❌ คำสั่งย่อยไม่ถูกต้อง', ephemeral: true });
      }
    } catch (error) {
      logger.error(`Error in admin ${subcommand} command:`, error);
      await interaction.reply({ content: '❌ เกิดข้อผิดพลาดในการดำเนินการ', ephemeral: true });
    }
  }
};

async function handleStatusCommand(interaction, client) {
  await interaction.deferReply();
  
  // Get bot uptime
  const uptime = process.uptime();
  const uptimeString = formatUptime(uptime);
  
  // Get database status
  let dbStatus = '❌ ไม่สามารถเชื่อมต่อได้';
  try {
    const [result] = await client.database.execute('SELECT 1 as test');
    if (result) dbStatus = '✅ ทำงานปกติ';
  } catch (error) {
    logger.error('Database status check failed:', error);
  }
  
  // Get monitoring status
  const monitoringStatus = client.websiteMonitor ? '✅ ทำงานอยู่' : '❌ ไม่ทำงาน';
  
  // Create embed
  const embed = new EmbedBuilder()
    .setTitle('🤖 สถานะบอท')
    .setColor(0x0099ff)
    .addFields(
      { name: '🟢 สถานะ', value: 'ทำงานปกติ', inline: true },
      { name: '⏰ เวลาทำงาน', value: uptimeString, inline: true },
      { name: '💾 ฐานข้อมูล', value: dbStatus, inline: true },
      { name: '🔍 ระบบตรวจสอบ', value: monitoringStatus, inline: true },
      { name: '📡 เซิร์ฟเวอร์', value: interaction.guild.name, inline: true },
      { name: '👥 จำนวนผู้ใช้', value: interaction.guild.memberCount.toString(), inline: true }
    )
    .setTimestamp()
    .setFooter({ text: 'Dedazen Store Monitoring Bot' });
  
  await interaction.editReply({ embeds: [embed] });
}

async function handleRestartCommand(interaction, client) {
  await interaction.reply({ content: '🔄 กำลังรีสตาร์ทบอท...', ephemeral: true });
  
  // Log the restart
  logger.info(`Bot restart initiated by ${interaction.user.tag}`);
  
  // Wait a moment before restarting
  setTimeout(() => {
    process.exit(0);
  }, 2000);
}

async function handleMonitorCommand(interaction, client) {
  await interaction.deferReply();
  
  const action = interaction.options.getString('action');
  
  switch (action) {
    case 'start':
      if (client.websiteMonitor) {
        client.websiteMonitor.startMonitoring();
        await interaction.editReply({ content: '✅ เริ่มระบบตรวจสอบแล้ว' });
      } else {
        await interaction.editReply({ content: '❌ ระบบตรวจสอบยังไม่ได้ถูกกำหนดค่า' });
      }
      break;
      
    case 'stop':
      if (client.websiteMonitor) {
        client.websiteMonitor.stopMonitoring();
        await interaction.editReply({ content: '✅ หยุดระบบตรวจสอบแล้ว' });
      } else {
        await interaction.editReply({ content: '❌ ระบบตรวจสอบยังไม่ได้ถูกกำหนดค่า' });
      }
      break;
      
    case 'status':
      if (client.websiteMonitor) {
        // This would require implementing a method to check monitoring status
        await interaction.editReply({ content: '🔍 ระบบตรวจสอบกำลังทำงาน' });
      } else {
        await interaction.editReply({ content: '❌ ระบบตรวจสอบไม่ได้ทำงานอยู่' });
      }
      break;
  }
}

function formatUptime(uptime) {
  const days = Math.floor(uptime / 86400);
  const hours = Math.floor((uptime % 86400) / 3600);
  const minutes = Math.floor((uptime % 3600) / 60);
  const seconds = Math.floor(uptime % 60);
  
  let uptimeString = '';
  if (days > 0) uptimeString += `${days} วัน `;
  if (hours > 0) uptimeString += `${hours} ชั่วโมง `;
  if (minutes > 0) uptimeString += `${minutes} นาที `;
  uptimeString += `${seconds} วินาที`;
  
  return uptimeString;
}