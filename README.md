# Catering Service - Signup System

A modern, responsive signup system built with Bootstrap 5, jQuery AJAX, and object-oriented PHP backend.

## 🚀 Features

- **Beautiful UI**: Modern Bootstrap 5 design with white text theme
- **AJAX Form Submission**: Seamless user experience without page reloads
- **Real-time Validation**: Client-side and server-side validation
- **OOP Backend**: Well-structured PHP classes using modern practices
- **Secure**: Password hashing, SQL injection prevention, input sanitization
- **Responsive**: Works perfectly on desktop and mobile devices

## 📁 Project Structure

```
ecommerce/
├── config/
│   └── Database.php           # Database connection class (Singleton)
├── models/
│   └── User.php              # User model with OOP methods
├── api/
│   ├── BaseAPI.php           # Base API class for common functionality
│   └── signup.php            # Signup API endpoint
├── assets/
│   ├── css/
│   │   └── style.css         # Custom CSS styles
│   ├── js/
│   │   └── script.js         # jQuery/AJAX functionality
│   ├── images/               # Image assets (placeholder)
│   ├── fonts/                # Font assets (placeholder)
│   └── README.md             # Assets documentation
├── signup.php                # Frontend signup form
├── 404.php                   # Custom 404 error page
├── 403.php                   # Custom 403 error page
├── .htaccess                 # URL rewriting and security
├── create_database.sql       # Database schema
└── README.md                 # This file
```

## 🛠️ Installation & Setup

### 1. Database Setup

```sql
-- Create database
CREATE DATABASE catering;

-- Run the SQL script
mysql -u root -p catering < create_database.sql
```

### 2. Configuration

Update database credentials in `config/Database.php`:

```php
private $host = 'localhost';
private $username = 'your_username';
private $password = 'your_password';
private $database = 'catering';
```

### 3. Web Server Setup

- Place files in your web server directory (e.g., `htdocs`, `www`)
- Ensure PHP 7.4+ with mysqli extension
- Access `signup.php` in your browser

## 🏗️ Architecture Overview

### Database Layer (`config/Database.php`)
- **Singleton Pattern**: Ensures single database connection
- **Prepared Statements**: Prevents SQL injection
- **Transaction Support**: For complex operations
- **Error Handling**: Comprehensive error logging

### Model Layer (`models/User.php`)
- **OOP Design**: Clean, maintainable code structure
- **Validation**: Built-in data validation methods
- **Security**: Password hashing, input sanitization
- **CRUD Operations**: Create, read, update, delete users

### API Layer (`api/`)
- **RESTful Design**: Clean API endpoints
- **JSON Responses**: Structured response format
- **Error Handling**: Proper HTTP status codes
- **Rate Limiting**: Basic protection against abuse

### Frontend Layer
- **Bootstrap 5**: Modern, responsive UI components
- **jQuery**: Enhanced user interactions
- **AJAX**: Asynchronous form submission
- **Real-time Validation**: Immediate user feedback

## 📊 Database Schema

### Users Table
```sql
CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email_verified TINYINT(1) DEFAULT 0,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL
);
```

## 🔧 API Endpoints

### POST `/api/signup.php`

**Create User Account**
```json
{
    "action": "signup",
    "firstName": "John",
    "lastName": "Doe",
    "email": "john@example.com",
    "phone": "(555) 123-4567",
    "password": "securepass123"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Account created successfully!",
    "timestamp": "2024-01-15T10:30:00+00:00",
    "data": {
        "user": {
            "id": 1,
            "fullName": "John Doe",
            "email": "john@example.com"
        },
        "redirect": "dashboard.php"
    }
}
```

**Check Email Availability**
```json
{
    "action": "check_email",
    "email": "john@example.com"
}
```

## 🎨 Frontend Features

### Design Elements
- **Gradient Background**: Modern purple gradient
- **Glass Morphism**: Semi-transparent form with backdrop blur
- **White Text Theme**: Consistent white text throughout
- **Icons**: Font Awesome icons for better UX
- **Animations**: Smooth transitions and hover effects

### Form Features
- **Real-time Validation**: Instant feedback on input
- **Password Toggle**: Show/hide password functionality
- **Phone Formatting**: Auto-format phone numbers
- **Email Check**: Real-time email availability checking
- **Loading States**: Visual feedback during submission

### Responsive Design
- **Mobile First**: Optimized for all screen sizes
- **Bootstrap Grid**: Responsive layout system
- **Touch Friendly**: Large buttons and inputs for mobile

## 🔒 Security Features

### Input Validation
- **Client-side**: JavaScript validation for immediate feedback
- **Server-side**: PHP validation for security
- **Sanitization**: All inputs are sanitized before processing

### Password Security
- **Hashing**: PHP `password_hash()` with default algorithm
- **Strength Requirements**: Minimum 8 characters, letters and numbers
- **Confirmation**: Password confirmation matching

### SQL Security
- **Prepared Statements**: All queries use prepared statements
- **Input Escaping**: Additional escaping for safety
- **Error Handling**: Secure error messages without exposing internals

## 📱 Browser Support

- **Chrome**: 80+
- **Firefox**: 75+
- **Safari**: 13+
- **Edge**: 80+
- **Mobile**: iOS Safari 13+, Chrome Mobile 80+

## 🚀 Future Enhancements

- [ ] Email verification system
- [ ] Password reset functionality
- [ ] OAuth integration (Google, Facebook)
- [ ] Two-factor authentication
- [ ] User profile management
- [ ] Admin dashboard
- [ ] Email templates
- [ ] Advanced rate limiting with Redis

## 📄 License

This project is open source and available under the [MIT License](LICENSE).

## 🤝 Contributing

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📞 Support

For support, email admin@catering.com or create an issue in the project repository. 