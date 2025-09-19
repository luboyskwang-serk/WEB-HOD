// test-bot.js - Test script for the Discord bot components
const path = require('path');
require('dotenv').config({ path: path.join(__dirname, '.env') });

async function runTests() {
  console.log('🧪 Starting Dedazen Store Discord Bot Tests...\n');
  
  try {
    // Test 1: Database connection
    console.log('1. Testing database connection...');
    const { connectToDatabase } = require('./database');
    const db = await connectToDatabase();
    console.log('✅ Database connection successful\n');
    
    // Test 2: Website monitor initialization
    console.log('2. Testing website monitor initialization...');
    const WebsiteMonitor = require('./monitoring/website');
    const monitor = new WebsiteMonitor({ database: db }, db);
    console.log('✅ Website monitor initialized\n');
    
    // Test 3: Alert system initialization
    console.log('3. Testing alert system initialization...');
    const AlertSystem = require('./monitoring/alerts');
    const alertSystem = new AlertSystem({});
    console.log('✅ Alert system initialized\n');
    
    // Test 4: Logger functionality
    console.log('4. Testing logger functionality...');
    const logger = require('./utils/logger');
    logger.info('Logger test message');
    logger.warn('Logger warning message');
    console.log('✅ Logger functionality working\n');
    
    // Test 5: Database functions
    console.log('5. Testing database functions...');
    const { getWebsiteStats } = require('./database');
    const stats = await getWebsiteStats(db);
    console.log(`✅ Database functions working - Found ${stats.users} users\n`);
    
    // Close database connection
    await db.end();
    console.log('✅ Database connection closed\n');
    
    console.log('🎉 All tests passed! The bot is ready for deployment.');
    
  } catch (error) {
    console.error('❌ Test failed:', error.message);
    process.exit(1);
  }
}

// Run tests if this file is executed directly
if (require.main === module) {
  runTests();
}

module.exports = { runTests };