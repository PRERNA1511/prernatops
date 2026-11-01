-- ==========================================
-- SESSION 01: INTRODUCTION TO DATABASES
-- ==========================================
-- File   : Session_01_Answers.sql
-- Author : SQL Training
-- Date   : 2026-10-29
-- Description: Answers for Session 01 - Introduction to Databases
-- Note   : Run these queries in MySQL Workbench after connecting to your
--          MySQL Community Server instance.
-- ==========================================


-- ==========================================
-- Task 1: What is a Database?
-- ==========================================
-- Question: Define a database. Why do we use a database instead of storing
--           data in a plain file (like Excel or a text file)?

-- Solution (Explanation in comments):
-- A DATABASE is an organised collection of structured data stored
-- electronically so that it can be easily accessed, managed, and updated.

-- Why use a database instead of Excel / text files?
-- | Feature          | Excel / Text File     | Database (MySQL)           |
-- |------------------|-----------------------|----------------------------|
-- | Data Volume      | Limited rows          | Millions of rows           |
-- | Multiple Users   | Hard to share safely  | Many users simultaneously  |
-- | Data Integrity   | No built-in rules     | Primary/Foreign keys       |
-- | Search Speed     | Slow on large data    | Indexed, very fast         |
-- | Security         | File-level only       | User roles & permissions   |
-- | Relationships    | Manual VLOOKUP        | JOINs across tables        |

-- A simple demonstration — we create our first database:
CREATE DATABASE IF NOT EXISTS session01_demo;
USE session01_demo;

-- Explanation:
-- CREATE DATABASE  → Creates a new database container.
-- IF NOT EXISTS    → Prevents an error if it already exists (safe to rerun).
-- USE              → Switches the active database so our next commands work here.

-- Verification:
SHOW DATABASES;          -- You should see session01_demo in the list.
SELECT DATABASE();       -- Shows the currently active database.


-- ==========================================
-- Task 2: Types of Databases
-- ==========================================
-- Question: Name and briefly describe the main types of databases.
--           Which type does MySQL belong to?

-- Solution (Explanation in comments):
-- 1. RELATIONAL DATABASE (RDBMS)
--    Data is stored in TABLES (rows and columns).
--    Tables are linked using keys (PRIMARY KEY, FOREIGN KEY).
--    Examples: MySQL, PostgreSQL, Oracle, SQL Server.
--    MySQL IS a Relational Database.

-- 2. HIERARCHICAL DATABASE
--    Data is arranged in a tree structure (parent → child).
--    Example: IBM IMS, Windows Registry.

-- 3. NETWORK DATABASE
--    Similar to hierarchical but children can have multiple parents.
--    Example: IDS, CA-IDMS.

-- 4. NoSQL / Non-Relational Database
--    Stores data as documents, key-value pairs, graphs, or columns.
--    Examples: MongoDB (documents), Redis (key-value), Cassandra (columns).

-- 5. OBJECT-ORIENTED DATABASE
--    Stores data as objects (like in OOP languages).
--    Example: db4o.

-- Demonstration — creating a table that shows RDBMS structure:
CREATE TABLE IF NOT EXISTS db_types (
    id          INT PRIMARY KEY AUTO_INCREMENT,   -- Unique row identifier
    db_type     VARCHAR(50)  NOT NULL,            -- Name of the type
    example     VARCHAR(100) NOT NULL,            -- Real-world example
    description VARCHAR(255)                      -- Brief description
);

INSERT INTO db_types (db_type, example, description) VALUES
('Relational',         'MySQL, Oracle',      'Data in tables linked by keys'),
('Hierarchical',       'IBM IMS',            'Tree-structured parent-child'),
('Network',            'CA-IDMS',            'Multiple parent-child links'),
('NoSQL',              'MongoDB, Redis',     'Flexible schema, JSON docs'),
('Object-Oriented',    'db4o',               'Stores objects like OOP');

-- Verification:
SELECT * FROM db_types;

-- Explanation:
-- INT PRIMARY KEY AUTO_INCREMENT  → Each row gets a unique number automatically.
-- VARCHAR(n)                      → Variable-length text up to n characters.
-- NOT NULL                        → The column must always have a value.


-- ==========================================
-- Task 3: What is DBMS and RDBMS?
-- ==========================================
-- Question: Differentiate between DBMS and RDBMS.
--           Give two examples of each.

-- Solution (Explanation in comments):
-- DBMS (Database Management System):
--   Software that manages data storage and retrieval.
--   Does NOT necessarily use tables or enforce relationships.
--   Examples: MS Access (older versions), FoxPro.

-- RDBMS (Relational Database Management System):
--   A DBMS that organises data in TABLES and uses SQL.
--   Enforces relationships between tables via keys.
--   Follows ACID properties (Atomicity, Consistency, Isolation, Durability).
--   Examples: MySQL, Oracle Database.

-- Creating a comparison table:
CREATE TABLE IF NOT EXISTS dbms_comparison (
    feature         VARCHAR(60),
    dbms            VARCHAR(120),
    rdbms           VARCHAR(120)
);

INSERT INTO dbms_comparison VALUES
('Data Storage',    'Files or simple tables',          'Structured tables (rows & columns)'),
('Relationships',   'Not enforced',                    'Enforced via Primary/Foreign Keys'),
('Query Language',  'May not support standard SQL',    'Uses standard SQL'),
('ACID Properties', 'Not guaranteed',                  'Fully guaranteed'),
('Examples',        'MS Access, FoxPro',               'MySQL, Oracle, SQL Server');

-- Verification:
SELECT * FROM dbms_comparison;


-- ==========================================
-- Task 4: Understanding Tables, Rows, and Columns
-- ==========================================
-- Question: What is a table in a relational database?
--           What are rows and columns? Create a simple example table.

-- Solution:
-- TABLE  → A grid that stores data about one topic (like a spreadsheet sheet).
-- COLUMN → A vertical category / attribute (e.g., student_name, age).
-- ROW    → A horizontal record — one complete entry (e.g., one student's details).

-- Example: Creating a simple students table
CREATE TABLE IF NOT EXISTS students (
    student_id   INT PRIMARY KEY AUTO_INCREMENT,   -- Column 1: Unique ID
    student_name VARCHAR(100) NOT NULL,            -- Column 2: Student's name
    age          INT,                              -- Column 3: Age in years
    city         VARCHAR(50)                       -- Column 4: City of residence
);

-- Inserting rows (records) into the table:
INSERT INTO students (student_name, age, city) VALUES
('Ananya Sharma',  15, 'Mumbai'),
('Rohan Patel',    16, 'Pune'),
('Priya Nair',     15, 'Chennai'),
('Arjun Mehta',    17, 'Delhi');

-- Verification — viewing all rows and columns:
SELECT * FROM students;

-- Expected Output:
-- +------------+--------------+------+---------+
-- | student_id | student_name | age  | city    |
-- +------------+--------------+------+---------+
-- |          1 | Ananya Sharma|  15  | Mumbai  |
-- |          2 | Rohan Patel  |  16  | Pune    |
-- |          3 | Priya Nair   |  15  | Chennai |
-- |          4 | Arjun Mehta  |  17  | Delhi   |
-- +------------+--------------+------+---------+


-- ==========================================
-- Task 5: Primary Key and Foreign Key
-- ==========================================
-- Question: What is a Primary Key? What is a Foreign Key?
--           Create two tables that demonstrate a foreign key relationship.

-- Solution:
-- PRIMARY KEY → A column (or group of columns) that uniquely identifies each row.
--               No two rows can have the same PRIMARY KEY value.
--               A table can have only ONE primary key.

-- FOREIGN KEY → A column in one table that refers to the PRIMARY KEY of another table.
--               It creates a LINK (relationship) between the two tables.
--               Helps maintain data integrity (no orphan records).

-- Parent Table: departments
CREATE TABLE IF NOT EXISTS departments (
    dept_id   INT PRIMARY KEY AUTO_INCREMENT,  -- Primary Key
    dept_name VARCHAR(100) NOT NULL
);

INSERT INTO departments (dept_name) VALUES
('Science'),
('Commerce'),
('Arts');

-- Child Table: class_students (has a Foreign Key pointing to departments)
CREATE TABLE IF NOT EXISTS class_students (
    roll_no   INT PRIMARY KEY AUTO_INCREMENT,
    name      VARCHAR(100) NOT NULL,
    dept_id   INT,                             -- Foreign Key column
    FOREIGN KEY (dept_id) REFERENCES departments(dept_id)
    -- This line links class_students.dept_id → departments.dept_id
);

INSERT INTO class_students (name, dept_id) VALUES
('Sneha Kulkarni',  1),   -- belongs to Science
('Vikram Rao',      2),   -- belongs to Commerce
('Meena Joshi',     3),   -- belongs to Arts
('Aditya Singh',    1);   -- belongs to Science

-- Verification:
SELECT * FROM departments;
SELECT * FROM class_students;

-- Joining both tables to see the relationship:
SELECT cs.roll_no, cs.name, d.dept_name
FROM   class_students cs
JOIN   departments d ON cs.dept_id = d.dept_id;

-- Expected Output:
-- +---------+----------------+-----------+
-- | roll_no | name           | dept_name |
-- +---------+----------------+-----------+
-- |       1 | Sneha Kulkarni | Science   |
-- |       2 | Vikram Rao     | Commerce  |
-- |       3 | Meena Joshi    | Arts      |
-- |       4 | Aditya Singh   | Science   |
-- +---------+----------------+-----------+


-- ==========================================
-- Task 6: Introduction to MySQL Workbench
-- ==========================================
-- Question: How do you connect to MySQL Server using MySQL Workbench?
--           What are the basic navigation areas?

-- Solution (Step-by-step guide in comments):
-- STEP 1: Open MySQL Workbench on your computer.
-- STEP 2: On the home screen, click the "+" button next to "MySQL Connections".
-- STEP 3: Fill in the connection details:
--           Connection Name : My Local MySQL
--           Hostname        : 127.0.0.1  (or localhost)
--           Port            : 3306       (default MySQL port)
--           Username        : root
-- STEP 4: Click "Test Connection" — enter your password when prompted.
-- STEP 5: If the test says "Successfully made the MySQL connection", click OK.
-- STEP 6: Double-click your new connection to open the SQL Editor.

-- KEY AREAS OF MYSQL WORKBENCH:
-- ┌─────────────────────────────────────────────────────┐
-- │  Menu Bar  (File, Edit, View, Query, Database...)   │
-- ├───────────────┬─────────────────────────────────────┤
-- │  Navigator    │  SQL Editor (where you type SQL)    │
-- │  - Schemas    │                                     │
-- │  - Tables     │  Results Grid (output appears here) │
-- │  - Views      │                                     │
-- │  - Stored     │  Action Output (success/error log)  │
-- │    Procedures │                                     │
-- └───────────────┴─────────────────────────────────────┘

-- HOW TO RUN A QUERY:
-- 1. Type your SQL in the editor.
-- 2. Press Ctrl + Enter  to run the current statement.
-- 3. Press Ctrl + Shift + Enter  to run ALL statements in the file.

-- Screenshot to take:
-- Take a screenshot showing MySQL Workbench connected and save it as:
-- workbench_connected.png

-- Verification Query (run after connecting):
SELECT VERSION();           -- Shows the MySQL version installed
SELECT NOW();               -- Shows the current date and time
SELECT USER();              -- Shows the currently logged-in MySQL user


-- ==========================================
-- Task 7: SQL vs NoSQL - Quick Comparison
-- ==========================================
-- Question: When would you choose SQL over NoSQL and vice versa?

-- Solution (Explanation in comments):
-- Choose SQL (Relational / MySQL) when:
--   - Data has a fixed, predictable structure (school records, bank accounts).
--   - You need strong data integrity (transactions, foreign keys).
--   - You need complex queries with JOINs and aggregations.
--   - Consistency is critical (financial systems, medical records).

-- Choose NoSQL when:
--   - Data structure changes frequently (social media posts, JSON APIs).
--   - You need to scale across many servers easily (big data).
--   - You store unstructured data (images, videos, logs).
--   - Speed of read/write matters more than strict consistency.

-- Demonstration: Creating a table that stores this comparison
CREATE TABLE IF NOT EXISTS sql_vs_nosql (
    id          INT PRIMARY KEY AUTO_INCREMENT,
    aspect      VARCHAR(60),
    sql_rdbms   VARCHAR(150),
    nosql       VARCHAR(150)
);

INSERT INTO sql_vs_nosql (aspect, sql_rdbms, nosql) VALUES
('Schema',         'Fixed schema (defined upfront)',   'Flexible / Schema-less'),
('Data Format',    'Tables (rows and columns)',        'JSON, documents, key-value'),
('Relationships',  'JOINs using Foreign Keys',         'Embedded documents'),
('Scalability',    'Vertical (bigger server)',         'Horizontal (more servers)'),
('Best For',       'Banking, ERP, School systems',    'Social media, IoT, Big Data'),
('Example',        'MySQL, Oracle, PostgreSQL',        'MongoDB, Cassandra, Redis');

-- Verification:
SELECT * FROM sql_vs_nosql;


-- ==========================================
-- CLEANUP (Optional - Run to remove demo objects)
-- ==========================================
-- Uncomment the lines below ONLY if you want to remove the demo database.
-- DROP DATABASE IF EXISTS session01_demo;

-- ==========================================
-- END OF SESSION 01 ANSWERS
-- ==========================================
-- Screenshot Required : workbench_connected.png
-- Next Session        : Session_02_SQL_Basics
-- ==========================================
