CREATE DATABASE christian_daily_devotion;

USE christian_daily_devotion;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255)
);

-- Devotions table
CREATE TABLE devotions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    scripture VARCHAR(50),
    content TEXT,
    devotion_date DATE
);

-- User progress table
CREATE TABLE user_progress (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    devotion_id INT,
    status ENUM('unread','read') DEFAULT 'unread',
    UNIQUE KEY unique_progress(user_id, devotion_id),
    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(devotion_id) REFERENCES devotions(id)
);

-- Sample user
INSERT INTO users (name,email,password) VALUES
('Test User','test@example.com','$2y$10$Ap2l0dx0uSuaoyWSQn2ToOkyp6UpH9x0LulzjhQYU7lnsrQ/szDXC');
-- Password: 123456

-- Sample devotions
INSERT INTO devotions (title, scripture, content, devotion_date) VALUES
('Faith in Action','James 2:17','Faith without works is dead. Let us act in faith today.',CURDATE()),
('God is Love','1 John 4:8','Whoever does not love does not know God. Love one another.',DATE_ADD(CURDATE(), INTERVAL 1 DAY)),
('Trust in Him','Proverbs 3:5','Trust in the Lord with all your heart and lean not on your own understanding.',DATE_ADD(CURDATE(), INTERVAL 2 DAY));

