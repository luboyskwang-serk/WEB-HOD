// Event handler for interaction creation (slash commands)
module.exports = {
    name: 'interactionCreate',
    execute(interaction) {
        // This is handled in the main index.js file
        // This file exists to show the event structure
        console.log(`Interaction received: ${interaction.type}`);
    },
};