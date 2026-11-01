-- ==========================================
-- SESSION 05: JOINS AND RELATIONSHIPS
-- ==========================================
-- File   : Session_05_Answers.sql
-- Author : SQL Training
-- Date   : 2026-10-29
-- Description: Answers for Session 05 - Joins and Relationships
--              Covers INNER JOIN, LEFT JOIN, RIGHT JOIN, FULL OUTER JOIN
--              (simulated), CROSS JOIN, SELF JOIN, and table relationships.
-- How to Run:
--   Open in MySQL Workbench, run section by section with Ctrl+Enter.
-- ==========================================


-- ==========================================
-- SETUP: Create the school database for all join examples
-- ==========================================
CREATE DATABASE IF NOT EXISTS session05_joins;
USE session05_joins;

-- TABLE 1: departments
CREATE TABLE IF NOT EXISTS departments (
    dept_id     INT         PRIMARY KEY AUTO_INCREMENT,
    dept_name   VARCHAR(50) NOT NULL,
    hod_name    VARCHAR(100)           -- Head of Department
);

-- TABLE 2: teachers
CREATE TABLE IF NOT EXISTS teachers (
    teacher_id  INT         PRIMARY KEY AUTO_INCREMENT,
    teacher_name VARCHAR(100) NOT NULL,
    dept_id     INT,                   -- FK to departments
    salary      DECIMAL(10,2),
    email       VARCHAR(100) UNIQUE,
    FOREIGN KEY (dept_id) REFERENCES departments(dept_id)
);

-- TABLE 3: students
CREATE TABLE IF NOT EXISTS students (
    student_id   INT         PRIMARY KEY AUTO_INCREMENT,
    student_name VARCHAR(100) NOT NULL,
    dept_id      INT,                  -- FK to departments
    year         TINYINT,              -- Year 1, 2, 3
    FOREIGN KEY (dept_id) REFERENCES departments(dept_id)
);

-- TABLE 4: courses
CREATE TABLE IF NOT EXISTS courses (
    course_id    INT         PRIMARY KEY AUTO_INCREMENT,
    course_name  VARCHAR(100) NOT NULL,
    teacher_id   INT,                  -- FK to teachers (can be NULL = unassigned)
    dept_id      INT,
    credits      TINYINT,
    FOREIGN KEY (teacher_id) REFERENCES teachers(teacher_id),
    FOREIGN KEY (dept_id)    REFERENCES departments(dept_id)
);

-- TABLE 5: enrollments (many-to-many: students ↔ courses)
CREATE TABLE IF NOT EXISTS enrollments (
    enroll_id   INT         PRIMARY KEY AUTO_INCREMENT,
    student_id  INT,
    course_id   INT,
    grade       CHAR(2),              -- A, B, C, D, F
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (course_id)  REFERENCES courses(course_id)
);

-- ==========================================
-- INSERT SAMPLE DATA
-- ==========================================

INSERT INTO departments (dept_name, hod_name) VALUES
('Mathematics',    'Dr. Ramesh Iyer'),
('Science',        'Dr. Kavitha Menon'),
('English',        'Prof. Anand Pillai'),
('Computer Science','Dr. Suresh Nair');
-- Department 5 intentionally has no department yet (for LEFT JOIN demo)

INSERT INTO teachers (teacher_name, dept_id, salary, email) VALUES
('Mrs. Shobha Rao',   1, 55000.00, 'shobha@school.edu'),
('Mr. Dinesh Kumar',  1, 52000.00, 'dinesh@school.edu'),
('Ms. Priya Krishnan',2, 58000.00, 'priya@school.edu'),
('Mr. Arun Sharma',   2, 54000.00, 'arun@school.edu'),
('Ms. Lata Iyer',     3, 50000.00, 'lata@school.edu'),
('Mr. Hari Menon',    4, 62000.00, 'hari@school.edu'),
('Ms. Vimala Nair',   NULL, 48000.00, 'vimala@school.edu');  -- No dept assigned

INSERT INTO students (student_name, dept_id, year) VALUES
('Ananya Sharma',   1, 2),
('Karan Mehta',     2, 1),
('Pooja Nair',      3, 3),
('Aditya Singh',    4, 2),
('Reshma Pillai',   1, 1),
('Suresh Babu',     2, 3),
('Divya Krishnan',  3, 2),
('Rahul Joshi',     4, 1),
('Preeti Kumar',    NULL, 2);  -- Student with no department (for LEFT JOIN demo)

INSERT INTO courses (course_name, teacher_id, dept_id, credits) VALUES
('Algebra',             1, 1, 4),
('Calculus',            2, 1, 4),
('Physics',             3, 2, 4),
('Chemistry',           4, 2, 4),
('British Literature',  5, 3, 3),
('Database Systems',    6, 4, 4),
('Python Programming',  6, 4, 4),
('Unassigned Course',   NULL, NULL, 2);  -- No teacher assigned

INSERT INTO enrollments (student_id, course_id, grade) VALUES
(1, 1, 'A'),  (1, 2, 'B'),
(2, 3, 'A'),  (2, 4, 'B'),
(3, 5, 'A'),
(4, 6, 'B'),  (4, 7, 'A'),
(5, 1, 'C'),  (5, 2, 'A'),
(6, 3, 'B'),  (6, 4, 'A'),
(7, 5, 'B'),
(8, 6, 'A'),  (8, 7, 'B');
-- student_id 9 (Preeti Kumar) has no enrollments


-- ==========================================
-- Task 1: INNER JOIN
-- ==========================================
-- Question: Explain INNER JOIN. Write a query to display each teacher's
--           name along with their department name.
--           Also show courses with their assigned teacher names.

-- Solution:
-- INNER JOIN returns ONLY rows where there is a MATCH in BOTH tables.
-- Rows that don't have a match in either table are EXCLUDED.

-- Teacher with their department:
SELECT t.teacher_name      AS Teacher,
       d.dept_name         AS Department,
       t.salary            AS Salary
FROM   teachers t
INNER JOIN departments d ON t.dept_id = d.dept_id
ORDER BY d.dept_name, t.teacher_name;

-- Explanation:
-- teachers t                    → alias 't' for teachers table.
-- INNER JOIN departments d      → alias 'd' for departments table.
-- ON t.dept_id = d.dept_id      → the JOIN condition (how tables are linked).
-- Vimala Nair (dept_id=NULL) will NOT appear because she has no matching dept.

-- Courses with teacher name and department:
SELECT c.course_name       AS Course,
       t.teacher_name      AS Teacher,
       d.dept_name         AS Department,
       c.credits           AS Credits
FROM   courses c
INNER JOIN teachers    t ON c.teacher_id = t.teacher_id
INNER JOIN departments d ON c.dept_id    = d.dept_id
ORDER BY d.dept_name, c.course_name;

-- Note: 'Unassigned Course' won't appear (teacher_id is NULL → no match).


-- ==========================================
-- Task 2: LEFT JOIN (LEFT OUTER JOIN)
-- ==========================================
-- Question: Explain LEFT JOIN. Write a query to show ALL teachers,
--           including those not assigned to any department.
--           Also show all students with their department (if any).

-- Solution:
-- LEFT JOIN returns ALL rows from the LEFT table and matching rows from
-- the RIGHT table. If no match, NULL is shown for right-table columns.

-- All teachers, including those without a department:
SELECT t.teacher_name      AS Teacher,
       IFNULL(d.dept_name, 'No Department Assigned') AS Department,
       t.salary            AS Salary
FROM   teachers t
LEFT JOIN departments d ON t.dept_id = d.dept_id
ORDER BY d.dept_name, t.teacher_name;

-- Explanation:
-- Vimala Nair has dept_id = NULL → dept_name will be NULL.
-- IFNULL(d.dept_name, 'No Department Assigned') replaces NULL with text.

-- All students with their department (Preeti Kumar has no dept):
SELECT s.student_name,
       IFNULL(d.dept_name, 'Not Enrolled in Dept') AS department,
       s.year
FROM   students s
LEFT JOIN departments d ON s.dept_id = d.dept_id
ORDER BY d.dept_name;

-- All courses and their teachers (including unassigned course):
SELECT c.course_name,
       IFNULL(t.teacher_name, 'No Teacher Assigned') AS teacher,
       c.credits
FROM   courses c
LEFT JOIN teachers t ON c.teacher_id = t.teacher_id;


-- ==========================================
-- Task 3: RIGHT JOIN (RIGHT OUTER JOIN)
-- ==========================================
-- Question: Explain RIGHT JOIN. Write a query to show ALL departments,
--           including those that have no teachers assigned.

-- Solution:
-- RIGHT JOIN returns ALL rows from the RIGHT table and matching rows
-- from the LEFT table. If no match, NULL is shown for left-table columns.

SELECT IFNULL(t.teacher_name, 'No Teacher Yet') AS teacher,
       d.dept_name
FROM   teachers t
RIGHT JOIN departments d ON t.dept_id = d.dept_id
ORDER BY d.dept_name;

-- Explanation:
-- If a department has no teachers, teacher_name = NULL.
-- RIGHT JOIN is the mirror of LEFT JOIN.
-- TIP: In practice, LEFT JOIN is preferred — you can rewrite most RIGHT JOINs
--      as LEFT JOINs by swapping table order.

-- Rewritten as LEFT JOIN (equivalent result):
SELECT IFNULL(t.teacher_name, 'No Teacher Yet') AS teacher,
       d.dept_name
FROM   departments d
LEFT JOIN teachers t ON d.dept_id = t.dept_id
ORDER BY d.dept_name;


-- ==========================================
-- Task 4: FULL OUTER JOIN (Simulated)
-- ==========================================
-- Question: MySQL does not support FULL OUTER JOIN directly.
--           How do you simulate it? Show all teachers and all departments,
--           regardless of whether they match.

-- Solution: Use UNION of LEFT JOIN and RIGHT JOIN:
SELECT t.teacher_name      AS Teacher,
       d.dept_name         AS Department
FROM   teachers t
LEFT JOIN departments d ON t.dept_id = d.dept_id

UNION

SELECT t.teacher_name      AS Teacher,
       d.dept_name         AS Department
FROM   teachers t
RIGHT JOIN departments d ON t.dept_id = d.dept_id
ORDER BY Department, Teacher;

-- Explanation:
-- UNION combines results of two SELECT statements and removes duplicates.
-- LEFT JOIN gets all teachers (even without dept).
-- RIGHT JOIN gets all departments (even without teachers).
-- Combined = FULL OUTER JOIN effect.
-- Use UNION ALL instead of UNION if you want to keep duplicates.


-- ==========================================
-- Task 5: CROSS JOIN
-- ==========================================
-- Question: Explain CROSS JOIN. Write a query to generate all possible
--           combinations of departments and years (1, 2, 3).

-- Solution:
-- CROSS JOIN returns every possible combination of rows from two tables.
-- Total rows = rows in Table A × rows in Table B.

-- Creating a helper table for years:
CREATE TABLE IF NOT EXISTS academic_years (
    year_number TINYINT
);
INSERT INTO academic_years VALUES (1), (2), (3);

-- Cross join departments with years:
SELECT d.dept_name       AS Department,
       ay.year_number    AS Year
FROM   departments d
CROSS JOIN academic_years ay
ORDER BY d.dept_name, ay.year_number;

-- Explanation:
-- 4 departments × 3 years = 12 rows.
-- CROSS JOIN is useful for generating all combinations (e.g., timetables,
-- size × color product combinations in e-commerce).
-- No ON condition is needed for CROSS JOIN.


-- ==========================================
-- Task 6: SELF JOIN
-- ==========================================
-- Question: Create an employees hierarchy table and use SELF JOIN
--           to display each employee with their manager's name.

-- Solution:
-- SELF JOIN joins a table with ITSELF. Useful for hierarchical data.

CREATE TABLE IF NOT EXISTS emp_hierarchy (
    emp_id      INT         PRIMARY KEY AUTO_INCREMENT,
    emp_name    VARCHAR(100),
    manager_id  INT         -- References emp_id in the same table
);

INSERT INTO emp_hierarchy (emp_name, manager_id) VALUES
('Mr. Principal',  NULL),   -- Top of hierarchy, no manager
('Vice Principal', 1),
('HOD Maths',      1),
('HOD Science',    1),
('Mrs. Shobha',    3),       -- Reports to HOD Maths
('Mr. Dinesh',     3),       -- Reports to HOD Maths
('Ms. Priya',      4),       -- Reports to HOD Science
('Mr. Arun',       4);       -- Reports to HOD Science

-- Self join to get employee with manager name:
SELECT e.emp_name                                    AS Employee,
       IFNULL(m.emp_name, 'Top of Hierarchy')        AS Manager
FROM   emp_hierarchy e
LEFT JOIN emp_hierarchy m ON e.manager_id = m.emp_id
ORDER BY m.emp_name, e.emp_name;

-- Explanation:
-- We use TWO aliases for the SAME table: e (employee) and m (manager).
-- e.manager_id = m.emp_id → links each employee to their manager.
-- LEFT JOIN used so the top-level person (no manager) also appears.

-- Expected Output (partial):
-- +--------------+------------------+
-- | Employee     | Manager          |
-- +--------------+------------------+
-- | Mr. Principal| Top of Hierarchy |
-- | HOD Maths    | Mr. Principal    |
-- | HOD Science  | Mr. Principal    |
-- | Mrs. Shobha  | HOD Maths        |
-- | Mr. Dinesh   | HOD Maths        |
-- | Ms. Priya    | HOD Science      |
-- | Mr. Arun     | HOD Science      |
-- +--------------+------------------+


-- ==========================================
-- Task 7: Multi-Table Join (3+ Tables)
-- ==========================================
-- Question: Write a query to show each enrolled student's name,
--           the course they enrolled in, the teacher's name, and their grade.

-- Solution:
SELECT s.student_name,
       c.course_name,
       IFNULL(t.teacher_name, 'No Teacher') AS teacher,
       e.grade
FROM   enrollments e
INNER JOIN students s  ON e.student_id  = s.student_id
INNER JOIN courses  c  ON e.course_id   = c.course_id
LEFT  JOIN teachers t  ON c.teacher_id  = t.teacher_id
ORDER BY s.student_name, c.course_name;

-- Explanation:
-- We JOIN four tables: enrollments (centre), students, courses, teachers.
-- Use INNER JOIN for required relationships and LEFT JOIN where data may be missing.


-- ==========================================
-- Task 8: JOIN with GROUP BY and Aggregates
-- ==========================================
-- Question: Write queries to:
--           (a) Count students per department.
--           (b) Find average salary per department.
--           (c) Find the number of courses per teacher.

-- Solution:

-- (a) Students per department:
SELECT   d.dept_name,
         COUNT(s.student_id) AS student_count
FROM     departments d
LEFT JOIN students s ON d.dept_id = s.dept_id
GROUP BY d.dept_name
ORDER BY student_count DESC;

-- (b) Average teacher salary per department:
SELECT   d.dept_name,
         COUNT(t.teacher_id)              AS teacher_count,
         ROUND(AVG(t.salary), 2)          AS avg_salary,
         MAX(t.salary)                    AS max_salary
FROM     departments d
LEFT JOIN teachers t ON d.dept_id = t.dept_id
GROUP BY d.dept_name
ORDER BY avg_salary DESC;

-- (c) Courses per teacher:
SELECT   t.teacher_name,
         COUNT(c.course_id) AS courses_taught
FROM     teachers t
LEFT JOIN courses c ON t.teacher_id = c.teacher_id
GROUP BY t.teacher_name
ORDER BY courses_taught DESC;


-- ==========================================
-- Task 9: Understanding Relationships
-- ==========================================
-- Question: Explain the three types of relationships in a relational database
--           with examples from the school database.

-- Solution (Explanation in comments):

-- 1. ONE-TO-ONE (1:1)
--    Each row in Table A relates to exactly ONE row in Table B.
--    Example: Each teacher has ONE email address (one teacher → one email).
--    Implemented by: UNIQUE FOREIGN KEY in one of the tables.

-- 2. ONE-TO-MANY (1:N) — Most common relationship
--    One row in Table A relates to MANY rows in Table B.
--    Example: One department has MANY teachers.
--             One teacher teaches MANY courses.
--    Implemented by: FOREIGN KEY in the "many" side table.

-- 3. MANY-TO-MANY (M:N)
--    Many rows in Table A relate to many rows in Table B.
--    Example: Students enroll in many courses; each course has many students.
--    Implemented by: A JUNCTION TABLE (enrollments) with foreign keys to both.

-- Query to demonstrate M:N via enrollments junction table:
SELECT   s.student_name,
         COUNT(e.course_id) AS courses_enrolled
FROM     students s
LEFT JOIN enrollments e ON s.student_id = e.student_id
GROUP BY s.student_name
ORDER BY courses_enrolled DESC;


-- ==========================================
-- Task 10: Practical Summary Query
-- ==========================================
-- Question: Write a comprehensive report showing:
--           Department | Teachers | Students | Courses | Avg Teacher Salary

-- Solution:
SELECT   d.dept_name                                AS Department,
         COUNT(DISTINCT t.teacher_id)               AS Total_Teachers,
         COUNT(DISTINCT s.student_id)               AS Total_Students,
         COUNT(DISTINCT c.course_id)                AS Total_Courses,
         IFNULL(ROUND(AVG(t.salary),2), 0)         AS Avg_Teacher_Salary
FROM     departments d
LEFT JOIN teachers  t ON d.dept_id = t.dept_id
LEFT JOIN students  s ON d.dept_id = s.dept_id
LEFT JOIN courses   c ON d.dept_id = c.dept_id
GROUP BY d.dept_name
ORDER BY d.dept_name;


-- ==========================================
-- END OF SESSION 05 ANSWERS
-- ==========================================
-- Topics Covered:
--   INNER JOIN
--   LEFT JOIN (LEFT OUTER JOIN)
--   RIGHT JOIN (RIGHT OUTER JOIN)
--   FULL OUTER JOIN (simulated with UNION)
--   CROSS JOIN
--   SELF JOIN
--   Multi-table JOINs
--   JOIN with GROUP BY and Aggregates
--   Table Relationships (1:1, 1:N, M:N)
-- Next Session: Session_06 (Pending - content not yet provided)
-- ==========================================
