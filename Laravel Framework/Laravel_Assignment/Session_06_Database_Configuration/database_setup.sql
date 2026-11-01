-- Session 6: MySQL Database Creation Script
-- Run this in MySQL CLI or phpMyAdmin if connecting via MySQL

CREATE DATABASE IF NOT EXISTS `laravel_assignment` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Verify database exists:
SHOW DATABASES LIKE 'laravel_assignment';
