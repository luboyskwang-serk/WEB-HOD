// Utility functions for API interactions
const axios = require('axios');
const winston = require('winston');

// Create axios instance with default configuration
const apiClient = axios.create({
    baseURL: process.env.API_BASE_URL || 'https://yourwebsite.com/api',
    timeout: 10000,
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
});

// Add authentication token to requests if available
const apiToken = process.env.API_TOKEN;
if (apiToken) {
    apiClient.defaults.headers.common['Authorization'] = `Bearer ${apiToken}`;
}

// Request interceptor for logging
apiClient.interceptors.request.use(
    config => {
        winston.info(`API Request: ${config.method?.toUpperCase()} ${config.url}`);
        return config;
    },
    error => {
        winston.error('API Request Error:', error);
        return Promise.reject(error);
    }
);

// Response interceptor for logging
apiClient.interceptors.response.use(
    response => {
        winston.info(`API Response: ${response.status} ${response.config.url}`);
        return response;
    },
    error => {
        winston.error('API Response Error:', {
            url: error.config?.url,
            method: error.config?.method,
            status: error.response?.status,
            data: error.response?.data
        });
        return Promise.reject(error);
    }
);

// Generic API call function
async function apiCall(method, endpoint, data = null, config = {}) {
    try {
        const response = await apiClient({
            method,
            url: endpoint,
            data,
            ...config
        });
        return response.data;
    } catch (error) {
        throw new Error(`API call failed: ${error.message}`);
    }
}

// Specific API functions
const api = {
    // Get store statistics
    async getStats(period = 'today') {
        return await apiCall('GET', `/stats/${period}`);
    },
    
    // Get users
    async getUsers(page = 1, limit = 10) {
        return await apiCall('GET', `/users?page=${page}&limit=${limit}`);
    },
    
    // Get user by ID
    async getUser(id) {
        return await apiCall('GET', `/users/${id}`);
    },
    
    // Ban user
    async banUser(id, reason) {
        return await apiCall('POST', `/users/${id}/ban`, { reason });
    },
    
    // Unban user
    async unbanUser(id) {
        return await apiCall('POST', `/users/${id}/unban`);
    },
    
    // Get products
    async getProducts(category = null, page = 1, limit = 10) {
        const params = new URLSearchParams({ page, limit });
        if (category) params.append('category', category);
        return await apiCall('GET', `/products?${params}`);
    },
    
    // Get product by ID
    async getProduct(id) {
        return await apiCall('GET', `/products/${id}`);
    },
    
    // Create product
    async createProduct(data) {
        return await apiCall('POST', '/products', data);
    },
    
    // Update product
    async updateProduct(id, data) {
        return await apiCall('PUT', `/products/${id}`, data);
    },
    
    // Delete product
    async deleteProduct(id) {
        return await apiCall('DELETE', `/products/${id}`);
    },
    
    // Get recent orders
    async getRecentOrders(limit = 10) {
        return await apiCall('GET', `/orders/recent?limit=${limit}`);
    },
    
    // Get recent topups
    async getRecentTopups(limit = 10) {
        return await apiCall('GET', `/topups/recent?limit=${limit}`);
    },
    
    // Get inventory status
    async getInventory(threshold = 10) {
        return await apiCall('GET', `/inventory/low?threshold=${threshold}`);
    },
    
    // Update inventory
    async updateInventory(productId, quantity) {
        return await apiCall('POST', `/inventory/${productId}`, { quantity });
    },
    
    // Get reports
    async getReports(type = 'daily', startDate = null, endDate = null) {
        const params = new URLSearchParams({ type });
        if (startDate) params.append('start_date', startDate);
        if (endDate) params.append('end_date', endDate);
        return await apiCall('GET', `/reports?${params}`);
    }
};

module.exports = api;