-- ============================================================
-- Session 4 – Data Retrieval with SELECT
-- File: school_queries.sql
-- Folder: school_db
-- ============================================================

USE school_db;

-- -------------------------------------------------------
-- Task 1: Basic SELECT queries with filtering and sorting
-- -------------------------------------------------------

-- Select all students
SELECT * FROM students;

-- Select students in section 'A'
SELECT roll_no, name, grade, section
FROM   students
WHERE  section = 'A';

-- Select all female students
SELECT roll_no, name, gender
FROM   students
WHERE  gender = 'F';

-- Sort students alphabetically by name
SELECT roll_no, name, grade, section
FROM   students
ORDER BY name ASC;

-- -------------------------------------------------------
-- Task 2: SELECT with aliases
-- -------------------------------------------------------

-- Aliases on column names
SELECT
    s.roll_no  AS "Roll Number",
    s.name     AS "Student Name",
    s.grade    AS "Class",
    s.section  AS "Section"
FROM students s
ORDER BY s.roll_no;

-- Total marks per student with alias
SELECT
    s.roll_no                 AS "Roll No",
    s.name                    AS "Student Name",
    SUM(m.marks)              AS "Total Marks",
    ROUND(AVG(m.marks), 2)   AS "Average Marks"
FROM   students s
JOIN   marks    m ON s.roll_no = m.roll_no
GROUP BY s.roll_no, s.name
ORDER BY SUM(m.marks) DESC;

-- -------------------------------------------------------
-- Task 3: Aggregate functions – SUM, AVG, COUNT
-- -------------------------------------------------------

-- Total marks obtained by each student
SELECT
    s.name          AS "Student Name",
    SUM(m.marks)    AS "Total Marks"
FROM   students s
JOIN   marks    m ON s.roll_no = m.roll_no
GROUP BY s.roll_no, s.name
ORDER BY SUM(m.marks) DESC;

-- Average marks per subject
SELECT
    sub.subject_name     AS "Subject",
    ROUND(AVG(m.marks), 2) AS "Average Marks",
    MAX(m.marks)           AS "Highest Marks",
    MIN(m.marks)           AS "Lowest Marks"
FROM   subjects sub
JOIN   marks    m ON sub.subject_id = m.subject_id
GROUP BY sub.subject_id, sub.subject_name
ORDER BY AVG(m.marks) DESC;

-- Count of students
SELECT COUNT(*) AS "Total Students" FROM students;

-- Count of marks records per subject
SELECT
    sub.subject_name      AS "Subject",
    COUNT(m.mark_id)      AS "Students Appeared"
FROM   subjects sub
JOIN   marks    m ON sub.subject_id = m.subject_id
GROUP BY sub.subject_id, sub.subject_name;

-- -------------------------------------------------------
-- Task 4: Topper query – student with highest total marks
-- (save the output as topper.png)
-- -------------------------------------------------------
SELECT
    s.roll_no                AS "Roll No",
    s.name                   AS "Topper Name",
    s.grade                  AS "Class",
    s.section                AS "Section",
    SUM(m.marks)             AS "Total Marks",
    ROUND(AVG(m.marks), 2)  AS "Average Marks"
FROM   students s
JOIN   marks    m ON s.roll_no = m.roll_no
GROUP BY s.roll_no, s.name, s.grade, s.section
ORDER BY SUM(m.marks) DESC
LIMIT 1;
