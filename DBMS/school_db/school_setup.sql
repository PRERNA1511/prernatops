-- ============================================================
-- Session 2 – SQL Basics & Commands
-- File: school_setup.sql
-- Folder: school_db
-- ============================================================

-- Task 1: Create the database and use it
CREATE DATABASE IF NOT EXISTS school_db;
USE school_db;

-- Task 1: Create the students table
CREATE TABLE IF NOT EXISTS students (
    roll_no    INT PRIMARY KEY,
    name       VARCHAR(100) NOT NULL,
    class      VARCHAR(10)  NOT NULL,
    section    CHAR(1)      NOT NULL,
    dob        DATE,
    gender     CHAR(1)
);

-- Task 1: Create the subjects table
CREATE TABLE IF NOT EXISTS subjects (
    subject_id   INT PRIMARY KEY AUTO_INCREMENT,
    subject_name VARCHAR(100) NOT NULL,
    max_marks    INT          NOT NULL
);

-- Task 1: Create the marks table
CREATE TABLE IF NOT EXISTS marks (
    mark_id    INT PRIMARY KEY AUTO_INCREMENT,
    roll_no    INT  NOT NULL,
    subject_id INT  NOT NULL,
    marks      INT  NOT NULL
);

-- Task 2: ALTER TABLE – add an email column to students
ALTER TABLE students
    ADD COLUMN email VARCHAR(150);

-- Task 2: ALTER TABLE – rename the class column to grade
ALTER TABLE students
    RENAME COLUMN class TO grade;

-- Task 2: ALTER TABLE – modify the section column to VARCHAR(5)
ALTER TABLE students
    MODIFY COLUMN section VARCHAR(5) NOT NULL;

-- Task 3: Create a temporary table for the current session
CREATE TEMPORARY TABLE temp_toppers (
    roll_no     INT,
    name        VARCHAR(100),
    total_marks INT
);

-- Task 3: Drop the temporary table
DROP TEMPORARY TABLE IF EXISTS temp_toppers;

-- Task 4: Verify the table structure and list all tables
DESCRIBE students;
DESCRIBE subjects;
DESCRIBE marks;
SHOW TABLES;
