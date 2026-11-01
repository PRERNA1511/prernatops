-- ==========================================
-- SESSION 03: DML OPERATIONS
-- ==========================================
-- File   : Session_03_Answers.sql
-- Author : SQL Training
-- Date   : 2026-10-29
-- Description: Answers for Session 03 - DML Operations
--              Covers INSERT, UPDATE, DELETE with practical examples.
-- How to Run:
--   Open this file in MySQL Workbench.
--   Run section by section using Ctrl+Enter.
-- ==========================================


-- ==========================================
-- SETUP
-- ==========================================
CREATE DATABASE IF NOT EXISTS session03_dml;
USE session03_dml;


-- ==========================================
-- Task 1: INSERT Statement - Single Row
-- ==========================================
-- Question: Create a table named employees and insert ONE employee record
--           using the INSERT INTO ... VALUES syntax.

-- Solution:
CREATE TABLE IF NOT EXISTS employees (
    emp_id      INT          PRIMARY KEY AUTO_INCREMENT,
    emp_name    VARCHAR(100) NOT NULL,
    department  VARCHAR(50),
    salary      DECIMAL(10,2),
    hire_date   DATE,
    is_active   BOOLEAN      DEFAULT TRUE
);

-- Inserting a single row:
INSERT INTO employees (emp_name, department, salary, hire_date)
VALUES ('Aisha Fernandes', 'Marketing', 45000.00, '2024-01-15');

-- Explanation:
-- INSERT INTO tablename (col1, col2, ...) VALUES (val1, val2, ...)
-- Column names listed in () must match value positions in VALUES ().
-- Columns with DEFAULT or AUTO_INCREMENT can be omitted.

-- Verification:
SELECT * FROM employees;


-- ==========================================
-- Task 2: INSERT Statement - Multiple Rows
-- ==========================================
-- Question: Insert multiple employee records in a single INSERT statement.

-- Solution:
INSERT INTO employees (emp_name, department, salary, hire_date) VALUES
('Rajan Sharma',    'IT',        62000.00, '2023-03-10'),
('Meena Pillai',    'HR',        38000.00, '2023-07-01'),
('Kartik Yadav',    'Finance',   55000.00, '2022-11-20'),
('Priya Nambiar',   'IT',        70000.00, '2021-08-15'),
('Suresh Bagde',    'Marketing', 41000.00, '2024-02-28'),
('Leela Krishnan',  'HR',        36000.00, '2023-09-05'),
('Vivek Joshi',     'Finance',   60000.00, '2022-05-12');

-- Explanation:
-- Listing multiple value groups separated by commas inserts all rows
-- in one efficient operation — better than running INSERT 7 times.

-- Verification:
SELECT * FROM employees;
SELECT COUNT(*) AS total_employees FROM employees;   -- Should be 8


-- ==========================================
-- Task 3: INSERT with SELECT (Copy data)
-- ==========================================
-- Question: Create a backup table and copy IT department employees into it.

-- Solution:
-- First, create the backup table with the same structure:
CREATE TABLE IF NOT EXISTS it_employees_backup (
    emp_id      INT          PRIMARY KEY,
    emp_name    VARCHAR(100),
    department  VARCHAR(50),
    salary      DECIMAL(10,2),
    hire_date   DATE,
    is_active   BOOLEAN
);

-- Copy only IT department records using INSERT ... SELECT:
INSERT INTO it_employees_backup
SELECT * FROM employees
WHERE department = 'IT';

-- Explanation:
-- INSERT INTO target_table SELECT ... FROM source_table
-- This copies rows that match the WHERE condition.
-- Very useful for archiving or migrating data.

-- Verification:
SELECT * FROM it_employees_backup;   -- Should show only IT employees


-- ==========================================
-- Task 4: UPDATE Statement - Single Row
-- ==========================================
-- Question: Rajan Sharma received a promotion. Update his salary to 75000
--           and change his department to 'IT Lead'.

-- Solution:

-- IMPORTANT: Always check which rows will be affected BEFORE updating:
SELECT * FROM employees WHERE emp_name = 'Rajan Sharma';

-- Now apply the UPDATE:
UPDATE employees
SET    salary     = 75000.00,
       department = 'IT Lead'
WHERE  emp_name   = 'Rajan Sharma';

-- Explanation:
-- UPDATE tablename SET col1 = val1, col2 = val2 WHERE condition;
-- The WHERE clause is CRITICAL — without it, ALL rows get updated!
-- Set multiple columns by separating them with commas in SET.

-- Verification:
SELECT * FROM employees WHERE emp_name = 'Rajan Sharma';

-- Expected Output:
-- emp_id | emp_name     | department | salary   | hire_date  | is_active
-- 2      | Rajan Sharma | IT Lead    | 75000.00 | 2023-03-10 | 1


-- ==========================================
-- Task 5: UPDATE Statement - Multiple Rows
-- ==========================================
-- Question: Give a 10% salary raise to ALL employees in the Finance department.

-- Solution:

-- Check Finance employees first:
SELECT emp_name, salary FROM employees WHERE department = 'Finance';

-- Apply 10% raise:
UPDATE employees
SET   salary = salary * 1.10
WHERE department = 'Finance';

-- Explanation:
-- salary * 1.10 multiplies the existing salary by 1.10 (adds 10%).
-- All Finance department employees get the update at once.

-- Verification:
SELECT emp_name, department, salary
FROM   employees
WHERE  department = 'Finance';

-- Deactivate employees who left:
UPDATE employees
SET   is_active = FALSE
WHERE emp_id    = 6;   -- Leela Krishnan resigned

-- Verification:
SELECT emp_name, is_active FROM employees WHERE emp_id = 6;


-- ==========================================
-- Task 6: DELETE Statement - Single Row
-- ==========================================
-- Question: Delete the employee with emp_id = 6 from the employees table.

-- Solution:

-- Always SELECT first to confirm what will be deleted:
SELECT * FROM employees WHERE emp_id = 6;

-- Now delete:
DELETE FROM employees
WHERE emp_id = 6;

-- Explanation:
-- DELETE FROM tablename WHERE condition;
-- The WHERE clause specifies WHICH rows to delete.
-- WITHOUT WHERE → ALL rows in the table are deleted (dangerous!).
-- DELETE is reversible within a transaction (unlike TRUNCATE).

-- Verification:
SELECT * FROM employees;              -- emp_id 6 should be gone
SELECT COUNT(*) AS remaining FROM employees;


-- ==========================================
-- Task 7: DELETE Statement - Multiple Rows with Condition
-- ==========================================
-- Question: Delete all inactive employees from the employees table.

-- Solution:

-- Check which employees are inactive first:
SELECT * FROM employees WHERE is_active = FALSE;

-- Delete all inactive employees:
DELETE FROM employees
WHERE is_active = FALSE;

-- Verification:
SELECT * FROM employees WHERE is_active = FALSE;   -- Should return 0 rows
SELECT * FROM employees;                            -- Only active employees remain


-- ==========================================
-- Task 8: SAFE UPDATE MODE in MySQL Workbench
-- ==========================================
-- Question: What is Safe Update Mode? How do you disable it when needed?

-- Solution (Explanation in comments):
-- MySQL Workbench enables SAFE UPDATE MODE by default.
-- In Safe Mode, UPDATE and DELETE without a WHERE clause using PRIMARY KEY
-- will be BLOCKED (to prevent accidental mass updates/deletes).

-- ERROR you might see:
-- "Error Code: 1175. You are using safe update mode..."

-- To DISABLE Safe Update Mode for the current session:
SET SQL_SAFE_UPDATES = 0;

-- To RE-ENABLE Safe Update Mode (best practice after risky operations):
SET SQL_SAFE_UPDATES = 1;

-- OR: In MySQL Workbench → Edit → Preferences → SQL Editor
--     Uncheck "Safe Updates" → Reconnect to server.

-- Example: Updating all Marketing salaries (requires Safe Mode OFF):
SET SQL_SAFE_UPDATES = 0;

UPDATE employees
SET   salary = salary + 2000
WHERE department = 'Marketing';

SET SQL_SAFE_UPDATES = 1;   -- Turn Safe Mode back on

-- Verification:
SELECT emp_name, department, salary FROM employees WHERE department = 'Marketing';


-- ==========================================
-- Task 9: REPLACE INTO Statement
-- ==========================================
-- Question: What is REPLACE INTO? How does it differ from INSERT?

-- Solution (Explanation in comments):
-- REPLACE INTO works like INSERT BUT:
--   If a row with the same PRIMARY KEY or UNIQUE key already exists,
--   it DELETES the old row and INSERTS the new one.
--   If no matching row exists, it simply inserts the new row.

-- This is different from INSERT which FAILS if a duplicate key exists.

-- Example: Inserting or replacing an employee record
REPLACE INTO employees (emp_id, emp_name, department, salary, hire_date)
VALUES (1, 'Aisha Fernandes', 'Marketing Lead', 52000.00, '2024-01-15');
-- emp_id 1 already exists → old row deleted, new row inserted

-- Verification:
SELECT * FROM employees WHERE emp_id = 1;
-- Notice department changed from 'Marketing' to 'Marketing Lead'

-- NOTE: REPLACE increases the AUTO_INCREMENT counter even when replacing.


-- ==========================================
-- Task 10: Practical Exercise - Student Marks Table
-- ==========================================
-- Question: Create a student_marks table and perform INSERT, UPDATE, and
--           DELETE operations on it.
--           Table columns: mark_id, student_name, subject, marks_obtained (out of 100)

-- Solution:
CREATE TABLE IF NOT EXISTS student_marks (
    mark_id         INT         PRIMARY KEY AUTO_INCREMENT,
    student_name    VARCHAR(100) NOT NULL,
    subject         VARCHAR(50)  NOT NULL,
    marks_obtained  TINYINT      CHECK (marks_obtained BETWEEN 0 AND 100)
);

-- INSERT: Add marks for students
INSERT INTO student_marks (student_name, subject, marks_obtained) VALUES
('Ananya Roy',     'Mathematics', 88),
('Ananya Roy',     'Science',     92),
('Ananya Roy',     'English',     75),
('Rohan Das',      'Mathematics', 65),
('Rohan Das',      'Science',     70),
('Rohan Das',      'English',     80),
('Simran Kaur',    'Mathematics', 95),
('Simran Kaur',    'Science',     98),
('Simran Kaur',    'English',     91);

-- Verification after INSERT:
SELECT * FROM student_marks;

-- UPDATE: Ananya Roy's Science marks need correction (should be 94):
UPDATE student_marks
SET   marks_obtained = 94
WHERE student_name   = 'Ananya Roy'
  AND subject        = 'Science';

-- Verification after UPDATE:
SELECT * FROM student_marks WHERE student_name = 'Ananya Roy';

-- DELETE: Remove Rohan Das's English marks (entered by mistake):
DELETE FROM student_marks
WHERE student_name = 'Rohan Das'
  AND subject      = 'English';

-- Final Verification:
SELECT   student_name,
         SUM(marks_obtained)                    AS total_marks,
         ROUND(AVG(marks_obtained), 2)          AS avg_marks,
         MAX(marks_obtained)                    AS highest,
         MIN(marks_obtained)                    AS lowest
FROM     student_marks
GROUP BY student_name
ORDER BY total_marks DESC;

-- Expected Output (approximate):
-- +--------------+-------------+-----------+---------+--------+
-- | student_name | total_marks | avg_marks | highest | lowest |
-- +--------------+-------------+-----------+---------+--------+
-- | Simran Kaur  | 284         | 94.67     | 98      | 91     |
-- | Ananya Roy   | 257         | 85.67     | 94      | 75     |
-- | Rohan Das    | 135         | 67.50     | 70      | 65     |
-- +--------------+-------------+-----------+---------+--------+


-- ==========================================
-- END OF SESSION 03 ANSWERS
-- ==========================================
-- Topics Covered:
--   INSERT (single row, multiple rows, INSERT...SELECT)
--   UPDATE (single row, multiple rows)
--   DELETE (single row, multiple rows with conditions)
--   Safe Update Mode
--   REPLACE INTO
-- Next Session: Session_04_Data_Retrieval
-- ==========================================
