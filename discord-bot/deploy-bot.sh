#!/bin/bash

# deploy-bot.sh - Deployment script for Dedazen Store Discord Bot (Linux/Mac)

echo "========================================"
echo "Dedazen Store Discord Bot Deployment"
echo "========================================"

# Check if Node.js is installed
if ! command -v node &> /dev/null
then
    echo "❌ Node.js is not installed. Please install Node.js v16.11.0 or higher."
    exit 1
fi

echo "✅ Node.js is installed"
node --version

# Check if npm is installed
if ! command -v npm &> /dev/null
then
    echo "❌ npm is not installed. Please install Node.js which includes npm."
    exit 1
fi

echo "✅ npm is installed"
npm --version

# Install dependencies
echo ""
echo "📦 Installing dependencies..."
npm install
if [ $? -ne 0 ]; then
    echo "❌ Failed to install dependencies."
    exit 1
fi

echo "✅ Dependencies installed successfully"

# Check if .env file exists
if [ ! -f .env ]; then
    echo ""
    echo "⚠️  .env file not found. Please create .env file with your configuration."
    echo "Example content:"
    echo "DISCORD_TOKEN=your_discord_bot_token_here"
    echo "CLIENT_ID=your_discord_client_id_here"
    echo "GUILD_ID=your_guild_id_here"
    echo "ADMIN_ROLE_ID=your_admin_role_id_here"
    echo "DB_HOST=localhost"
    echo "DB_USER=root"
    echo "DB_PASSWORD="
    echo "DB_NAME=kakarotc_demo"
    echo "WEBSITE_URL=http://localhost"
    echo "CHECK_INTERVAL=300000"
    exit 1
fi

echo "✅ .env file found"

# Create logs directory if it doesn't exist
if [ ! -d "logs" ]; then
    mkdir logs
    echo "✅ Created logs directory"
fi

echo ""
echo "🚀 Starting the bot..."
node index.js

echo ""
echo "Bot deployment completed."