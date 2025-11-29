-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Devotions Table
CREATE TABLE IF NOT EXISTS devotions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    scripture VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    date DATE NOT NULL
);

-- User Progress Table
CREATE TABLE IF NOT EXISTS user_progress (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    devotion_id INT NOT NULL,
    status ENUM('read','unread') DEFAULT 'unread',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (devotion_id) REFERENCES devotions(id) ON DELETE CASCADE
);

-- Admins Table
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- INSERT INTO admins (name,email,password)
INSERT INTO admins (name,email,password)
VALUES ('Administrator', 'admin@example.com', '$2y$10$Ap2l0dx0uSuaoyWSQn2ToOkyp6UpH9x0LulzjhQYU7lnsrQ/szDXC');


-- sample user (password '123456')
INSERT INTO users (name,email,password) VALUES
('Test User','test@example.com','$2y$10$Ap2l0dx0uSuaoyWSQn2ToOkyp6UpH9x0LulzjhQYU7lnsrQ/szDXC');


INSERT INTO devotions (title, scripture, content, date) VALUES
('God’s Love for Us', 'John 3:16', 'For God so loved the world that He gave His only Son, that whoever believes in Him shall not perish but have eternal life. Remember that God’s love is unending and His grace covers all.', '2025-12-01'),
('Trust in the Lord', 'Proverbs 3:5-6', 'Trust in the Lord with all your heart and lean not on your own understanding; in all your ways acknowledge Him, and He will make your paths straight. When life seems confusing, trust God’s guidance.', '2025-12-02'),
('Strength in Weakness', '2 Corinthians 12:9', 'But He said to me, "My grace is sufficient for you, for My power is made perfect in weakness." Therefore I will boast all the more gladly of my weaknesses, so that the power of Christ may rest upon me.', '2025-12-03'),
('Peace in God', 'Philippians 4:6-7', 'Do not be anxious about anything, but in everything by prayer and supplication with thanksgiving let your requests be made known to God. And the peace of God, which surpasses all understanding, will guard your hearts and minds in Christ Jesus.', '2025-12-04'),
('Walking in Faith', 'Hebrews 11:1', 'Now faith is the assurance of things hoped for, the conviction of things not seen. Walk by faith daily, trusting in God even when you cannot see the outcome.', '2025-12-05'),
('God’s Strength in Trials', 'Isaiah 40:31', 'But those who hope in the Lord will renew their strength. They will soar on wings like eagles; they will run and not grow weary, they will walk and not be faint. Rely on God during difficult times.', '2025-12-06'),
('Forgiveness and Mercy', 'Ephesians 4:32', 'Be kind to one another, tenderhearted, forgiving one another, as God in Christ forgave you. Practice forgiveness daily and show mercy as God has shown you.', '2025-12-07');

