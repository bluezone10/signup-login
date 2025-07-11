-- ====================================
-- SIMPLE CATERING SERVICE DATABASE
-- ====================================

-- Create database (run this first)
-- CREATE DATABASE IF NOT EXISTS catering;
-- USE catering;

-- ====================================
-- USERS TABLE (Essential)
-- ====================================

-- Create users table - the only table needed for login/signup
CREATE TABLE IF NOT EXISTS users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email_verified TINYINT(1) DEFAULT 0,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    PRIMARY KEY (id),
    INDEX idx_email (email),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ====================================
-- SAMPLE USER (Optional for testing)
-- ====================================

-- Uncomment to create a test user
-- Password is 'password123' (hashed)
/*
INSERT INTO users (first_name, last_name, email, phone, password) VALUES 
('John', 'Doe', 'john@example.com', '1234567890', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
*/

-- ====================================
-- SHOW CREATED TABLES
-- ====================================

SHOW TABLES; 