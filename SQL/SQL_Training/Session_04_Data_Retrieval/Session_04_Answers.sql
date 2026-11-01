-- ==========================================
-- SESSION 04: DATA RETRIEVAL
-- ==========================================
-- File   : Session_04_Answers.sql
-- Author : SQL Training
-- Date   : 2026-10-29
-- Description: Answers for Session 04 - Data Retrieval
--              Covers SELECT, WHERE, ORDER BY, LIMIT, DISTINCT, LIKE,
--              Aggregate Functions, GROUP BY, HAVING, and Subqueries.
-- How to Run:
--   Open in MySQL Workbench → File → Open SQL Script.
--   Run Ctrl+Enter for individual statements.
-- ==========================================


-- ==========================================
-- SETUP
-- ==========================================
CREATE DATABASE IF NOT EXISTS session04_retrieval;
USE session04_retrieval;

-- Create and populate a products table for all examples:
CREATE TABLE IF NOT EXISTS products (
    product_id      INT             PRIMARY KEY AUTO_INCREMENT,
    product_name    VARCHAR(150)    NOT NULL,
    category        VARCHAR(50),
    price           DECIMAL(10,2)   NOT NULL,
    stock_qty       INT             DEFAULT 0,
    supplier        VARCHAR(100),
    entry_date      DATE
);

INSERT INTO products (product_name, category, price, stock_qty, supplier, entry_date) VALUES
('Geometry Box',        'Stationery',    75.00,   200, 'ABC Traders',   '2025-01-10'),
('Notebook (200 pages)','Stationery',    45.00,   500, 'PQR Supplies',  '2025-01-10'),
('Scientific Calculator','Electronics', 350.00,   80,  'TechMart',      '2025-01-15'),
('Fountain Pen',        'Stationery',    120.00,  150, 'ABC Traders',   '2025-01-12'),
('Pencil Box',          'Stationery',    90.00,   300, 'PQR Supplies',  '2025-01-10'),
('Eraser Pack',         'Stationery',    25.00,   600, 'ABC Traders',   '2025-02-01'),
('USB Drive 16GB',      'Electronics',  450.00,   60,  'TechMart',      '2025-02-05'),
('Drawing Board',       'Art Supplies', 250.00,   40,  'ArtWorld',      '2025-02-10'),
('Watercolor Set',      'Art Supplies', 180.00,   90,  'ArtWorld',      '2025-02-10'),
('Compass Set',         'Stationery',   130.00,  110,  'ABC Traders',   '2025-03-01'),
('Headphones',          'Electronics',  800.00,   25,  'TechMart',      '2025-03-05'),
('Oil Pastels',         'Art Supplies', 220.00,   75,  'ArtWorld',      '2025-03-08'),
('Ballpoint Pens (10)', 'Stationery',    60.00,  400,  'PQR Supplies',  '2025-03-10'),
('Sketch Pens (12)',    'Art Supplies', 150.00,  120,  'ArtWorld',      '2025-03-12'),
('Ruler 30cm',          'Stationery',    20.00,  350,  'PQR Supplies',  '2025-03-15');


-- ==========================================
-- Task 1: Basic SELECT Statement
-- ==========================================
-- Question: Write SELECT queries to retrieve:
--           (a) All columns from products
--           (b) Only product_name and price
--           (c) Products with an alias for the column header

-- Solution:

-- (a) Retrieve all columns:
SELECT * FROM products;

-- (b) Retrieve specific columns only:
SELECT product_name, price
FROM   products;

-- (c) Using aliases to rename column headers in output:
SELECT product_name  AS "Product Name",
       price         AS "Price (Rs.)",
       stock_qty     AS "Available Stock"
FROM   products;

-- Explanation:
-- SELECT *           → Returns ALL columns (avoid in production, use specific columns).
-- SELECT col1, col2  → Returns only specified columns (more efficient).
-- AS alias           → Renames the column in the result (doesn't change the table).


-- ==========================================
-- Task 2: WHERE Clause - Filtering Rows
-- ==========================================
-- Question: Write queries using WHERE to filter products by:
--           (a) Exact match     (b) Greater than
--           (c) Range (BETWEEN) (d) Multiple values (IN)
--           (e) Combining conditions (AND, OR, NOT)

-- Solution:

-- (a) Exact match:
SELECT product_name, category, price
FROM   products
WHERE  category = 'Electronics';

-- (b) Greater than:
SELECT product_name, price
FROM   products
WHERE  price > 200.00;

-- (c) Range with BETWEEN (inclusive of both ends):
SELECT product_name, price
FROM   products
WHERE  price BETWEEN 100.00 AND 300.00;

-- (d) IN clause - match any value in a list:
SELECT product_name, supplier
FROM   products
WHERE  supplier IN ('TechMart', 'ArtWorld');

-- (e) AND (both conditions must be true):
SELECT product_name, category, price
FROM   products
WHERE  category = 'Stationery'
  AND  price    > 50.00;

-- OR (at least one condition must be true):
SELECT product_name, category, price
FROM   products
WHERE  category = 'Electronics'
   OR  price    > 400.00;

-- NOT (exclude a condition):
SELECT product_name, category
FROM   products
WHERE  category NOT IN ('Electronics', 'Art Supplies');

-- Explanation:
-- WHERE filters rows BEFORE results are returned.
-- AND  → both conditions true.
-- OR   → at least one condition true.
-- NOT  → reverses the condition.
-- BETWEEN 100 AND 300 → same as >= 100 AND <= 300.


-- ==========================================
-- Task 3: LIKE - Pattern Matching
-- ==========================================
-- Question: Find products whose names:
--           (a) Start with 'S'
--           (b) End with 'Set'
--           (c) Contain the word 'Pen'
--           (d) Have exactly 5 characters

-- Solution:

-- (a) Starts with 'S':
SELECT product_name FROM products WHERE product_name LIKE 'S%';

-- (b) Ends with 'Set':
SELECT product_name FROM products WHERE product_name LIKE '%Set';

-- (c) Contains 'Pen' anywhere:
SELECT product_name FROM products WHERE product_name LIKE '%Pen%';

-- (d) Exactly 5 characters (one _ per character):
SELECT product_name FROM products WHERE product_name LIKE '_____';

-- Explanation:
-- % (percent) → matches ZERO or more characters.
-- _ (underscore) → matches EXACTLY ONE character.
-- LIKE is case-insensitive in MySQL by default.


-- ==========================================
-- Task 4: ORDER BY - Sorting Results
-- ==========================================
-- Question: Retrieve products sorted by:
--           (a) Price ascending  (b) Price descending
--           (c) Multiple columns

-- Solution:

-- (a) Ascending order (lowest price first) – ASC is default:
SELECT product_name, price
FROM   products
ORDER BY price ASC;

-- (b) Descending order (highest price first):
SELECT product_name, price
FROM   products
ORDER BY price DESC;

-- (c) Sort by category then by price within each category:
SELECT product_name, category, price
FROM   products
ORDER BY category ASC, price DESC;

-- Explanation:
-- ORDER BY goes AFTER WHERE.
-- ASC  = Ascending  (A→Z, smallest→largest). Default.
-- DESC = Descending (Z→A, largest→smallest).
-- Multiple columns: first sort by col1, then by col2 within same col1 values.


-- ==========================================
-- Task 5: LIMIT and OFFSET
-- ==========================================
-- Question: Write queries to:
--           (a) Retrieve only the top 5 most expensive products.
--           (b) Retrieve products ranked 6th to 10th by price.

-- Solution:

-- (a) Top 5 most expensive:
SELECT product_name, price
FROM   products
ORDER BY price DESC
LIMIT  5;

-- (b) Products ranked 6–10 (skip first 5, then take next 5):
SELECT product_name, price
FROM   products
ORDER BY price DESC
LIMIT  5 OFFSET 5;

-- Explanation:
-- LIMIT n        → Returns only the first n rows.
-- LIMIT n OFFSET m → Skips m rows, then returns n rows.
-- Always use ORDER BY with LIMIT to get meaningful results.
-- OFFSET is commonly used for PAGINATION in web applications.


-- ==========================================
-- Task 6: DISTINCT - Remove Duplicates
-- ==========================================
-- Question: Find all unique categories and all unique suppliers.

-- Solution:
SELECT DISTINCT category
FROM   products
ORDER BY category;

SELECT DISTINCT supplier
FROM   products
ORDER BY supplier;

-- Distinct combination of two columns:
SELECT DISTINCT category, supplier
FROM   products
ORDER BY category, supplier;

-- Explanation:
-- DISTINCT removes duplicate rows from the result.
-- Applied to multiple columns: removes duplicate COMBINATIONS.


-- ==========================================
-- Task 7: Aggregate Functions
-- ==========================================
-- Question: Write queries using:
--           COUNT, SUM, AVG, MAX, MIN

-- Solution:

-- COUNT: Total number of products
SELECT COUNT(*) AS total_products FROM products;

-- COUNT with condition: How many products cost more than Rs. 100?
SELECT COUNT(*) AS expensive_products
FROM   products
WHERE  price > 100.00;

-- SUM: Total value of all stock (price * quantity)
SELECT SUM(price * stock_qty) AS total_stock_value
FROM   products;

-- AVG: Average product price
SELECT ROUND(AVG(price), 2) AS average_price
FROM   products;

-- MAX and MIN:
SELECT MAX(price) AS most_expensive,
       MIN(price) AS cheapest
FROM   products;

-- All aggregates together:
SELECT COUNT(*)                 AS total_products,
       SUM(stock_qty)           AS total_items_in_stock,
       ROUND(AVG(price), 2)     AS avg_price,
       MAX(price)               AS highest_price,
       MIN(price)               AS lowest_price
FROM   products;

-- Explanation:
-- COUNT(*) counts ALL rows including NULLs.
-- COUNT(column) counts rows where that column is NOT NULL.
-- SUM, AVG, MAX, MIN work on numeric columns.
-- ROUND(value, decimals) rounds to the specified decimal places.


-- ==========================================
-- Task 8: GROUP BY and HAVING
-- ==========================================
-- Question: Write queries to:
--           (a) Count products per category.
--           (b) Find total stock value per supplier.
--           (c) Show only categories with more than 4 products (use HAVING).
--           (d) Find average price per category where avg > Rs. 100.

-- Solution:

-- (a) Count products per category:
SELECT   category,
         COUNT(*) AS number_of_products
FROM     products
GROUP BY category
ORDER BY number_of_products DESC;

-- (b) Total stock value per supplier:
SELECT   supplier,
         SUM(price * stock_qty) AS total_stock_value
FROM     products
GROUP BY supplier
ORDER BY total_stock_value DESC;

-- (c) Categories with more than 4 products (HAVING filters groups):
SELECT   category,
         COUNT(*) AS product_count
FROM     products
GROUP BY category
HAVING   product_count > 4;

-- (d) Average price > Rs. 100 per category:
SELECT   category,
         ROUND(AVG(price), 2) AS avg_price
FROM     products
GROUP BY category
HAVING   avg_price > 100
ORDER BY avg_price DESC;

-- Explanation:
-- GROUP BY groups rows with the same value into summary rows.
-- WHERE  → filters ROWS before grouping.
-- HAVING → filters GROUPS after grouping (use aggregate functions here).
-- Never use HAVING instead of WHERE for row-level filtering.

-- ORDER OF EXECUTION:
-- FROM → WHERE → GROUP BY → HAVING → SELECT → ORDER BY → LIMIT


-- ==========================================
-- Task 9: NULL Handling
-- ==========================================
-- Question: Demonstrate how to find, filter, and handle NULL values.

-- Solution:

-- Find products with no supplier (NULL supplier):
SELECT product_name, supplier
FROM   products
WHERE  supplier IS NULL;

-- Find products WITH a supplier:
SELECT product_name, supplier
FROM   products
WHERE  supplier IS NOT NULL;

-- IFNULL: Replace NULL with a default value:
SELECT product_name,
       IFNULL(supplier, 'No Supplier') AS supplier_name
FROM   products;

-- COALESCE: Returns first non-NULL value (works with multiple columns):
SELECT product_name,
       COALESCE(supplier, category, 'Unknown') AS source
FROM   products;

-- Explanation:
-- NULL means MISSING or UNKNOWN — it is NOT zero or empty string.
-- Use IS NULL / IS NOT NULL to check for NULL (not = NULL).
-- IFNULL(col, default) → returns default if col is NULL.
-- COALESCE(a, b, c)    → returns the first non-NULL argument.


-- ==========================================
-- Task 10: String Functions in SELECT
-- ==========================================
-- Question: Demonstrate useful string functions on the products table.

-- Solution:

SELECT product_name,
       UPPER(product_name)         AS name_upper,
       LOWER(category)             AS category_lower,
       LENGTH(product_name)        AS name_length,
       SUBSTRING(product_name,1,8) AS first_8_chars,
       CONCAT(product_name, ' [', category, ']') AS full_label,
       TRIM('  Pencil  ')          AS trimmed
FROM   products
LIMIT 5;

-- REPLACE example:
SELECT REPLACE(product_name, 'Set', 'Kit') AS new_name
FROM   products
WHERE  product_name LIKE '%Set';

-- Explanation:
-- UPPER(s)         → converts string to uppercase.
-- LOWER(s)         → converts string to lowercase.
-- LENGTH(s)        → returns number of characters.
-- SUBSTRING(s,p,n) → extracts n characters starting at position p.
-- CONCAT(a,b,...)  → joins multiple strings together.
-- TRIM(s)          → removes leading and trailing spaces.
-- REPLACE(s,a,b)   → replaces all occurrences of a with b.


-- ==========================================
-- Task 11: Date Functions
-- ==========================================
-- Question: Write queries using date functions on entry_date.

-- Solution:

SELECT product_name,
       entry_date,
       YEAR(entry_date)                    AS entry_year,
       MONTH(entry_date)                   AS entry_month,
       DAY(entry_date)                     AS entry_day,
       MONTHNAME(entry_date)               AS month_name,
       DAYNAME(entry_date)                 AS day_name,
       DATEDIFF(CURDATE(), entry_date)     AS days_since_entry
FROM   products
ORDER BY entry_date;

-- Products added in the last 90 days:
SELECT product_name, entry_date
FROM   products
WHERE  entry_date >= DATE_SUB(CURDATE(), INTERVAL 90 DAY);

-- Explanation:
-- CURDATE()            → Returns today's date.
-- NOW()                → Returns current date AND time.
-- YEAR(d), MONTH(d), DAY(d) → Extract parts from a date.
-- DATEDIFF(d1, d2)     → Number of days between two dates.
-- DATE_SUB(d, INTERVAL n unit) → Subtracts n units from date d.
-- Units: DAY, MONTH, YEAR, HOUR, MINUTE, SECOND


-- ==========================================
-- Task 12: Subqueries (Nested SELECT)
-- ==========================================
-- Question: Write queries using subqueries to:
--           (a) Find products more expensive than the average price.
--           (b) Find the most expensive product in each category.
--           (c) Find products supplied by the supplier with the most products.

-- Solution:

-- (a) Products more expensive than average price:
SELECT product_name, price
FROM   products
WHERE  price > (SELECT AVG(price) FROM products)
ORDER BY price DESC;

-- (b) Most expensive product per category:
SELECT p.product_name, p.category, p.price
FROM   products p
WHERE  p.price = (
    SELECT MAX(p2.price)
    FROM   products p2
    WHERE  p2.category = p.category
)
ORDER BY p.category;

-- (c) Products from the supplier with the most products:
SELECT product_name, supplier
FROM   products
WHERE  supplier = (
    SELECT   supplier
    FROM     products
    GROUP BY supplier
    ORDER BY COUNT(*) DESC
    LIMIT 1
);

-- Explanation:
-- A subquery is a SELECT inside another SELECT (in parentheses).
-- The inner query runs FIRST and its result is used by the outer query.
-- Subqueries can appear in WHERE, FROM, HAVING, or SELECT clauses.


-- ==========================================
-- END OF SESSION 04 ANSWERS
-- ==========================================
-- Topics Covered:
--   SELECT (basic, aliases)
--   WHERE (comparison, BETWEEN, IN, AND/OR/NOT)
--   LIKE (pattern matching with %, _)
--   ORDER BY (ASC, DESC, multi-column)
--   LIMIT and OFFSET (pagination)
--   DISTINCT
--   Aggregate Functions (COUNT, SUM, AVG, MAX, MIN)
--   GROUP BY and HAVING
--   NULL handling (IS NULL, IFNULL, COALESCE)
--   String Functions (UPPER, LOWER, LENGTH, CONCAT, SUBSTRING)
--   Date Functions (YEAR, MONTH, DATEDIFF, DATE_SUB)
--   Subqueries
-- Next Session: Session_05_Joins_and_Relationships
-- ==========================================
