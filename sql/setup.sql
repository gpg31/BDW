CREATE DATABASE blood_donation;

USE blood_donation;

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'donor', 'recipient', 'hospital_staff') NOT NULL
);

-- Donations Table
CREATE TABLE donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    blood_type VARCHAR(10) NOT NULL,
    quantity INT NOT NULL,
    donation_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Requests Table
CREATE TABLE requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipient_id INT,
    blood_type VARCHAR(10) NOT NULL,
    quantity INT NOT NULL,
    request_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'fulfilled') DEFAULT 'pending',
    FOREIGN KEY (recipient_id) REFERENCES users(id)
);
