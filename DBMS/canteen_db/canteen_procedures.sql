-- ============================================================
-- Session 8 – Introduction to PL/SQL
-- File: canteen_procedures.sql
-- Folder: canteen_db
-- ============================================================

USE canteen_db;

DELIMITER $$

-- -------------------------------------------------------
-- Task 2: Procedure show_item_status
-- Displays each menu item's name, current stock, and
-- a status label: 'In Stock', 'Low Stock', or 'Out of Stock'
-- -------------------------------------------------------
DROP PROCEDURE IF EXISTS show_item_status$$

CREATE PROCEDURE show_item_status()
BEGIN
    DECLARE done        INT DEFAULT 0;
    DECLARE v_item_id   INT;
    DECLARE v_name      VARCHAR(100);
    DECLARE v_quantity  INT;
    DECLARE v_status    VARCHAR(20);

    -- Cursor to iterate over all menu items
    DECLARE item_cursor CURSOR FOR
        SELECT item_id, item_name, quantity
        FROM   menu_items
        ORDER BY item_id;

    -- Handler: set done = 1 when no more rows
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    -- Temporary result table for this session
    CREATE TEMPORARY TABLE IF NOT EXISTS tmp_item_status (
        item_id    INT,
        item_name  VARCHAR(100),
        quantity   INT,
        status     VARCHAR(20)
    );

    TRUNCATE TABLE tmp_item_status;

    OPEN item_cursor;

    read_loop: LOOP
        FETCH item_cursor INTO v_item_id, v_name, v_quantity;

        IF done = 1 THEN
            LEAVE read_loop;
        END IF;

        -- Determine status based on quantity
        IF v_quantity = 0 THEN
            SET v_status = 'Out of Stock';
        ELSEIF v_quantity <= 10 THEN
            SET v_status = 'Low Stock';
        ELSE
            SET v_status = 'In Stock';
        END IF;

        INSERT INTO tmp_item_status VALUES (v_item_id, v_name, v_quantity, v_status);
    END LOOP;

    CLOSE item_cursor;

    SELECT item_id, item_name, quantity, status
    FROM   tmp_item_status
    ORDER BY item_id;

    DROP TEMPORARY TABLE IF EXISTS tmp_item_status;
END$$

-- -------------------------------------------------------
-- Task 3: Procedure restock_all
-- Restores all items with quantity < 10 to a given
-- restock level (default 50)
-- -------------------------------------------------------
DROP PROCEDURE IF EXISTS restock_all$$

CREATE PROCEDURE restock_all(IN restock_level INT)
BEGIN
    DECLARE v_done       INT DEFAULT 0;
    DECLARE v_item_id    INT;
    DECLARE v_name       VARCHAR(100);
    DECLARE v_quantity   INT;
    DECLARE v_restocked  INT DEFAULT 0;

    DECLARE low_cursor CURSOR FOR
        SELECT item_id, item_name, quantity
        FROM   menu_items
        WHERE  quantity < 10
        ORDER BY item_id;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_done = 1;

    -- Default restock level if zero or negative passed
    IF restock_level <= 0 THEN
        SET restock_level = 50;
    END IF;

    OPEN low_cursor;

    restock_loop: LOOP
        FETCH low_cursor INTO v_item_id, v_name, v_quantity;

        IF v_done = 1 THEN
            LEAVE restock_loop;
        END IF;

        UPDATE menu_items
        SET    quantity = restock_level
        WHERE  item_id  = v_item_id;

        SET v_restocked = v_restocked + 1;
    END LOOP;

    CLOSE low_cursor;

    SELECT CONCAT('Restock complete. ', v_restocked, ' item(s) restocked to ', restock_level, '.') AS result;
END$$

-- -------------------------------------------------------
-- Task 4: Procedure inventory_value
-- Calculates total inventory value = SUM(price * quantity)
-- for each category and overall
-- -------------------------------------------------------
DROP PROCEDURE IF EXISTS inventory_value$$

CREATE PROCEDURE inventory_value()
BEGIN
    -- Category-wise inventory value
    SELECT
        category                          AS "Category",
        SUM(price * quantity)             AS "Inventory Value (Rs)",
        COUNT(item_id)                    AS "Item Count",
        SUM(quantity)                     AS "Total Units"
    FROM   menu_items
    GROUP BY category
    ORDER BY SUM(price * quantity) DESC;

    -- Overall total
    SELECT
        'TOTAL'                           AS "Category",
        SUM(price * quantity)             AS "Total Inventory Value (Rs)",
        COUNT(item_id)                    AS "Total Items",
        SUM(quantity)                     AS "Total Units"
    FROM   menu_items;
END$$

DELIMITER ;

-- -------------------------------------------------------
-- Test the procedures
-- -------------------------------------------------------

-- Show item statuses
CALL show_item_status();

-- Restock items with quantity < 10 to 50
CALL restock_all(50);

-- Show inventory value
CALL inventory_value();
