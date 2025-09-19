@echo off
REM deploy-bot.bat - Deployment script for Dedazen Store Discord Bot

echo ========================================
echo Dedazen Store Discord Bot Deployment
echo ========================================

REM Check if Node.js is installed
node --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Node.js is not installed. Please install Node.js v16.11.0 or higher.
    pause
    exit /b 1
)

echo ✅ Node.js is installed
node --version

REM Check if npm is installed
npm --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ npm is not installed. Please install Node.js which includes npm.
    pause
    exit /b 1
)

echo ✅ npm is installed
npm --version

REM Install dependencies
echo.
echo 📦 Installing dependencies...
npm install
if %errorlevel% neq 0 (
    echo ❌ Failed to install dependencies.
    pause
    exit /b 1
)

echo ✅ Dependencies installed successfully

REM Check if .env file exists
if not exist .env (
    echo.
    echo ⚠️  .env file not found. Please create .env file with your configuration.
    echo Example content:
    echo DISCORD_TOKEN=your_discord_bot_token_here
    echo CLIENT_ID=your_discord_client_id_here
    echo GUILD_ID=your_guild_id_here
    echo ADMIN_ROLE_ID=your_admin_role_id_here
    echo DB_HOST=localhost
    echo DB_USER=root
    echo DB_PASSWORD=
    echo DB_NAME=kakarotc_demo
    echo WEBSITE_URL=http://localhost
    echo CHECK_INTERVAL=300000
    pause
    exit /b 1
)

echo ✅ .env file found

REM Create logs directory if it doesn't exist
if not exist logs (
    mkdir logs
    echo ✅ Created logs directory
)

echo.
echo 🚀 Starting the bot...
node index.js

echo.
echo Bot deployment completed.
pause