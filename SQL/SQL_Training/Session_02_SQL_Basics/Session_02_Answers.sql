-- ==========================================
-- SESSION 02: SQL BASICS
-- ==========================================
-- File   : Session_02_Answers.sql
-- Author : SQL Training
-- Date   : 2026-10-29
-- Description: Answers for Session 02 - SQL Basics
--              Covers DDL commands: CREATE, ALTER, DROP, TRUNCATE, RENAME
--              and basic data types used in MySQL.
-- How to Run:
--   1. Open MySQL Workbench and connect to your MySQL Server.
--   2. Open this file: File → Open SQL Script → select this file.
--   3. Run statements with Ctrl+Enter (one at a time) or
--      Ctrl+Shift+Enter (entire file).
-- ==========================================


-- ==========================================
-- SETUP: Create and select working database
-- ==========================================
CREATE DATABASE IF NOT EXISTS session02_basics;
USE session02_basics;

-- ==========================================
-- Task 1: Understanding SQL Categories
-- ==========================================
-- Question: Name the five main categories of SQL commands and give one
--           example command from each category.

-- Solution (Explanation in comments):
-- SQL commands are grouped into 5 categories:

-- 1. DDL – Data Definition Language
--    Commands that DEFINE or CHANGE the database STRUCTURE (tables, columns).
--    Examples: CREATE, ALTER, DROP, TRUNCATE, RENAME

-- 2. DML – Data Manipulation Language
--    Commands that ADD, UPDATE, or DELETE DATA inside tables.
--    Examples: INSERT, UPDATE, DELETE

-- 3. DQL – Data Query Language
--    Commands that RETRIEVE data from tables.
--    Example: SELECT

-- 4. DCL – Data Control Language
--    Commands that control PERMISSIONS (who can do what).
--    Examples: GRANT, REVOKE

-- 5. TCL – Transaction Control Language
--    Commands that manage TRANSACTIONS (groups of operations).
--    Examples: COMMIT, ROLLBACK, SAVEPOINT

-- Demonstration: Storing this information in a table
CREATE TABLE IF NOT EXISTS sql_categories (
    id          INT PRIMARY KEY AUTO_INCREMENT,
    category    VARCHAR(10) NOT NULL,
    full_name   VARCHAR(50) NOT NULL,
    purpose     VARCHAR(150),
    examples    VARCHAR(100)
);

INSERT INTO sql_categories (category, full_name, purpose, examples) VALUES
('DDL', 'Data Definition Language',     'Define/change database structure', 'CREATE, ALTER, DROP'),
('DML', 'Data Manipulation Language',   'Add, update, delete data',         'INSERT, UPDATE, DELETE'),
('DQL', 'Data Query Language',          'Retrieve data from tables',        'SELECT'),
('DCL', 'Data Control Language',        'Manage user permissions',          'GRANT, REVOKE'),
('TCL', 'Transaction Control Language', 'Manage transactions',              'COMMIT, ROLLBACK');

-- Verification:
SELECT * FROM sql_categories;


-- ==========================================
-- Task 2: MySQL Data Types
-- ==========================================
-- Question: List the common MySQL data types. Give an example of when
--           you would use each type.

-- Solution (Explanation in comments):
-- NUMERIC TYPES:
--   INT         → Whole numbers. Example: age, student_id, quantity.
--   DECIMAL(p,s)→ Exact decimal. Example: fees (DECIMAL(10,2) = 8 digits + 2 decimals).
--   FLOAT/DOUBLE→ Approximate decimals. Example: scientific measurements.
--   TINYINT     → Small integers (0-255 or -128 to 127). Example: is_active (0/1).

-- STRING TYPES:
--   VARCHAR(n)  → Variable-length text up to n chars. Example: names, email.
--   CHAR(n)     → Fixed-length text. Example: gender ('M'/'F'), country_code.
--   TEXT        → Long text (up to 65,535 chars). Example: description, address.

-- DATE / TIME TYPES:
--   DATE        → Date only: YYYY-MM-DD. Example: date_of_birth, enrollment_date.
--   TIME        → Time only: HH:MM:SS. Example: class_start_time.
--   DATETIME    → Date + Time. Example: order_placed_at, login_time.
--   TIMESTAMP   → Auto-updates to current time. Example: last_modified.
--   YEAR        → Four-digit year. Example: graduation_year.

-- BOOLEAN:
--   BOOLEAN / TINYINT(1)  → TRUE (1) or FALSE (0). Example: is_active, is_paid.

-- Demonstration: A table using many different data types
CREATE TABLE IF NOT EXISTS data_type_examples (
    student_id      INT             PRIMARY KEY AUTO_INCREMENT,
    student_name    VARCHAR(100)    NOT NULL,
    gender          CHAR(1),                         -- 'M' or 'F'
    age             TINYINT         UNSIGNED,
    grade           CHAR(2),                         -- e.g. '10', '11'
    fees_paid       DECIMAL(10,2),                   -- e.g. 15000.00
    percentage      FLOAT,                           -- e.g. 87.5
    enroll_date     DATE,                            -- e.g. 2025-06-01
    class_time      TIME,                            -- e.g. 08:30:00
    remarks         TEXT,                            -- Long free text
    is_active       BOOLEAN         DEFAULT TRUE,    -- 1=active, 0=inactive
    created_at      TIMESTAMP       DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO data_type_examples
    (student_name, gender, age, grade, fees_paid, percentage, enroll_date, class_time, remarks)
VALUES
('Tanvi Joshi',    'F', 15, '10', 12500.00, 91.5, '2025-06-01', '08:30:00', 'Excellent student'),
('Karan Mehta',    'M', 16, '11', 14000.00, 78.3, '2025-06-01', '09:00:00', 'Good progress'),
('Divya Pillai',   'F', 14, '09', 11000.00, 88.0, '2025-06-01', '08:30:00', NULL),
('Sameer Khan',    'M', 17, '12', 15500.00, 72.8, '2025-06-01', '09:00:00', 'Needs improvement');

-- Verification:
DESCRIBE data_type_examples;     -- Shows column structure and data types
SELECT * FROM data_type_examples;


-- ==========================================
-- Task 3: CREATE TABLE Statement
-- ==========================================
-- Question: Write a CREATE TABLE statement for a library database.
--           Include at least 6 columns with appropriate data types and constraints.

-- Solution:
CREATE TABLE IF NOT EXISTS books (
    book_id         INT             PRIMARY KEY AUTO_INCREMENT,  -- Unique book number
    title           VARCHAR(200)    NOT NULL,                    -- Book title (required)
    author          VARCHAR(100)    NOT NULL,                    -- Author name (required)
    isbn            CHAR(13)        UNIQUE,                      -- ISBN must be unique
    price           DECIMAL(8,2)    DEFAULT 0.00,               -- Price in rupees
    published_year  YEAR,                                        -- Year of publication
    is_available    BOOLEAN         DEFAULT TRUE,               -- Is book on shelf?
    genre           VARCHAR(50),                                 -- Fiction, Science, etc.
    added_on        DATE            DEFAULT (CURRENT_DATE)      -- Date added to library
);

-- How to run in MySQL Workbench:
--   Paste the above CREATE TABLE statement in the editor and press Ctrl+Enter.

-- Inserting sample books:
INSERT INTO books (title, author, isbn, price, published_year, genre) VALUES
('The Discovery of India',  'Jawaharlal Nehru',    '9780143031031', 499.00,  1946, 'History'),
('Wings of Fire',           'A.P.J. Abdul Kalam',  '9788173711466', 299.00,  1999, 'Biography'),
('Malgudi Days',            'R.K. Narayan',        '9780140186802', 250.00,  1943, 'Fiction'),
('A Brief History of Time', 'Stephen Hawking',     '9780553380163', 399.00,  1988, 'Science'),
('The White Tiger',         'Aravind Adiga',       '9780743299091', 350.00,  2008, 'Fiction');

-- Verification:
SELECT * FROM books;

-- Explanation:
-- PRIMARY KEY AUTO_INCREMENT → MySQL will automatically assign 1, 2, 3... to book_id.
-- NOT NULL                   → The column cannot be empty.
-- UNIQUE                     → No two books can have the same ISBN.
-- DEFAULT                    → If no value is given, use this default value.


-- ==========================================
-- Task 4: ALTER TABLE Statement
-- ==========================================
-- Question: Using the books table you created, demonstrate:
--           (a) Adding a new column
--           (b) Modifying a column's data type/size
--           (c) Renaming a column
--           (d) Dropping a column

-- Solution:

-- (a) ADD a new column: stock quantity
ALTER TABLE books
ADD COLUMN stock_qty INT DEFAULT 1;

-- (b) MODIFY a column: increase author column size
ALTER TABLE books
MODIFY COLUMN author VARCHAR(150) NOT NULL;

-- (c) RENAME a column: rename genre to category
ALTER TABLE books
RENAME COLUMN genre TO category;

-- (d) DROP a column: remove the added_on column
ALTER TABLE books
DROP COLUMN added_on;

-- Verification after all alterations:
DESCRIBE books;   -- Check the new structure
SELECT * FROM books;

-- Explanation:
-- ALTER TABLE is used to change a table AFTER it has been created.
-- ADD COLUMN    → Adds a new column at the end (or at a position you specify).
-- MODIFY COLUMN → Changes data type, size, or constraints of an existing column.
-- RENAME COLUMN → Renames a column without losing its data.
-- DROP COLUMN   → Permanently removes a column AND all its data.


-- ==========================================
-- Task 5: RENAME TABLE
-- ==========================================
-- Question: Rename the books table to library_books.

-- Solution:
RENAME TABLE books TO library_books;

-- Verification:
SHOW TABLES;                    -- library_books should appear instead of books
SELECT * FROM library_books;    -- All data is still intact

-- Explanation:
-- RENAME TABLE changes the name of an existing table.
-- All data inside the table remains untouched.


-- ==========================================
-- Task 6: TRUNCATE TABLE
-- ==========================================
-- Question: What does TRUNCATE do? How is it different from DELETE?
--           Demonstrate TRUNCATE on a test table.

-- Solution (Explanation in comments):
-- TRUNCATE removes ALL rows from a table BUT keeps the table structure.
-- It is FASTER than DELETE because it does not log individual row deletions.
-- It CANNOT be rolled back in MySQL (no ROLLBACK possible after TRUNCATE).
-- It RESETS the AUTO_INCREMENT counter back to 1.

-- DELETE removes rows one by one (can use WHERE clause, can be rolled back).

-- Creating a test table:
CREATE TABLE IF NOT EXISTS temp_data (
    id      INT PRIMARY KEY AUTO_INCREMENT,
    info    VARCHAR(100)
);

INSERT INTO temp_data (info) VALUES ('Row 1'), ('Row 2'), ('Row 3');

SELECT * FROM temp_data;      -- Shows 3 rows before TRUNCATE

TRUNCATE TABLE temp_data;

SELECT * FROM temp_data;      -- Shows 0 rows after TRUNCATE (table still exists)
DESCRIBE temp_data;           -- Table structure is still intact

-- Comparison Table:
-- | Feature            | DELETE            | TRUNCATE              |
-- |--------------------|-------------------|-----------------------|
-- | Removes rows       | Yes (with WHERE)  | Yes (ALL rows only)   |
-- | WHERE clause       | Yes               | No                    |
-- | Rollback possible  | Yes               | No (in MySQL)         |
-- | Speed              | Slower            | Faster                |
-- | Resets AUTO_INC    | No                | Yes                   |
-- | DDL or DML         | DML               | DDL                   |


-- ==========================================
-- Task 7: DROP TABLE
-- ==========================================
-- Question: What does DROP TABLE do? How is it different from TRUNCATE?
--           When should you use DROP?

-- Solution:
-- DROP TABLE completely REMOVES the table AND all its data.
-- After DROP, the table no longer exists — structure is gone too.

-- Use DROP when:
--   - You no longer need the table at all.
--   - You are cleaning up test/temporary tables.

-- Use TRUNCATE when:
--   - You want to EMPTY the table but KEEP its structure for future use.

-- Demonstration:
DROP TABLE IF EXISTS temp_data;

SHOW TABLES;   -- temp_data should no longer appear

-- Explanation:
-- IF EXISTS prevents an error if the table does not exist.


-- ==========================================
-- Task 8: Practice - Create a Student Database Schema
-- ==========================================
-- Question: Design and create the following tables for a school system:
--   1. students  (student_id, name, dob, gender, class, section)
--   2. teachers  (teacher_id, name, subject, phone)
--   3. subjects  (subject_id, subject_name, teacher_id FK)

-- Solution:
CREATE TABLE IF NOT EXISTS school_students (
    student_id  INT         PRIMARY KEY AUTO_INCREMENT,
    name        VARCHAR(100) NOT NULL,
    dob         DATE,
    gender      CHAR(1)     CHECK (gender IN ('M','F','O')),
    class       TINYINT     NOT NULL,
    section     CHAR(1)     NOT NULL
);

CREATE TABLE IF NOT EXISTS school_teachers (
    teacher_id  INT         PRIMARY KEY AUTO_INCREMENT,
    name        VARCHAR(100) NOT NULL,
    subject     VARCHAR(50),
    phone       CHAR(10)    UNIQUE
);

CREATE TABLE IF NOT EXISTS school_subjects (
    subject_id      INT         PRIMARY KEY AUTO_INCREMENT,
    subject_name    VARCHAR(80)  NOT NULL,
    teacher_id      INT,
    FOREIGN KEY (teacher_id) REFERENCES school_teachers(teacher_id)
);

-- Insert sample data:
INSERT INTO school_teachers (name, subject, phone) VALUES
('Mrs. Latha Iyer',     'Mathematics',  '9876543210'),
('Mr. Ramesh Gupta',    'Science',      '9765432109'),
('Ms. Anjali Nair',     'English',      '9654321098');

INSERT INTO school_subjects (subject_name, teacher_id) VALUES
('Algebra',     1),
('Physics',     2),
('Literature',  3),
('Chemistry',   2);

INSERT INTO school_students (name, dob, gender, class, section) VALUES
('Ritu Sharma',     '2010-04-15', 'F', 10, 'A'),
('Mohit Verma',     '2009-11-22', 'M', 11, 'B'),
('Deepa Krishnan',  '2011-01-08', 'F',  9, 'A'),
('Suresh Patil',    '2008-07-30', 'M', 12, 'C');

-- Verification:
SELECT * FROM school_students;
SELECT * FROM school_teachers;
SELECT * FROM school_subjects;
SHOW TABLES;

-- Explanation:
-- CHECK constraint → Limits the allowed values for a column (MySQL 8.0+).
-- FOREIGN KEY → school_subjects.teacher_id must match an existing teacher_id.


-- ==========================================
-- END OF SESSION 02 ANSWERS
-- ==========================================
-- Topics Covered:
--   SQL Categories (DDL, DML, DQL, DCL, TCL)
--   MySQL Data Types
--   CREATE TABLE
--   ALTER TABLE (ADD, MODIFY, RENAME COLUMN, DROP COLUMN)
--   RENAME TABLE
--   TRUNCATE TABLE
--   DROP TABLE
-- Next Session: Session_03_DML_Operations
-- ==========================================
