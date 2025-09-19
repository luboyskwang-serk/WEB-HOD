const mysql = require('mysql2/promise');
const logger = require('./logger');

async function connectToDatabase() {
  try {
    const connection = await mysql.createConnection({
      host: process.env.DB_HOST,
      user: process.env.DB_USER,
      password: process.env.DB_PASSWORD,
      database: process.env.DB_NAME,
      timezone: '+07:00'
    });

    logger.info('Database connected successfully');
    return connection;
  } catch (error) {
    logger.error('Failed to connect to database:', error);
    throw error;
  }
}

// Function to get website statistics
async function getWebsiteStats(connection) {
  try {
    // Get total users
    const [users] = await connection.execute('SELECT COUNT(*) as total FROM users');
    
    // Get total products
    const [products] = await connection.execute('SELECT COUNT(*) as total FROM box_product');
    
    // Get total orders
    const [orders] = await connection.execute('SELECT COUNT(*) as total FROM boxlog');
    
    // Get total topups
    const [topups] = await connection.execute('SELECT COUNT(*) as total FROM topup_his');
    
    // Get total revenue
    const [revenue] = await connection.execute('SELECT SUM(amount) as total FROM topup_his');
    
    return {
      users: users[0].total,
      products: products[0].total,
      orders: orders[0].total,
      topups: topups[0].total,
      revenue: revenue[0].total || 0
    };
  } catch (error) {
    logger.error('Failed to get website stats:', error);
    throw error;
  }
}

// Function to get recent activities
async function getRecentActivities(connection, limit = 10) {
  try {
    const [activities] = await connection.execute(`
      SELECT 'topup' as type, id, uname as username, amount as value, date as timestamp
      FROM topup_his
      ORDER BY date DESC
      LIMIT ?
      
      UNION ALL
      
      SELECT 'order' as type, id, username, price as value, date as timestamp
      FROM boxlog
      ORDER BY timestamp DESC
      LIMIT ?
    `, [limit, limit]);
    
    return activities;
  } catch (error) {
    logger.error('Failed to get recent activities:', error);
    throw error;
  }
}

// Function to get user information
async function getUserInfo(connection, userId) {
  try {
    const [user] = await connection.execute('SELECT * FROM users WHERE id = ?', [userId]);
    return user[0];
  } catch (error) {
    logger.error('Failed to get user info:', error);
    throw error;
  }
}

// Function to get product information
async function getProductInfo(connection, productId) {
  try {
    const [product] = await connection.execute('SELECT * FROM box_product WHERE id = ?', [productId]);
    return product[0];
  } catch (error) {
    logger.error('Failed to get product info:', error);
    throw error;
  }
}

// Function to update user points
async function updateUserPoints(connection, userId, points) {
  try {
    await connection.execute('UPDATE users SET point = point + ? WHERE id = ?', [points, userId]);
    return true;
  } catch (error) {
    logger.error('Failed to update user points:', error);
    throw error;
  }
}

module.exports = {
  connectToDatabase,
  getWebsiteStats,
  getRecentActivities,
  getUserInfo,
  getProductInfo,
  updateUserPoints
};