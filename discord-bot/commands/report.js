const { SlashCommandBuilder, EmbedBuilder } = require('discord.js');
const { getWebsiteStats, getRecentActivities } = require('../database');
const logger = require('../utils/logger');

module.exports = {
  data: new SlashCommandBuilder()
    .setName('report')
    .setDescription('สร้างรายงานโดยละเอียดเกี่ยวกับเว็บไซต์')
    .addStringOption(option =>
      option.setName('type')
        .setDescription('ประเภทของรายงาน')
        .setRequired(false)
        .addChoices(
          { name: 'สถิติทั่วไป', value: 'stats' },
          { name: 'กิจกรรมล่าสุด', value: 'activity' },
          { name: 'รายงานเต็มรูปแบบ', value: 'full' }
        )),
  
  async execute(interaction, client) {
    try {
      await interaction.deferReply();
      
      // Get report type
      const reportType = interaction.options.getString('type') || 'stats';
      
      // Get database connection
      const database = client.database;
      
      switch (reportType) {
        case 'stats':
          await generateStatsReport(interaction, database);
          break;
        case 'activity':
          await generateActivityReport(interaction, database);
          break;
        case 'full':
          await generateFullReport(interaction, database);
          break;
      }
    } catch (error) {
      logger.error('Error in report command:', error);
      await interaction.editReply({ content: '❌ เกิดข้อผิดพลาดในการสร้างรายงาน' });
    }
  }
};

async function generateStatsReport(interaction, database) {
  try {
    // Get website statistics
    const stats = await getWebsiteStats(database);
    
    // Get recent activities count
    const [recentTopups] = await database.execute(
      'SELECT COUNT(*) as count FROM topup_his WHERE date >= DATE_SUB(NOW(), INTERVAL 24 HOUR)'
    );
    
    const [recentOrders] = await database.execute(
      'SELECT COUNT(*) as count FROM boxlog WHERE date >= DATE_SUB(NOW(), INTERVAL 24 HOUR)'
    );
    
    // Get user statistics
    const [newUsers] = await database.execute(
      'SELECT COUNT(*) as count FROM users WHERE date >= DATE_SUB(NOW(), INTERVAL 7 DAY)'
    );
    
    const [vipUsers] = await database.execute(
      'SELECT COUNT(*) as count FROM users WHERE vip_role = 1'
    );
    
    // Create embed
    const embed = new EmbedBuilder()
      .setTitle('📊 รายงานสถิติเว็บไซต์ Dedazen Store')
      .setColor(0x0099ff)
      .addFields(
        { name: '👥 ผู้ใช้ทั้งหมด', value: `${stats.users.toLocaleString()} คน`, inline: true },
        { name: '👑 สมาชิก VIP', value: `${vipUsers[0].count.toLocaleString()} คน`, inline: true },
        { name: '📦 สินค้าทั้งหมด', value: `${stats.products.toLocaleString()} รายการ`, inline: true },
        { name: '🛒 คำสั่งซื้อทั้งหมด', value: `${stats.orders.toLocaleString()} รายการ`, inline: true },
        { name: '💳 การเติมเงินทั้งหมด', value: `${stats.topups.toLocaleString()} รายการ`, inline: true },
        { name: '💰 รายได้ทั้งหมด', value: `${parseFloat(stats.revenue).toLocaleString('th-TH', { style: 'currency', currency: 'THB' })}`, inline: true },
        { name: '\u200B', value: '\u200B', inline: false },
        { name: '📈 สถิติ 24 ชั่วโมงที่ผ่านมา', value: `เติมเงิน: ${recentTopups[0].count} รายการ
สั่งซื้อ: ${recentOrders[0].count} รายการ`, inline: true },
        { name: '🆕 ผู้ใช้ใหม่ (7 วัน)', value: `${newUsers[0].count} คน`, inline: true }
      )
      .setTimestamp()
      .setFooter({ text: 'Dedazen Store Monitoring Bot' });
    
    await interaction.editReply({ embeds: [embed] });
  } catch (error) {
    logger.error('Error generating stats report:', error);
    throw error;
  }
}

async function generateActivityReport(interaction, database) {
  try {
    // Get recent activities
    const activities = await getRecentActivities(database, 15);
    
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
        value: `ผู้ใช้: ${activity.username}
จำนวน: ${value}
เวลา: <t:${Math.floor(new Date(activity.timestamp).getTime() / 1000)}:R>`,
        inline: false
      };
    });
    
    // Create embed
    const embed = new EmbedBuilder()
      .setTitle('🕒 รายงานกิจกรรมล่าสุด')
      .setColor(0xff9900)
      .setDescription(`แสดง ${Math.min(activities.length, 10)} กิจกรรมล่าสุด`)
      .addFields(activityFields)
      .setTimestamp()
      .setFooter({ text: 'Dedazen Store Monitoring Bot' });
    
    await interaction.editReply({ embeds: [embed] });
  } catch (error) {
    logger.error('Error generating activity report:', error);
    throw error;
  }
}

async function generateFullReport(interaction, database) {
  try {
    // This would be a comprehensive report combining all information
    // For now, we'll just generate the stats report as an example
    await generateStatsReport(interaction, database);
    
    // In a full implementation, you would add:
    // - Detailed user statistics
    // - Product performance reports
    // - Financial summaries
    // - Trend analysis
    // - System health metrics
  } catch (error) {
    logger.error('Error generating full report:', error);
    throw error;
  }
}