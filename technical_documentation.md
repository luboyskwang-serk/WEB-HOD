# Dedazen Store - Technical Documentation

## Project Overview
This is a PHP-based e-commerce platform for selling digital products, primarily gaming accounts and digital services. The system includes user management, product catalog, payment processing, and order fulfillment.

## Technology Stack
- **Backend**: PHP 8+ with PDO for database access
- **Database**: MySQL/MariaDB
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5, jQuery
- **Security**: reCAPTCHA v2, Session-based authentication
- **Payment Integration**: Truemoney Wallet API, QR Payment systems

## Project Structure
```
htdocs/
├── assets/              # Static assets (images, CSS, JS)
├── auth/                # Authentication integrations (Discord, Line)
├── dz/                  # Custom assets and images
├── include/             # Shared components
├── page/                # Page templates
├── system/              # Core backend functionality
├── index.php            # Main entry point
├── data.php             # Configuration
└── kakarotc_demo.sql    # Database schema
```

## Database Schema

### Users Table (`users`)
Stores user account information:
- `id` (int, primary): Unique user identifier
- `username` (varchar): User's login name
- `password` (varchar): MD5 hashed password (security concern)
- `email` (varchar): User's email address
- `point` (float): User's credit balance
- `total` (float): Total amount user has topped up
- `rank` (int): User role (0=user, 1=admin)
- `profile` (text): URL to profile image
- `date` (date): Registration date

### Products Table (`box_product`)
Stores product information:
- `id` (int, primary): Product identifier
- `name` (varchar): Product name
- `price` (int): Regular price
- `price_vip` (int): Discounted price for VIP users
- `des` (varchar): Product description
- `img` (varchar): Product image URL
- `type` (int): Product type (0=random, 1=stock)
- `percent` (int): Success rate for random products
- `salt_prize` (varchar): Prize for failed random draws
- `c_type` (varchar): Category type

### Stock Table (`box_stock`)
Stores product stock/inventory:
- `id` (int, primary): Stock item identifier
- `username` (varchar): Account username or item detail
- `password` (int): Account password or item detail
- `p_id` (varchar): Product ID reference

### Order History (`boxlog`)
Records all user purchases:
- `id` (int, primary): Order identifier
- `date` (datetime): Purchase timestamp
- `username` (varchar): User who made purchase
- `category` (varchar): Product category
- `price` (int): Price paid
- `prize_name` (varchar): Item received
- `rand` (int): Result type (0=success, 1=fail, 2=random)
- `uid` (varchar): User ID reference
- `uimg` (text): User profile image

### Settings (`setting`)
Global website configuration:
- `name` (varchar): Website name
- `logo` (varchar): Logo image URL
- `bg` (varchar): Background image URL
- `main_color` (varchar): Primary color scheme
- `sec_color` (varchar): Secondary color scheme
- `wallet` (varchar): Truemoney wallet number
- `discord` (varchar): Discord URL
- `fb` (varchar): Facebook URL
- `lined` (varchar): Line ID

## Core Functionality

### Authentication System
Located in `system/a_func.php`:
- Session-based user authentication
- Database connection management
- Helper functions for queries (`dd_q`)
- User privilege checking

### User Registration (`system/register.php`)
1. Validates reCAPTCHA
2. Checks for duplicate username
3. Creates new user record
4. Automatically logs user in
5. Supports email validation

### User Login (`system/login.php`)
1. Validates username/password
2. Supports both MD5 and SHA256 hashing
3. Sets session variables
4. Redirects to homepage on success

### Product Browsing (`page/shop.php`)
1. Displays products by category
2. Shows product availability
3. Displays pricing (regular/VIP)
4. Search functionality

### Product Purchase (`system/buybox.php`)
1. Validates user balance
2. Checks product availability
3. Processes purchase based on product type:
   - Type 0: Random draw system
   - Type 1: Direct stock allocation
4. Updates user balance
5. Records transaction in `boxlog`
6. Sends Discord webhook notification

### Payment Processing (`system/topup.php`)
1. Integrates with external Truemoney Wallet API
2. Validates gift voucher links
3. Credits user account
4. Records transaction in `topup_his`
5. Sends Line notification

### Profile Management (`page/cimg.php`, `system/changeimg.php`, `system/changepass.php`)
1. Update profile picture via URL
2. Change password functionality
3. View purchase history
4. View account balance and statistics

## API Integrations

### Truemoney Wallet
- Endpoint: External API service
- Function: Process gift voucher payments
- Security: Phone number verification

### Discord Webhooks
- Function: Send purchase notifications
- Configuration: `setting.webhook_dc`

### reCAPTCHA v2
- Function: Prevent bot registration
- Keys stored in `a_func.php`

## Security Considerations

### Current Issues
1. **Password Hashing**: Uses MD5 which is cryptographically broken
2. **Session Management**: Basic implementation without timeout
3. **Input Validation**: Some endpoints lack thorough validation

### Recommended Improvements
1. Migrate to bcrypt or Argon2 for password hashing
2. Implement session timeout and regeneration
3. Add CSRF protection tokens
4. Implement rate limiting for API endpoints
5. Add input sanitization for all user inputs

## Code Standards

### PHP Coding Standards
- Uses PDO for database operations
- Prepared statements for all queries
- Functions follow `dd_` prefix convention
- Error handling with `dd_return()` function

### JavaScript Standards
- jQuery for DOM manipulation
- AJAX for asynchronous operations
- Consistent error handling with SweetAlert

### CSS Standards
- Bootstrap 5 framework
- Custom CSS variables for theming
- Responsive design principles

## Deployment Considerations

### Server Requirements
- PHP 7.4+ with PDO extension
- MySQL 5.7+ or MariaDB 10.3+
- Apache or Nginx web server
- SSL certificate for secure connections
- Write permissions for necessary directories

### Configuration Files
- `system/a_func.php`: Database connection settings
- `data.php`: Additional configuration
- Database: `setting` table for runtime configuration

### Maintenance
- Regular database backups
- Log file monitoring
- Security updates for dependencies
- Performance monitoring

## Common Development Tasks

### Adding New Product Types
1. Modify `box_product` table schema if needed
2. Update `system/buybox.php` with new purchase logic
3. Create new page templates in `page/` directory
4. Update navigation in `index.php`

### Adding Payment Methods
1. Create new handler in `system/` directory
2. Add new UI elements in `page/topup.php`
3. Update payment processing logic
4. Configure new API credentials in database

### Modifying User Roles
1. Update `rank` field logic in database
2. Modify admin checks in page templates
3. Update privilege checks in system functions

## Troubleshooting Guide

### Common Issues
1. **Login Failures**: Check password hashing method
2. **Payment Processing Errors**: Verify API credentials
3. **Database Connection**: Check `a_func.php` configuration
4. **Image Loading**: Verify file permissions and paths

### Error Logs
- PHP error logs
- Web server error logs
- Application-specific logging in database tables

## Future Enhancement Opportunities

1. **Mobile App**: Native mobile application
2. **API Layer**: RESTful API for external integrations
3. **Analytics Dashboard**: Business intelligence features
4. **Multi-language Support**: Internationalization
5. **Advanced Inventory**: Real-time stock management
6. **Subscription System**: Recurring billing features