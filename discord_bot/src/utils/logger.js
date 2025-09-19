// Logger utility using Winston
const winston = require('winston');
const path = require('path');

// Create logs directory if it doesn't exist
const fs = require('fs');
const logsDir = path.join(__dirname, '../../logs');
if (!fs.existsSync(logsDir)) {
    fs.mkdirSync(logsDir, { recursive: true });
}

// Create Winston logger
const logger = winston.createLogger({
    level: process.env.LOG_LEVEL || 'info',
    format: winston.format.combine(
        winston.format.timestamp({
            format: 'YYYY-MM-DD HH:mm:ss'
        }),
        winston.format.errors({ stack: true }),
        winston.format.splat(),
        winston.format.json()
    ),
    defaultMeta: { service: 'dedazen-store-bot' },
    transports: [
        // Write all logs with level `error` and below to `error.log`
        new winston.transports.File({
            filename: path.join(logsDir, 'error.log'),
            level: 'error',
            maxsize: 5242880, // 5MB
            maxFiles: 5
        }),
        
        // Write all logs with level `info` and below to `combined.log`
        new winston.transports.File({
            filename: path.join(logsDir, 'combined.log'),
            maxsize: 5242880, // 5MB
            maxFiles: 5
        }),
        
        // Write to console in development
        new winston.transports.Console({
            format: winston.format.combine(
                winston.format.colorize(),
                winston.format.simple()
            )
        })
    ]
});

// Export logger functions
module.exports = {
    info: (message, meta) => logger.info(message, meta),
    warn: (message, meta) => logger.warn(message, meta),
    error: (message, meta) => logger.error(message, meta),
    debug: (message, meta) => logger.debug(message, meta),
    
    // Log command usage
    command: (commandName, userId, guildId, options = {}) => {
        logger.info('COMMAND_EXECUTED', {
            command: commandName,
            user: userId,
            guild: guildId,
            options: options,
            timestamp: new Date().toISOString()
        });
    },
    
    // Log API calls
    apiCall: (method, endpoint, status, duration) => {
        logger.info('API_CALL', {
            method: method,
            endpoint: endpoint,
            status: status,
            duration: duration,
            timestamp: new Date().toISOString()
        });
    },
    
    // Log user actions
    userAction: (action, userId, details = {}) => {
        logger.info('USER_ACTION', {
            action: action,
            user: userId,
            details: details,
            timestamp: new Date().toISOString()
        });
    },
    
    // Log system events
    systemEvent: (event, details = {}) => {
        logger.info('SYSTEM_EVENT', {
            event: event,
            details: details,
            timestamp: new Date().toISOString()
        });
    }
};