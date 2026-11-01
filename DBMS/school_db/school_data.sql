-- ============================================================
-- Session 3 – DML Operations
-- File: school_data.sql
-- Folder: school_db
-- ============================================================

USE school_db;

-- -------------------------------------------------------
-- Task 1: INSERT students (at least 5 rows)
-- -------------------------------------------------------
INSERT INTO students (roll_no, name, grade, section, dob, gender, email) VALUES
(1,  'Aarav Sharma',   '10', 'A', '2010-03-15', 'M', 'aarav.sharma@school.in'),
(2,  'Diya Verma',     '10', 'A', '2010-07-22', 'F', 'diya.verma@school.in'),
(3,  'Rohan Mehta',    '10', 'B', '2009-11-05', 'M', 'rohan.mehta@school.in'),
(4,  'Priya Nair',     '10', 'B', '2010-01-30', 'F', 'priya.nair@school.in'),
(5,  'Karan Singh',    '10', 'A', '2010-06-18', 'M', 'karan.singh@school.in'),
(6,  'Ananya Pillai',  '10', 'C', '2009-09-12', 'F', 'ananya.pillai@school.in'),
(7,  'Vikram Joshi',   '10', 'C', '2010-02-28', 'M', 'vikram.joshi@school.in');

-- -------------------------------------------------------
-- Task 1: INSERT subjects (at least 4 rows)
-- -------------------------------------------------------
INSERT INTO subjects (subject_id, subject_name, max_marks) VALUES
(1, 'Mathematics',       100),
(2, 'Science',           100),
(3, 'English',           100),
(4, 'Social Studies',    100),
(5, 'Computer Science',  100);

-- -------------------------------------------------------
-- Task 1: INSERT marks – 20 rows (students x subjects)
-- -------------------------------------------------------
INSERT INTO marks (roll_no, subject_id, marks) VALUES
-- Aarav Sharma (roll_no 1)
(1, 1, 92), (1, 2, 88), (1, 3, 76), (1, 4, 83),
-- Diya Verma (roll_no 2)
(2, 1, 78), (2, 2, 85), (2, 3, 90), (2, 4, 72),
-- Rohan Mehta (roll_no 3)
(3, 1, 65), (3, 2, 70), (3, 3, 68), (3, 4, 74),
-- Priya Nair (roll_no 4)
(4, 1, 95), (4, 2, 91), (4, 3, 88), (4, 4, 94),
-- Karan Singh (roll_no 5)
(5, 1, 55), (5, 2, 60), (5, 3, 62), (5, 4, 58);

-- -------------------------------------------------------
-- Task 2: UPDATE – correct Rohan Mehta's Science marks
-- -------------------------------------------------------
UPDATE marks
SET    marks = 75
WHERE  roll_no = 3 AND subject_id = 2;

-- Task 2: UPDATE – update Karan Singh's email
UPDATE students
SET    email = 'karan.singhx@school.in'
WHERE  roll_no = 5;

-- -------------------------------------------------------
-- Task 3: INSERT duplicate marks row (to demonstrate)
-- -------------------------------------------------------
INSERT INTO marks (roll_no, subject_id, marks) VALUES
(5, 1, 55);

-- Task 3: DELETE the duplicate row (keep one, remove extra)
DELETE FROM marks
WHERE mark_id = (
    SELECT max_id FROM (
        SELECT MAX(mark_id) AS max_id
        FROM   marks
        WHERE  roll_no = 5 AND subject_id = 1
    ) AS t
);

-- -------------------------------------------------------
-- Task 3: DELETE a student (and their marks first due to FK)
-- -------------------------------------------------------
DELETE FROM marks   WHERE roll_no = 7;
DELETE FROM students WHERE roll_no = 7;

-- -------------------------------------------------------
-- Task 4: SELECT queries to verify data
-- -------------------------------------------------------
SELECT * FROM students;
SELECT * FROM subjects;
SELECT * FROM marks;

-- Count of students
SELECT COUNT(*) AS total_students FROM students;

-- All marks for Aarav Sharma
SELECT s.name, sub.subject_name, m.marks
FROM   marks m
JOIN   students s   ON m.roll_no    = s.roll_no
JOIN   subjects sub ON m.subject_id = sub.subject_id
WHERE  s.roll_no = 1;
