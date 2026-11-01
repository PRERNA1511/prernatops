-- ============================================================
-- Session 9 – Transactions & Error Handling
-- File: canteen_transactions.sql
-- Folder: canteen_db
-- ============================================================

USE canteen_db;

DELIMITER $$

-- -------------------------------------------------------
-- Task 1: Demonstrate basic COMMIT and ROLLBACK
-- -------------------------------------------------------

-- Scenario A: Successful transaction (COMMIT)
START TRANSACTION;

    UPDATE menu_items SET quantity = quantity - 5 WHERE item_id = 1;
    INSERT INTO orders (item_id, quantity, total_price) VALUES (1, 5, 50.00);

COMMIT;

-- Scenario B: Failed transaction (ROLLBACK)
START TRANSACTION;

    UPDATE menu_items SET quantity = quantity - 100 WHERE item_id = 2;
    -- Simulated error condition check
    -- If stock goes negative, roll back
    INSERT INTO orders (item_id, quantity, total_price) VALUES (2, 100, 4000.00);

ROLLBACK;

-- -------------------------------------------------------
-- Task 2: SAVEPOINT demonstration
-- -------------------------------------------------------
START TRANSACTION;

    -- Step 1: Update item 3 quantity
    UPDATE menu_items SET quantity = quantity - 3 WHERE item_id = 3;
    SAVEPOINT sp_after_item3;

    -- Step 2: Update item 4 quantity
    UPDATE menu_items SET quantity = quantity - 4 WHERE item_id = 4;
    SAVEPOINT sp_after_item4;

    -- Step 3: Intentional rollback to sp_after_item3
    -- (undo item4 update only)
    ROLLBACK TO SAVEPOINT sp_after_item3;

    -- Step 4: Commit the remaining changes (only item3 update)
COMMIT;

-- -------------------------------------------------------
-- Task 3: Stored Procedure place_order
-- Places an order: checks stock, deducts quantity, inserts
-- an orders record, uses transaction + error handler
-- -------------------------------------------------------
DROP PROCEDURE IF EXISTS place_order$$

CREATE PROCEDURE place_order(
    IN  p_item_id   INT,
    IN  p_quantity  INT,
    OUT p_result    VARCHAR(200)
)
BEGIN
    DECLARE v_available INT DEFAULT 0;
    DECLARE v_price     DECIMAL(8,2) DEFAULT 0;
    DECLARE v_total     DECIMAL(10,2);

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SET p_result = 'ERROR: Transaction failed and rolled back.';
    END;

    START TRANSACTION;

    -- Check current stock and price
    SELECT quantity, price
    INTO   v_available, v_price
    FROM   menu_items
    WHERE  item_id = p_item_id
    FOR UPDATE;

    IF v_available IS NULL THEN
        ROLLBACK;
        SET p_result = 'ERROR: Item not found.';
    ELSEIF v_available < p_quantity THEN
        ROLLBACK;
        SET p_result = CONCAT('ERROR: Insufficient stock. Available: ', v_available);
    ELSE
        SET v_total = v_price * p_quantity;

        -- Deduct stock
        UPDATE menu_items
        SET    quantity = quantity - p_quantity
        WHERE  item_id  = p_item_id;

        -- Record the order
        INSERT INTO orders (item_id, quantity, total_price)
        VALUES (p_item_id, p_quantity, v_total);

        COMMIT;
        SET p_result = CONCAT('SUCCESS: Order placed. Total = Rs ', v_total);
    END IF;
END$$

-- -------------------------------------------------------
-- Task 4: Trigger trg_reduce_stock
-- Automatically reduces stock when an order is inserted
-- (Alternative mechanism to show trigger-based stock control)
-- -------------------------------------------------------
DROP TRIGGER IF EXISTS trg_reduce_stock$$

CREATE TRIGGER trg_reduce_stock
AFTER INSERT ON orders
FOR EACH ROW
BEGIN
    UPDATE menu_items
    SET    quantity = quantity - NEW.quantity
    WHERE  item_id  = NEW.item_id;
END$$

DELIMITER ;

-- -------------------------------------------------------
-- Test place_order procedure
-- -------------------------------------------------------
CALL place_order(1, 5, @result);
SELECT @result AS "Order Result";

CALL place_order(2, 1000, @result);
SELECT @result AS "Order Result";

-- Verify stock after orders
SELECT item_id, item_name, quantity FROM menu_items ORDER BY item_id;
