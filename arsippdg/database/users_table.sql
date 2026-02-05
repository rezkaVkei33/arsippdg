-- Users Table
-- Run this SQL to create the users table for authentication

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Login Activity Table
-- Tracks all user login activities

CREATE TABLE IF NOT EXISTS `login_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `login_time` timestamp DEFAULT CURRENT_TIMESTAMP,
  `ip_address` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `login_time` (`login_time`),
  CONSTRAINT `fk_login_activity_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Optional: Insert a default admin user
-- Username: admin
-- Password: admin123456
-- Uncomment the line below to insert default user
-- INSERT INTO `users` (`username`, `password`) 
-- VALUES ('admin', '$2y$10$8JW7GrzWJQU4EKZ1GvnH2uR7.E5wEtOvlKy8pZq5hQ6tZ3KzL2nOe');
