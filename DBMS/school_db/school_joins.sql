-- ============================================================
-- Session 5 – Joins and Relationships
-- File: school_joins.sql
-- Folder: school_db
-- ============================================================

USE school_db;

-- -------------------------------------------------------
-- Task 1: Add Foreign Key constraints to marks table
-- (marks.roll_no -> students.roll_no)
-- (marks.subject_id -> subjects.subject_id)
-- -------------------------------------------------------

-- Add foreign key: marks.roll_no references students.roll_no
ALTER TABLE marks
    ADD CONSTRAINT fk_marks_student
    FOREIGN KEY (roll_no) REFERENCES students(roll_no)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

-- Add foreign key: marks.subject_id references subjects.subject_id
ALTER TABLE marks
    ADD CONSTRAINT fk_marks_subject
    FOREIGN KEY (subject_id) REFERENCES subjects(subject_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

-- -------------------------------------------------------
-- Task 2: Test referential integrity – attempt to insert
-- a marks row with an invalid roll_no (should fail)
-- -------------------------------------------------------

-- This INSERT should raise an error: roll_no 99 does not exist
-- (run manually and observe the error – comment out after testing)
-- INSERT INTO marks (roll_no, subject_id, marks) VALUES (99, 1, 80);

-- -------------------------------------------------------
-- Task 3: JOIN queries
-- -------------------------------------------------------

-- INNER JOIN – students and their marks with subject name
SELECT
    s.roll_no          AS "Roll No",
    s.name             AS "Student Name",
    sub.subject_name   AS "Subject",
    m.marks            AS "Marks Obtained"
FROM   marks    m
INNER JOIN students s   ON m.roll_no    = s.roll_no
INNER JOIN subjects sub ON m.subject_id = sub.subject_id
ORDER BY s.roll_no, sub.subject_id;

-- LEFT JOIN – all students (even those without marks records)
SELECT
    s.roll_no          AS "Roll No",
    s.name             AS "Student Name",
    sub.subject_name   AS "Subject",
    COALESCE(m.marks, 'N/A') AS "Marks"
FROM   students s
LEFT JOIN marks   m   ON s.roll_no    = m.roll_no
LEFT JOIN subjects sub ON m.subject_id = sub.subject_id
ORDER BY s.roll_no;

-- RIGHT JOIN – all subjects (even those without marks records)
SELECT
    sub.subject_id     AS "Subject ID",
    sub.subject_name   AS "Subject",
    s.name             AS "Student Name",
    m.marks            AS "Marks Obtained"
FROM   marks    m
RIGHT JOIN subjects sub ON m.subject_id = sub.subject_id
LEFT  JOIN students s   ON m.roll_no    = s.roll_no
ORDER BY sub.subject_id;

-- -------------------------------------------------------
-- Task 4: Comprehensive JOIN – total marks per student
-- using all three tables
-- -------------------------------------------------------
SELECT
    s.roll_no                AS "Roll No",
    s.name                   AS "Student Name",
    s.grade                  AS "Class",
    s.section                AS "Section",
    COUNT(m.subject_id)      AS "Subjects Appeared",
    SUM(m.marks)             AS "Total Marks",
    ROUND(AVG(m.marks), 2)  AS "Average",
    MAX(m.marks)             AS "Highest Mark",
    MIN(m.marks)             AS "Lowest Mark"
FROM   students s
INNER JOIN marks    m   ON s.roll_no    = m.roll_no
INNER JOIN subjects sub ON m.subject_id = sub.subject_id
GROUP BY s.roll_no, s.name, s.grade, s.section
ORDER BY SUM(m.marks) DESC;
