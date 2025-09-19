const cron = require('node-cron');
const logger = require('../utils/logger');

class ScheduledReports {
  constructor(client) {
    this.client = client;
    this.scheduledTasks = [];
  }

  // Schedule a daily report
  scheduleDailyReport(channelId, time = '0 9 * * *') { // Default: 9 AM daily
    const task = cron.schedule(time, async () => {
      try {
        const channel = await this.client.channels.fetch(channelId);
        // Here you would call your report generation function
        // await generateDailyReport(channel);
        logger.info('Daily report sent');
      } catch (error) {
        logger.error('Failed to send daily report:', error);
      }
    });
    
    this.scheduledTasks.push({
      id: `daily-${channelId}`,
      task,
      type: 'daily',
      channelId,
      time
    });
    
    logger.info(`Daily report scheduled for channel ${channelId} at ${time}`);
  }

  // Schedule a weekly report
  scheduleWeeklyReport(channelId, time = '0 9 * * 1') { // Default: 9 AM every Monday
    const task = cron.schedule(time, async () => {
      try {
        const channel = await this.client.channels.fetch(channelId);
        // Here you would call your report generation function
        // await generateWeeklyReport(channel);
        logger.info('Weekly report sent');
      } catch (error) {
        logger.error('Failed to send weekly report:', error);
      }
    });
    
    this.scheduledTasks.push({
      id: `weekly-${channelId}`,
      task,
      type: 'weekly',
      channelId,
      time
    });
    
    logger.info(`Weekly report scheduled for channel ${channelId} at ${time}`);
  }

  // Cancel a scheduled task
  cancelScheduledTask(taskId) {
    const taskIndex = this.scheduledTasks.findIndex(t => t.id === taskId);
    if (taskIndex !== -1) {
      this.scheduledTasks[taskIndex].task.stop();
      this.scheduledTasks.splice(taskIndex, 1);
      logger.info(`Scheduled task ${taskId} cancelled`);
      return true;
    }
    return false;
  }

  // Get all scheduled tasks
  getScheduledTasks() {
    return this.scheduledTasks.map(task => ({
      id: task.id,
      type: task.type,
      channelId: task.channelId,
      time: task.time,
      running: task.task.running
    }));
  }
}

module.exports = ScheduledReports;