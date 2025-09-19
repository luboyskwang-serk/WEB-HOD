// Command: /ping - Test bot connectivity
const { SlashCommandBuilder, EmbedBuilder } = require('discord.js');

module.exports = {
    data: new SlashCommandBuilder()
        .setName('ping')
        .setDescription('ทดสอบการเชื่อมต่อ'),
    async execute(interaction) {
        // Calculate ping
        const sent = await interaction.deferReply({ fetchReply: true });
        const latency = sent.createdTimestamp - interaction.createdTimestamp;
        
        try {
            // Create embed with ping information
            const embed = new EmbedBuilder()
                .setTitle('🏓 Pong!')
                .setDescription('ทดสอบการเชื่อมต่อสำเร็จ')
                .setColor(0x3498db)
                .addFields(
                    { name: '📡 Latency', value: `${latency}ms`, inline: true },
                    { name: '💾 WebSocket', value: `${interaction.client.ws.ping}ms`, inline: true },
                    { name: '⏱️ Response Time', value: `${Date.now() - interaction.createdTimestamp}ms`, inline: true }
                )
                .setTimestamp()
                .setFooter({ text: 'Dedazen Store Bot', iconURL: interaction.client.user.displayAvatarURL() });

            await interaction.editReply({ embeds: [embed] });
        } catch (error) {
            console.error('Error in ping command:', error);
            await interaction.editReply({ content: `🏓 Pong! Latency: ${latency}ms` });
        }
    },
};