-- ============================================================
-- Session 9 – Transactions & Error Handling
-- File: ai_test_scenarios.sql
-- Folder: canteen_db
-- Purpose: Three test scenarios with expected and actual
--          results for the place_order procedure and
--          trg_reduce_stock trigger.
-- ============================================================

USE canteen_db;

-- ============================================================
-- PRE-TEST: Reset data to a known state
-- ============================================================
UPDATE menu_items SET quantity = 50 WHERE item_id = 1;   -- Samosa qty = 50
UPDATE menu_items SET quantity = 30 WHERE item_id = 2;   -- Masala Dosa qty = 30
UPDATE menu_items SET quantity =  5 WHERE item_id = 3;   -- Cold Coffee qty = 5 (low stock)

-- ============================================================
-- SCENARIO 1: Valid order – sufficient stock
-- Expected Result:
--   - place_order returns 'SUCCESS: Order placed. Total = Rs 50.00'
--   - Samosa quantity decreases from 50 to 45
--   - New row inserted in orders table
-- ============================================================

-- Step 1: Call procedure
CALL place_order(1, 5, @result1);

-- Step 2: Capture actual result
SELECT
    'Scenario 1 – Valid Order'   AS "Test Scenario",
    'SUCCESS message returned'   AS "Expected Result",
    @result1                     AS "Actual Result",
    CASE
        WHEN @result1 LIKE 'SUCCESS%' THEN 'PASS'
        ELSE 'FAIL'
    END                          AS "Test Status";

-- Step 3: Verify stock deduction
SELECT
    item_id,
    item_name,
    quantity                     AS "Stock After Order",
    '45 expected'                AS "Expected Stock"
FROM menu_items
WHERE item_id = 1;


-- ============================================================
-- SCENARIO 2: Invalid order – insufficient stock
-- Expected Result:
--   - place_order returns 'ERROR: Insufficient stock. Available: 5'
--   - Cold Coffee quantity remains 5 (no deduction)
--   - No new row inserted in orders table
-- ============================================================

-- Record order count before
SELECT COUNT(*) INTO @orders_before FROM orders WHERE item_id = 3;

-- Call procedure with quantity > available stock
CALL place_order(3, 20, @result2);

-- Capture actual result
SELECT
    'Scenario 2 – Insufficient Stock'   AS "Test Scenario",
    'ERROR: Insufficient stock msg'     AS "Expected Result",
    @result2                            AS "Actual Result",
    CASE
        WHEN @result2 LIKE 'ERROR: Insufficient%' THEN 'PASS'
        ELSE 'FAIL'
    END                                 AS "Test Status";

-- Verify stock NOT changed
SELECT
    item_id,
    item_name,
    quantity                AS "Stock After Attempt",
    '5 expected (unchanged)' AS "Expected Stock"
FROM menu_items
WHERE item_id = 3;

-- Verify no new order inserted
SELECT COUNT(*) INTO @orders_after FROM orders WHERE item_id = 3;
SELECT
    @orders_before  AS "Orders Before",
    @orders_after   AS "Orders After",
    CASE
        WHEN @orders_before = @orders_after THEN 'PASS – No duplicate order'
        ELSE 'FAIL – Unexpected order inserted'
    END             AS "Orders Count Check";


-- ============================================================
-- SCENARIO 3: Non-existent item_id
-- Expected Result:
--   - place_order returns 'ERROR: Item not found.'
--   - No change to any stock
--   - No new row in orders
-- ============================================================

CALL place_order(999, 1, @result3);

SELECT
    'Scenario 3 – Invalid Item ID'   AS "Test Scenario",
    'ERROR: Item not found.'         AS "Expected Result",
    @result3                         AS "Actual Result",
    CASE
        WHEN @result3 LIKE 'ERROR: Item not found%' THEN 'PASS'
        ELSE 'FAIL'
    END                              AS "Test Status";


-- ============================================================
-- SCENARIO SUMMARY TABLE
-- ============================================================
SELECT
    1                                    AS "Scenario #",
    'Valid Order (Samosa x5)'            AS "Test Case",
    'SUCCESS + stock reduced by 5'       AS "Expected",
    CASE WHEN @result1 LIKE 'SUCCESS%' THEN 'PASS' ELSE 'FAIL' END AS "Status"
UNION ALL
SELECT
    2,
    'Insufficient Stock (Coffee x20)',
    'ERROR + stock unchanged',
    CASE WHEN @result2 LIKE 'ERROR: Insufficient%' THEN 'PASS' ELSE 'FAIL' END
UNION ALL
SELECT
    3,
    'Non-existent item_id 999',
    'ERROR: Item not found.',
    CASE WHEN @result3 LIKE 'ERROR: Item not found%' THEN 'PASS' ELSE 'FAIL' END;
