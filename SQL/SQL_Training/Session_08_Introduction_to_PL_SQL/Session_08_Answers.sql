-- ==========================================
-- SESSION 08: INTRODUCTION TO PL/SQL
-- ==========================================
-- File   : Session_08_Answers.sql
-- Author : SQL Training
-- Date   : 2026-10-29
-- Description: Answers for Session 08 - Introduction to PL/SQL in MySQL
--              Covers Stored Procedures, Functions, Variables, IF/ELSE,
--              Loops (LOOP, WHILE, REPEAT), Cursors.
-- IMPORTANT: In MySQL, PL/SQL is called "Stored Program" or "Routine".
--            MySQL uses its own procedural language (similar to PL/SQL).
-- How to Run:
--   Open in MySQL Workbench.
--   Run Ctrl+Shift+Enter to execute the entire file,
--   OR copy each DELIMITER block and run one at a time.
-- ==========================================


-- ==========================================
-- SETUP
-- ==========================================
CREATE DATABASE IF NOT EXISTS session08_plsql;
USE session08_plsql;

-- Create sample table for procedure examples:
CREATE TABLE IF NOT EXISTS students (
    student_id   INT         PRIMARY KEY AUTO_INCREMENT,
    student_name VARCHAR(100) NOT NULL,
    marks        INT,
    grade        CHAR(2),
    result       VARCHAR(10)
);

INSERT INTO students (student_name, marks) VALUES
('Ananya Roy',     88),
('Rohan Mehta',    52),
('Priya Sharma',   95),
('Karan Verma',    33),
('Divya Nair',     72),
('Suresh Kumar',   61),
('Meena Pillai',   78),
('Arun Das',       45);


-- ==========================================
-- Task 1: What is PL/SQL (Stored Programs in MySQL)?
-- ==========================================
-- Question: What is a stored procedure? What are its advantages?
--           Explain DELIMITER and why it is needed.

-- Solution (Explanation in comments):
-- A STORED PROCEDURE is a named, saved block of SQL statements that can
-- be CALLED by name to perform a task. Think of it like a function in
-- programming.

-- ADVANTAGES of Stored Procedures:
-- 1. Reusability    → Write once, call many times.
-- 2. Performance    → Pre-compiled, runs faster than sending SQL each time.
-- 3. Security       → Users can call the procedure without seeing SQL logic.
-- 4. Maintainability→ Change the procedure once instead of every application.
-- 5. Reduced Network Traffic → Send one CALL instead of many SQL statements.

-- WHY DELIMITER IS NEEDED:
-- MySQL uses semicolon (;) as the statement terminator.
-- Inside a procedure, we have multiple statements ending with (;).
-- If MySQL sees a (;) inside the procedure, it thinks the procedure ended.
-- DELIMITER $$ changes the terminator to $$ temporarily,
-- so MySQL knows the entire CREATE PROCEDURE block is ONE statement.
-- After the procedure, we change DELIMITER back to ;

-- Verification that the database is set up correctly:
SELECT DATABASE() AS current_db;
SELECT COUNT(*) AS student_count FROM students;


-- ==========================================
-- Task 2: Simple Stored Procedure (No Parameters)
-- ==========================================
-- Question: Create a stored procedure named show_all_students that
--           retrieves all students and their marks.

-- Solution:
DELIMITER $$

CREATE PROCEDURE show_all_students()
BEGIN
    -- This procedure fetches all student records
    SELECT student_id,
           student_name,
           marks
    FROM   students
    ORDER BY marks DESC;
END $$

DELIMITER ;

-- How to CALL the procedure:
CALL show_all_students();

-- How to VIEW the procedure definition:
SHOW CREATE PROCEDURE show_all_students;

-- How to DROP (delete) the procedure:
-- DROP PROCEDURE IF EXISTS show_all_students;

-- Explanation:
-- DELIMITER $$    → changes the statement terminator to $$.
-- CREATE PROCEDURE name() → defines the procedure name and parameters.
-- BEGIN ... END   → wraps the procedure body.
-- $$              → signals the END of the CREATE PROCEDURE statement.
-- DELIMITER ;     → restores the normal semicolon terminator.
-- CALL name();    → executes the procedure.


-- ==========================================
-- Task 3: Stored Procedure with IN Parameter
-- ==========================================
-- Question: Create a procedure get_student_by_id that accepts a student_id
--           and returns that student's details.

-- Solution:
DELIMITER $$

CREATE PROCEDURE get_student_by_id(IN p_student_id INT)
BEGIN
    SELECT student_id,
           student_name,
           marks,
           grade,
           result
    FROM   students
    WHERE  student_id = p_student_id;
END $$

DELIMITER ;

-- Call with specific student_id:
CALL get_student_by_id(1);
CALL get_student_by_id(4);

-- Explanation:
-- IN parameter → value is PASSED INTO the procedure (read-only inside).
-- p_student_id → prefix 'p_' is a naming convention for parameters.
-- The procedure uses the parameter in the WHERE clause.


-- ==========================================
-- Task 4: Stored Procedure with OUT Parameter
-- ==========================================
-- Question: Create a procedure get_student_count that returns the
--           total number of students using an OUT parameter.

-- Solution:
DELIMITER $$

CREATE PROCEDURE get_student_count(OUT p_count INT)
BEGIN
    SELECT COUNT(*) INTO p_count
    FROM   students;
END $$

DELIMITER ;

-- Call and retrieve the OUT parameter:
CALL get_student_count(@total);
SELECT @total AS total_students;

-- Explanation:
-- OUT parameter → value is RETURNED FROM the procedure to the caller.
-- INTO @variable → stores the result into a session variable.
-- @variable → a session-level variable in MySQL (visible until disconnected).


-- ==========================================
-- Task 5: Stored Procedure with INOUT Parameter
-- ==========================================
-- Question: Create a procedure apply_bonus that takes a salary amount
--           and applies a 15% bonus, returning the new salary.

-- Solution:
DELIMITER $$

CREATE PROCEDURE apply_bonus(INOUT p_salary DECIMAL(10,2))
BEGIN
    SET p_salary = p_salary + (p_salary * 0.15);
    -- Adds 15% bonus to the incoming salary
END $$

DELIMITER ;

-- Call with a salary value:
SET @my_salary = 50000.00;
CALL apply_bonus(@my_salary);
SELECT @my_salary AS salary_after_bonus;  -- Should show 57500.00

-- Explanation:
-- INOUT parameter → value is passed IN and a (possibly modified) value
--                   is returned OUT. It works in both directions.


-- ==========================================
-- Task 6: Variables and IF-ELSE in Procedures
-- ==========================================
-- Question: Create a procedure assign_grade that:
--           - Accepts marks as input
--           - Uses IF-ELSEIF-ELSE to determine the grade (A, B, C, D, F)
--           - Also sets PASS or FAIL result
--           - Returns the grade and result

-- Solution:
DELIMITER $$

CREATE PROCEDURE assign_grade(
    IN  p_marks  INT,
    OUT p_grade  CHAR(2),
    OUT p_result VARCHAR(10)
)
BEGIN
    -- Determine grade using IF-ELSEIF-ELSE
    IF p_marks >= 90 THEN
        SET p_grade  = 'A';
        SET p_result = 'PASS';
    ELSEIF p_marks >= 75 THEN
        SET p_grade  = 'B';
        SET p_result = 'PASS';
    ELSEIF p_marks >= 60 THEN
        SET p_grade  = 'C';
        SET p_result = 'PASS';
    ELSEIF p_marks >= 35 THEN
        SET p_grade  = 'D';
        SET p_result = 'PASS';
    ELSE
        SET p_grade  = 'F';
        SET p_result = 'FAIL';
    END IF;
END $$

DELIMITER ;

-- Test the procedure with different marks:
CALL assign_grade(95, @g, @r);
SELECT @g AS grade, @r AS result;    -- Expected: A, PASS

CALL assign_grade(72, @g, @r);
SELECT @g AS grade, @r AS result;    -- Expected: B, PASS

CALL assign_grade(30, @g, @r);
SELECT @g AS grade, @r AS result;    -- Expected: F, FAIL

-- Explanation:
-- DECLARE is used for LOCAL variables (inside BEGIN...END).
-- SET is used to assign values to variables.
-- IF ... ELSEIF ... ELSE ... END IF → standard conditional structure.


-- ==========================================
-- Task 7: Stored Procedure with WHILE Loop
-- ==========================================
-- Question: Create a procedure update_all_grades that loops through all
--           students and calls assign_grade logic to update their grade
--           and result columns.

-- Solution:
DELIMITER $$

CREATE PROCEDURE update_all_grades()
BEGIN
    DECLARE v_id      INT;
    DECLARE v_marks   INT;
    DECLARE v_grade   CHAR(2);
    DECLARE v_result  VARCHAR(10);
    DECLARE v_done    BOOLEAN DEFAULT FALSE;

    -- Declare a CURSOR to loop through each student
    DECLARE student_cursor CURSOR FOR
        SELECT student_id, marks FROM students;

    -- Declare a CONTINUE HANDLER for end of cursor
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_done = TRUE;

    -- Open the cursor
    OPEN student_cursor;

    -- Loop through each student
    student_loop: LOOP
        FETCH student_cursor INTO v_id, v_marks;

        IF v_done THEN
            LEAVE student_loop;   -- Exit loop when no more rows
        END IF;

        -- Determine grade based on marks
        IF v_marks >= 90 THEN
            SET v_grade = 'A'; SET v_result = 'PASS';
        ELSEIF v_marks >= 75 THEN
            SET v_grade = 'B'; SET v_result = 'PASS';
        ELSEIF v_marks >= 60 THEN
            SET v_grade = 'C'; SET v_result = 'PASS';
        ELSEIF v_marks >= 35 THEN
            SET v_grade = 'D'; SET v_result = 'PASS';
        ELSE
            SET v_grade = 'F'; SET v_result = 'FAIL';
        END IF;

        -- Update the student's grade and result
        UPDATE students
        SET    grade  = v_grade,
               result = v_result
        WHERE  student_id = v_id;

    END LOOP student_loop;

    CLOSE student_cursor;

    SELECT 'All student grades updated successfully.' AS message;
END $$

DELIMITER ;

-- Execute the procedure:
CALL update_all_grades();

-- Verification:
SELECT student_id, student_name, marks, grade, result
FROM   students
ORDER BY marks DESC;

-- Expected Output (partial):
-- +------------+--------------+-------+-------+--------+
-- | student_id | student_name | marks | grade | result |
-- +------------+--------------+-------+-------+--------+
-- |          3 | Priya Sharma |    95 | A     | PASS   |
-- |          1 | Ananya Roy   |    88 | B     | PASS   |
-- |          7 | Meena Pillai |    78 | B     | PASS   |
-- |          5 | Divya Nair   |    72 | C     | PASS   |
-- |          6 | Suresh Kumar |    61 | C     | PASS   |
-- |          2 | Rohan Mehta  |    52 | D     | PASS   |
-- |          8 | Arun Das     |    45 | D     | PASS   |
-- |          4 | Karan Verma  |    33 | F     | FAIL   |
-- +------------+--------------+-------+-------+--------+

-- Explanation of CURSOR:
-- CURSOR → a database object used to traverse rows one by one.
-- DECLARE cursor_name CURSOR FOR SELECT ... → defines which rows to loop over.
-- OPEN cursor → starts the traversal.
-- FETCH cursor INTO var1, var2 → gets the next row's values.
-- NOT FOUND handler → fires when FETCH has no more rows.
-- CLOSE cursor → releases the cursor resource.
-- LEAVE loop_label → exits a labeled loop.


-- ==========================================
-- Task 8: Stored Function
-- ==========================================
-- Question: What is the difference between a PROCEDURE and a FUNCTION?
--           Create a function get_letter_grade(marks INT) that returns
--           the grade as a CHAR value.

-- Solution (Explanation in comments):
-- PROCEDURE:                        FUNCTION:
-- Called with CALL                  Called inside a SELECT/expression
-- Can return 0 or more OUT params   Must return EXACTLY ONE value
-- Cannot be used in SELECT          Can be used in SELECT, WHERE, etc.
-- Can modify tables                 Typically does NOT modify tables

DELIMITER $$

CREATE FUNCTION get_letter_grade(p_marks INT)
RETURNS CHAR(2)
DETERMINISTIC
BEGIN
    DECLARE v_grade CHAR(2);

    IF p_marks >= 90 THEN
        SET v_grade = 'A';
    ELSEIF p_marks >= 75 THEN
        SET v_grade = 'B';
    ELSEIF p_marks >= 60 THEN
        SET v_grade = 'C';
    ELSEIF p_marks >= 35 THEN
        SET v_grade = 'D';
    ELSE
        SET v_grade = 'F';
    END IF;

    RETURN v_grade;
END $$

DELIMITER ;

-- Using the function directly in a SELECT:
SELECT student_name,
       marks,
       get_letter_grade(marks) AS computed_grade
FROM   students
ORDER BY marks DESC;

-- Using the function in WHERE clause:
SELECT student_name, marks
FROM   students
WHERE  get_letter_grade(marks) = 'A';

-- Explanation:
-- RETURNS CHAR(2)    → specifies the return data type.
-- DETERMINISTIC      → same input always gives same output (required in some configs).
-- RETURN v_grade     → the RETURN statement exits the function and provides the value.


-- ==========================================
-- Task 9: WHILE Loop Example
-- ==========================================
-- Question: Create a procedure using WHILE loop to count how many
--           students PASSED (marks >= 35) and FAILED.

-- Solution:
DELIMITER $$

CREATE PROCEDURE count_pass_fail(
    OUT p_pass INT,
    OUT p_fail INT
)
BEGIN
    DECLARE v_marks  INT;
    DECLARE v_done   BOOLEAN DEFAULT FALSE;
    DECLARE v_pass   INT DEFAULT 0;
    DECLARE v_fail   INT DEFAULT 0;

    DECLARE marks_cursor CURSOR FOR
        SELECT marks FROM students;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_done = TRUE;

    OPEN marks_cursor;

    marks_loop: LOOP
        FETCH marks_cursor INTO v_marks;

        IF v_done THEN
            LEAVE marks_loop;
        END IF;

        IF v_marks >= 35 THEN
            SET v_pass = v_pass + 1;
        ELSE
            SET v_fail = v_fail + 1;
        END IF;
    END LOOP;

    CLOSE marks_cursor;

    SET p_pass = v_pass;
    SET p_fail = v_fail;
END $$

DELIMITER ;

-- Execute and check results:
CALL count_pass_fail(@passed, @failed);
SELECT @passed AS students_passed, @failed AS students_failed;


-- ==========================================
-- Task 10: DROP and List Procedures/Functions
-- ==========================================
-- Question: How do you view and drop stored procedures and functions?

-- Solution:

-- View all stored procedures and functions in current database:
SHOW PROCEDURE STATUS WHERE Db = 'session08_plsql';
SHOW FUNCTION  STATUS WHERE Db = 'session08_plsql';

-- View the definition of a procedure:
SHOW CREATE PROCEDURE update_all_grades;
SHOW CREATE FUNCTION  get_letter_grade;

-- Drop a procedure:
-- DROP PROCEDURE IF EXISTS procedure_name;

-- Drop a function:
-- DROP FUNCTION IF EXISTS function_name;

-- Final verification: run all procedures
CALL show_all_students();


-- ==========================================
-- END OF SESSION 08 ANSWERS
-- ==========================================
-- Topics Covered:
--   Stored Procedures (no params, IN, OUT, INOUT)
--   Variables (DECLARE, SET, @session variables)
--   IF-ELSEIF-ELSE conditional logic
--   LOOP with LEAVE
--   CURSOR (DECLARE, OPEN, FETCH, CLOSE)
--   NOT FOUND handler
--   Stored Functions (RETURNS, RETURN, DETERMINISTIC)
--   SHOW PROCEDURE/FUNCTION STATUS
-- Next Session: Session_09_Transactions_and_Error_Handling
-- ==========================================
