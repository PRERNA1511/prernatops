-- ==========================================
-- PROJECT: BUS PASS SYSTEM
-- File   : SQL_Questions_Answers.sql
-- Author : SQL Training
-- Date   : 2026-10-29
-- Description: Complete SQL questions and answers for the Bus Pass
--              mini-project. Covers database creation, table design,
--              DML, queries, and joins for a school bus pass system.
-- Database: bus_pass
-- ==========================================


-- ==========================================
-- SECTION 1: DATABASE AND TABLE SETUP
-- ==========================================

-- Task 1: Create the bus_pass database
CREATE DATABASE IF NOT EXISTS bus_pass;
USE bus_pass;

-- Explanation:
-- This database manages school student bus passes, including
-- passenger details, routes, and pass validity.


-- Task 2: Create the passengers table
-- Question: Design a table to store student/passenger information
--           for a school bus pass system.

CREATE TABLE IF NOT EXISTS passengers (
    passenger_id    INT           PRIMARY KEY AUTO_INCREMENT,
    full_name       VARCHAR(100)  NOT NULL,
    roll_number     VARCHAR(20)   UNIQUE NOT NULL,
    class           VARCHAR(10)   NOT NULL,
    section         CHAR(1),
    contact_number  CHAR(10),
    address         TEXT,
    created_at      TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
);

-- Screenshot to take: passengers_table.png
-- How: After running DESCRIBE passengers; take a screenshot of the result grid.
DESCRIBE passengers;


-- Task 3: Create the routes table
CREATE TABLE IF NOT EXISTS routes (
    route_id        INT           PRIMARY KEY AUTO_INCREMENT,
    route_name      VARCHAR(100)  NOT NULL,
    start_point     VARCHAR(100),
    end_point       VARCHAR(100),
    distance_km     DECIMAL(5,2),
    monthly_fee     DECIMAL(8,2)  NOT NULL
);


-- Task 4: Create the bus_passes table (main table)
CREATE TABLE IF NOT EXISTS bus_passes (
    pass_id         INT           PRIMARY KEY AUTO_INCREMENT,
    passenger_id    INT           NOT NULL,
    route_id        INT           NOT NULL,
    pass_number     VARCHAR(20)   UNIQUE NOT NULL,
    issue_date      DATE          NOT NULL,
    expiry_date     DATE          NOT NULL,
    is_active       BOOLEAN       DEFAULT TRUE,
    fee_paid        DECIMAL(8,2)  NOT NULL,
    FOREIGN KEY (passenger_id) REFERENCES passengers(passenger_id),
    FOREIGN KEY (route_id)     REFERENCES routes(route_id)
);


-- ==========================================
-- SECTION 2: INSERT SAMPLE DATA
-- ==========================================

-- Task 5: Insert routes
INSERT INTO routes (route_name, start_point, end_point, distance_km, monthly_fee) VALUES
('Route A - City Centre',  'City Bus Stand',   'School Gate',      5.5,  500.00),
('Route B - North Zone',   'North Colony',     'School Gate',      8.0,  650.00),
('Route C - East Zone',    'East Market',      'School Gate',      6.2,  550.00),
('Route D - West Zone',    'West Station',     'School Gate',      7.5,  600.00),
('Route E - South Zone',   'South Township',   'School Gate',      9.0,  700.00);

-- Task 6: Insert passengers
INSERT INTO passengers (full_name, roll_number, class, section, contact_number, address) VALUES
('Ananya Sharma',      'R001', '10', 'A', '9876543210', '12, MG Road, City Centre'),
('Rohan Patel',        'R002', '10', 'B', '9765432109', '45, North Block, North Colony'),
('Priya Nair',         'R003',  '9', 'A', '9654321098', '78, East Avenue, East Market'),
('Karan Mehta',        'R004', '11', 'C', '9543210987', '23, West End, West Station'),
('Divya Krishnan',     'R005', '12', 'A', '9432109876', '56, South Park, South Township'),
('Suresh Babu',        'R006', '10', 'A', '9321098765', '34, Central Mall, City Centre'),
('Meena Pillai',       'R007',  '9', 'B', '9210987654', '67, North Hills, North Colony'),
('Aditya Singh',       'R008', '11', 'A', '9109876543', '89, East Lane, East Market'),
('Leela Rao',          'R009', '12', 'B', '9098765432', '12, West Colony, West Station'),
('Vikram Joshi',       'R010', '10', 'C', '9876509871', '45, South Gate, South Township');

-- Task 7: Issue bus passes
INSERT INTO bus_passes (passenger_id, route_id, pass_number, issue_date, expiry_date, fee_paid) VALUES
(1,  1, 'BP2025001', '2025-06-01', '2026-05-31', 500.00),
(2,  2, 'BP2025002', '2025-06-01', '2026-05-31', 650.00),
(3,  3, 'BP2025003', '2025-06-01', '2026-05-31', 550.00),
(4,  4, 'BP2025004', '2025-06-01', '2026-05-31', 600.00),
(5,  5, 'BP2025005', '2025-06-01', '2026-05-31', 700.00),
(6,  1, 'BP2025006', '2025-06-01', '2026-05-31', 500.00),
(7,  2, 'BP2025007', '2025-06-01', '2026-05-31', 650.00),
(8,  3, 'BP2025008', '2025-06-01', '2026-05-31', 550.00),
(9,  4, 'BP2025009', '2025-06-01', '2026-05-31', 600.00),
(10, 5, 'BP2025010', '2025-06-01', '2026-05-31', 700.00);

-- ==========================================
-- SECTION 3: QUERY ANSWERS
-- ==========================================

-- Q1: List all active passengers with their route names.
SELECT p.full_name         AS Passenger_Name,
       p.roll_number       AS Roll_No,
       p.class             AS Class,
       r.route_name        AS Route,
       bp.pass_number      AS Pass_No,
       bp.expiry_date      AS Valid_Until
FROM   bus_passes bp
INNER JOIN passengers p ON bp.passenger_id = p.passenger_id
INNER JOIN routes     r ON bp.route_id     = r.route_id
WHERE  bp.is_active = TRUE
ORDER BY p.full_name;

-- Q2: Show total revenue collected per route.
SELECT   r.route_name,
         COUNT(bp.pass_id)       AS passes_issued,
         SUM(bp.fee_paid)        AS total_revenue
FROM     bus_passes bp
INNER JOIN routes r ON bp.route_id = r.route_id
GROUP BY r.route_name
ORDER BY total_revenue DESC;

-- Q3: Find passengers whose pass expires within 90 days from today.
SELECT p.full_name,
       bp.pass_number,
       bp.expiry_date,
       DATEDIFF(bp.expiry_date, CURDATE()) AS days_remaining
FROM   bus_passes bp
INNER JOIN passengers p ON bp.passenger_id = p.passenger_id
WHERE  bp.expiry_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 90 DAY)
ORDER BY days_remaining;

-- Q4: Count students per class using a bus pass.
SELECT   p.class,
         COUNT(bp.pass_id) AS students_using_bus
FROM     bus_passes bp
INNER JOIN passengers p ON bp.passenger_id = p.passenger_id
WHERE  bp.is_active = TRUE
GROUP BY p.class
ORDER BY p.class;

-- Q5: Find the most expensive route.
SELECT route_name, monthly_fee, distance_km
FROM   routes
ORDER BY monthly_fee DESC
LIMIT  1;

-- Q6: Update - Mark a pass as inactive (student left school).
UPDATE bus_passes
SET    is_active = FALSE
WHERE  pass_number = 'BP2025010';

SELECT pass_number, is_active FROM bus_passes WHERE pass_number = 'BP2025010';

-- Q7: Which route has the most passengers?
SELECT   r.route_name,
         COUNT(bp.pass_id) AS passenger_count
FROM     routes r
LEFT JOIN bus_passes bp ON r.route_id = bp.route_id
                        AND bp.is_active = TRUE
GROUP BY r.route_name
ORDER BY passenger_count DESC;


-- ==========================================
-- SECTION 4: VERIFICATION QUERIES
-- ==========================================
SHOW TABLES;
SELECT COUNT(*) AS total_passengers  FROM passengers;
SELECT COUNT(*) AS total_routes      FROM routes;
SELECT COUNT(*) AS total_passes      FROM bus_passes;
SELECT COUNT(*) AS active_passes     FROM bus_passes WHERE is_active = TRUE;


-- ==========================================
-- How to Execute in MySQL Workbench:
-- 1. File → Open SQL Script → Select this file.
-- 2. Click "Execute All" (lightning bolt icon) OR press Ctrl+Shift+Enter.
-- 3. View results in the Result Grid below the editor.
-- Screenshot to take: passengers_table.png
-- ==========================================
-- END OF SQL_Questions_Answers.sql
-- ==========================================
