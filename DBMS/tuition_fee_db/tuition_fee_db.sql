-- ============================================================
-- Mini Project 3 – Tuition Fee DB
-- File: tuition_fee_db.sql
-- Folder: tuition_fee_db
-- Repository: tuition-fee-db (public GitHub)
-- ============================================================

-- Task 1: Create the database and tables with PKs and FKs
CREATE DATABASE IF NOT EXISTS tuition_fee_db;
USE tuition_fee_db;

-- -------------------------------------------------------
-- Table: students
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS students (
    student_id   INT          PRIMARY KEY AUTO_INCREMENT,
    name         VARCHAR(100) NOT NULL,
    email        VARCHAR(150) UNIQUE,
    phone        VARCHAR(15),
    address      VARCHAR(255),
    enrolled_on  DATE         NOT NULL DEFAULT (CURDATE())
);

-- -------------------------------------------------------
-- Table: courses
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS courses (
    course_id    INT          PRIMARY KEY AUTO_INCREMENT,
    course_name  VARCHAR(150) NOT NULL,
    duration_months INT       NOT NULL,
    monthly_fee  DECIMAL(10,2) NOT NULL
);

-- -------------------------------------------------------
-- Table: payments
-- (FK: student_id -> students, course_id -> courses)
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS payments (
    payment_id   INT           PRIMARY KEY AUTO_INCREMENT,
    student_id   INT           NOT NULL,
    course_id    INT           NOT NULL,
    amount_paid  DECIMAL(10,2) NOT NULL,
    payment_date DATE          NOT NULL DEFAULT (CURDATE()),
    payment_month VARCHAR(20)  NOT NULL  COMMENT 'e.g. 2026-01',
    payment_mode VARCHAR(50)   DEFAULT 'Cash',
    CONSTRAINT fk_payment_student FOREIGN KEY (student_id)
        REFERENCES students(student_id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_payment_course  FOREIGN KEY (course_id)
        REFERENCES courses(course_id)
        ON DELETE RESTRICT ON UPDATE CASCADE
);

-- -------------------------------------------------------
-- Task 2: CRUD Operations
-- -------------------------------------------------------

-- INSERT students
INSERT INTO students (name, email, phone, address, enrolled_on) VALUES
('Aarav Sharma',   'aarav.sharma@mail.com',   '9876543210', 'Mumbai',    '2026-06-01'),
('Diya Verma',     'diya.verma@mail.com',      '9876543211', 'Pune',      '2026-06-01'),
('Rohan Mehta',    'rohan.mehta@mail.com',     '9876543212', 'Delhi',     '2026-07-01'),
('Priya Nair',     'priya.nair@mail.com',      '9876543213', 'Chennai',   '2026-07-01'),
('Karan Singh',    'karan.singh@mail.com',     '9876543214', 'Bengaluru', '2026-08-01'),
('Ananya Pillai',  'ananya.pillai@mail.com',   '9876543215', 'Hyderabad', '2026-08-01'),
('Vikram Joshi',   'vikram.joshi@mail.com',    '9876543216', 'Kolkata',   '2026-09-01'),
('Sneha Iyer',     'sneha.iyer@mail.com',      '9876543217', 'Ahmedabad', '2026-09-01');

-- INSERT courses
INSERT INTO courses (course_name, duration_months, monthly_fee) VALUES
('Mathematics Tuition',         6, 1500.00),
('Science & Technology',        6, 1800.00),
('English Communication',       3, 1200.00),
('Computer Fundamentals',       4, 2000.00),
('Commerce & Accountancy',      6, 1600.00);

-- INSERT payments – Month 1 (2026-09)
INSERT INTO payments (student_id, course_id, amount_paid, payment_date, payment_month, payment_mode) VALUES
(1, 1, 1500.00, '2026-09-02', '2026-09', 'Online'),
(2, 2, 1800.00, '2026-09-03', '2026-09', 'Cash'),
(3, 1, 1500.00, '2026-09-05', '2026-09', 'Online'),
(4, 3, 1200.00, '2026-09-06', '2026-09', 'UPI'),
(5, 4, 2000.00, '2026-09-08', '2026-09', 'Cheque'),
(6, 2, 1800.00, '2026-09-10', '2026-09', 'Cash'),
(7, 5, 1600.00, '2026-09-12', '2026-09', 'Online'),
(8, 4, 2000.00, '2026-09-15', '2026-09', 'UPI');

-- INSERT payments – Month 2 (2026-10)
INSERT INTO payments (student_id, course_id, amount_paid, payment_date, payment_month, payment_mode) VALUES
(1, 1, 1500.00, '2026-10-03', '2026-10', 'Online'),
(2, 2, 1800.00, '2026-10-04', '2026-10', 'Cash'),
(3, 1, 1500.00, '2026-10-06', '2026-10', 'Online'),
(4, 3, 1200.00, '2026-10-07', '2026-10', 'UPI'),
(5, 4, 2000.00, '2026-10-09', '2026-10', 'Cheque'),
(6, 2, 1800.00, '2026-10-11', '2026-10', 'Cash'),
(7, 5, 1600.00, '2026-10-14', '2026-10', 'Online'),
(8, 4, 2000.00, '2026-10-16', '2026-10', 'UPI');

-- UPDATE – Change Karan Singh's phone number
UPDATE students
SET    phone = '9998887770'
WHERE  student_id = 5;

-- UPDATE – Correct a payment amount (Diya Verma, Oct)
UPDATE payments
SET    amount_paid = 1800.00
WHERE  student_id = 2 AND payment_month = '2026-10';

-- DELETE – Remove a test payment record (if any duplicate)
-- (No duplicate in this dataset – shown for completeness)
-- DELETE FROM payments WHERE payment_id = 0;

-- -------------------------------------------------------
-- Task 3: JOIN Queries
-- -------------------------------------------------------

-- JOIN 1: All payments with student name and course name
SELECT
    p.payment_id                      AS "Payment ID",
    s.name                            AS "Student Name",
    c.course_name                     AS "Course",
    p.amount_paid                     AS "Amount Paid (Rs)",
    p.payment_month                   AS "Month",
    p.payment_mode                    AS "Mode"
FROM   payments p
INNER JOIN students s ON p.student_id = s.student_id
INNER JOIN courses  c ON p.course_id  = c.course_id
ORDER BY p.payment_month, s.name;

-- JOIN 2: Students who have NOT yet paid for current month
SELECT
    s.student_id  AS "Student ID",
    s.name        AS "Student Name",
    s.phone       AS "Contact"
FROM   students s
LEFT JOIN payments p
       ON s.student_id = p.student_id
      AND p.payment_month = '2026-10'
WHERE  p.payment_id IS NULL;

-- JOIN 3: Total fees collected per course
SELECT
    c.course_name             AS "Course",
    COUNT(p.payment_id)       AS "Payments Received",
    SUM(p.amount_paid)        AS "Total Collected (Rs)"
FROM   courses  c
LEFT JOIN payments p ON c.course_id = p.course_id
GROUP BY c.course_id, c.course_name
ORDER BY SUM(p.amount_paid) DESC;

-- -------------------------------------------------------
-- Task 4: Stored Procedure – monthly_fee_summary
-- Returns: student name, course, amount_paid, month
-- and the monthly total for a given payment_month
-- -------------------------------------------------------

DELIMITER $$

DROP PROCEDURE IF EXISTS monthly_fee_summary$$

CREATE PROCEDURE monthly_fee_summary(IN p_month VARCHAR(20))
BEGIN
    -- Detail: each payment for the month
    SELECT
        s.name                             AS "Student Name",
        c.course_name                      AS "Course",
        p.amount_paid                      AS "Amount Paid (Rs)",
        p.payment_date                     AS "Payment Date",
        p.payment_mode                     AS "Payment Mode"
    FROM   payments p
    INNER JOIN students s ON p.student_id = s.student_id
    INNER JOIN courses  c ON p.course_id  = c.course_id
    WHERE  p.payment_month = p_month
    ORDER BY s.name;

    -- Summary: total collected for the month
    SELECT
        p_month                            AS "Month",
        COUNT(p.payment_id)                AS "Total Payments",
        SUM(p.amount_paid)                 AS "Total Amount Collected (Rs)",
        ROUND(AVG(p.amount_paid), 2)       AS "Average Payment (Rs)"
    FROM   payments p
    WHERE  p.payment_month = p_month;
END$$

DELIMITER ;

-- -------------------------------------------------------
-- Verification: Run procedure for both months
-- (Output of these calls → save as summary_month1.png and
--  summary_month2.png using MySQL Workbench)
-- -------------------------------------------------------

-- Month 1 summary → screenshot as summary_month1.png
CALL monthly_fee_summary('2026-09');

-- Month 2 summary → screenshot as summary_month2.png
CALL monthly_fee_summary('2026-10');

-- -------------------------------------------------------
-- Additional verification queries
-- -------------------------------------------------------

-- All students
SELECT * FROM students;

-- All courses
SELECT * FROM courses;

-- All payments ordered by month
SELECT * FROM payments ORDER BY payment_month, student_id;

-- Grand total collected across all months
SELECT
    SUM(amount_paid)  AS "Grand Total (Rs)",
    COUNT(payment_id) AS "Total Payment Records"
FROM payments;
