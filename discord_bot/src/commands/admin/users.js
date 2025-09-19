// Command: /users - Manage users
const { SlashCommandBuilder, EmbedBuilder } = require('discord.js');
const axios = require('axios');

module.exports = {
    data: new SlashCommandBuilder()
        .setName('users')
        .setDescription('จัดการผู้ใช้')
        .addSubcommand(subcommand =>
            subcommand
                .setName('list')
                .setDescription('แสดงรายการผู้ใช้')
                .addIntegerOption(option =>
                    option.setName('page')
                        .setDescription('หน้าที่ต้องการ')
                        .setMinValue(1)
                        .setMaxValue(100)))
        .addSubcommand(subcommand =>
            subcommand
                .setName('info')
                .setDescription('ดูข้อมูลผู้ใช้')
                .addStringOption(option =>
                    option.setName('user_id')
                        .setDescription('ไอดีผู้ใช้')
                        .setRequired(true)))
        .addSubcommand(subcommand =>
            subcommand
                .setName('ban')
                .setDescription('แบนผู้ใช้')
                .addStringOption(option =>
                    option.setName('user_id')
                        .setDescription('ไอดีผู้ใช้')
                        .setRequired(true))
                .addStringOption(option =>
                    option.setName('reason')
                        .setDescription('เหตุผล')))
        .addSubcommand(subcommand =>
            subcommand
                .setName('unban')
                .setDescription('ปลดแบนผู้ใช้')
                .addStringOption(option =>
                    option.setName('user_id')
                        .setDescription('ไอดีผู้ใช้')
                        .setRequired(true))),
    permissions: {
        adminOnly: true
    },
    async execute(interaction) {
        const subcommand = interaction.options.getSubcommand();
        
        switch (subcommand) {
            case 'list':
                await handleListUsers(interaction);
                break;
            case 'info':
                await handleUserInfo(interaction);
                break;
            case 'ban':
                await handleBanUser(interaction);
                break;
            case 'unban':
                await handleUnbanUser(interaction);
                break;
        }
    },
};

// Handle list users
async function handleListUsers(interaction) {
    await interaction.deferReply();
    
    try {
        const page = interaction.options.getInteger('page') || 1;
        
        // Get users from API (mock implementation)
        const users = await getUsers(page);
        
        const embed = new EmbedBuilder()
            .setTitle('👥 รายการผู้ใช้')
            .setDescription(`หน้า ${page}`)
            .setColor(0x3498db)
            .setTimestamp();
            
        if (users.length > 0) {
            const userList = users.map(user => 
                `**${user.username}** (ID: ${user.id})\n` +
                `สถานะ: ${user.rank === 1 ? 'แอดมิน' : 'ผู้ใช้'} | ` +
                `เครดิต: ${user.point} | ` +
                `ลงทะเบียน: ${new Date(user.date).toLocaleDateString('th-TH')}`
            ).join('\n\n');
            
            embed.addFields({ name: 'ผู้ใช้ทั้งหมด', value: userList, inline: false });
        } else {
            embed.addFields({ name: 'ไม่พบผู้ใช้', value: 'ไม่มีผู้ใช้ในระบบ', inline: false });
        }
        
        await interaction.editReply({ embeds: [embed] });
    } catch (error) {
        console.error('Error in users list:', error);
        await interaction.editReply({ content: 'เกิดข้อผิดพลาดในการดึงรายการผู้ใช้' });
    }
}

// Handle user info
async function handleUserInfo(interaction) {
    await interaction.deferReply();
    
    try {
        const userId = interaction.options.getString('user_id');
        
        // Get user info from API (mock implementation)
        const user = await getUserInfo(userId);
        
        if (!user) {
            await interaction.editReply({ content: 'ไม่พบผู้ใช้ที่ระบุ' });
            return;
        }
        
        const embed = new EmbedBuilder()
            .setTitle('👤 ข้อมูลผู้ใช้')
            .setColor(0x2ecc71)
            .addFields(
                { name: 'ชื่อผู้ใช้', value: user.username, inline: true },
                { name: 'ไอดี', value: user.id.toString(), inline: true },
                { name: 'อีเมล', value: user.email || 'ไม่ระบุ', inline: true },
                { name: 'สถานะ', value: user.rank === 1 ? 'แอดมิน' : 'ผู้ใช้', inline: true },
                { name: 'เครดิต', value: `${user.point} บาท`, inline: true },
                { name: 'ยอดเติมเงินรวม', value: `${user.total} บาท`, inline: true },
                { name: 'วันที่ลงทะเบียน', value: new Date(user.date).toLocaleDateString('th-TH'), inline: true }
            )
            .setTimestamp();
            
        await interaction.editReply({ embeds: [embed] });
    } catch (error) {
        console.error('Error in user info:', error);
        await interaction.editReply({ content: 'เกิดข้อผิดพลาดในการดึงข้อมูลผู้ใช้' });
    }
}

// Handle ban user
async function handleBanUser(interaction) {
    await interaction.deferReply();
    
    try {
        const userId = interaction.options.getString('user_id');
        const reason = interaction.options.getString('reason') || 'ไม่ระบุเหตุผล';
        
        // Ban user via API (mock implementation)
        const result = await banUser(userId, reason);
        
        if (result.success) {
            const embed = new EmbedBuilder()
                .setTitle('🔨 แบนผู้ใช้สำเร็จ')
                .setDescription(`ผู้ใช้ ID: ${userId} ถูกแบนเรียบร้อยแล้ว`)
                .addFields(
                    { name: 'เหตุผล', value: reason, inline: false },
                    { name: 'ดำเนินการโดย', value: `<@${interaction.user.id}>`, inline: false }
                )
                .setColor(0xe74c3c)
                .setTimestamp();
                
            await interaction.editReply({ embeds: [embed] });
        } else {
            await interaction.editReply({ content: `ไม่สามารถแบนผู้ใช้ได้: ${result.message}` });
        }
    } catch (error) {
        console.error('Error in ban user:', error);
        await interaction.editReply({ content: 'เกิดข้อผิดพลาดในการแบนผู้ใช้' });
    }
}

// Handle unban user
async function handleUnbanUser(interaction) {
    await interaction.deferReply();
    
    try {
        const userId = interaction.options.getString('user_id');
        
        // Unban user via API (mock implementation)
        const result = await unbanUser(userId);
        
        if (result.success) {
            const embed = new EmbedBuilder()
                .setTitle('✅ ปลดแบนผู้ใช้สำเร็จ')
                .setDescription(`ผู้ใช้ ID: ${userId} ถูกปลดแบนเรียบร้อยแล้ว`)
                .addFields(
                    { name: 'ดำเนินการโดย', value: `<@${interaction.user.id}>`, inline: false }
                )
                .setColor(0x2ecc71)
                .setTimestamp();
                
            await interaction.editReply({ embeds: [embed] });
        } else {
            await interaction.editReply({ content: `ไม่สามารถปลดแบนผู้ใช้ได้: ${result.message}` });
        }
    } catch (error) {
        console.error('Error in unban user:', error);
        await interaction.editReply({ content: 'เกิดข้อผิดพลาดในการปลดแบนผู้ใช้' });
    }
}

// Mock API functions (replace with actual implementations)
async function getUsers(page = 1) {
    // Mock implementation
    return [
        { id: 1, username: 'admin', email: 'admin@example.com', rank: 1, point: 1000, total: 5000, date: '2023-01-01' },
        { id: 2, username: 'user1', email: 'user1@example.com', rank: 0, point: 500, total: 1000, date: '2023-01-15' },
        { id: 3, username: 'user2', email: 'user2@example.com', rank: 0, point: 250, total: 750, date: '2023-02-01' }
    ];
}

async function getUserInfo(userId) {
    // Mock implementation
    if (userId === '1') {
        return { id: 1, username: 'admin', email: 'admin@example.com', rank: 1, point: 1000, total: 5000, date: '2023-01-01' };
    } else if (userId === '2') {
        return { id: 2, username: 'user1', email: 'user1@example.com', rank: 0, point: 500, total: 1000, date: '2023-01-15' };
    }
    return null;
}

async function banUser(userId, reason) {
    // Mock implementation
    console.log(`Banning user ${userId} for reason: ${reason}`);
    return { success: true, message: 'User banned successfully' };
}

async function unbanUser(userId) {
    // Mock implementation
    console.log(`Unbanning user ${userId}`);
    return { success: true, message: 'User unbanned successfully' };
}