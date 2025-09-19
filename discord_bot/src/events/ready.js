// Event handler for when the bot is ready
module.exports = {
    name: 'ready',
    once: true,
    execute(client) {
        console.log(`Ready! Logged in as ${client.user.tag}`);
        
        // Set bot status
        client.user.setActivity('Dedazen Store', { type: 'WATCHING' });
        
        // Log ready event
        console.log(`[${new Date().toISOString()}] Bot is ready and operational`);
    },
};