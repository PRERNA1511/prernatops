-- ============================================================
-- Session 8 – Introduction to PL/SQL
-- File: canteen_setup.sql
-- Folder: canteen_db
-- ============================================================

-- Task 1: Create the database and tables

CREATE DATABASE IF NOT EXISTS canteen_db;
USE canteen_db;

-- Menu items table
CREATE TABLE IF NOT EXISTS menu_items (
    item_id      INT          PRIMARY KEY AUTO_INCREMENT,
    item_name    VARCHAR(100) NOT NULL,
    price        DECIMAL(8,2) NOT NULL,
    quantity     INT          NOT NULL DEFAULT 0,
    category     VARCHAR(50)
);

-- Orders table
CREATE TABLE IF NOT EXISTS orders (
    order_id     INT          PRIMARY KEY AUTO_INCREMENT,
    item_id      INT          NOT NULL,
    quantity     INT          NOT NULL,
    order_date   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    total_price  DECIMAL(10,2),
    CONSTRAINT fk_order_item FOREIGN KEY (item_id)
        REFERENCES menu_items(item_id)
        ON DELETE RESTRICT ON UPDATE CASCADE
);

-- Task 1: Insert sample menu items
INSERT INTO menu_items (item_name, price, quantity, category) VALUES
('Samosa',         10.00,  50, 'Snacks'),
('Masala Dosa',    40.00,  30, 'Main Course'),
('Cold Coffee',    35.00,  40, 'Beverages'),
('Idli (2 pcs)',   25.00,  60, 'Main Course'),
('Veg Puff',       15.00,  45, 'Snacks'),
('Mango Lassi',    30.00,  35, 'Beverages'),
('Poha',           20.00,  50, 'Breakfast'),
('Bread Omelette', 30.00,  25, 'Breakfast');

-- Task 2: Insert sample orders
INSERT INTO orders (item_id, quantity, total_price) VALUES
(1, 5,  50.00),
(2, 2,  80.00),
(3, 3, 105.00),
(4, 4, 100.00),
(5, 6,  90.00);

-- Verify setup
SELECT * FROM menu_items;
SELECT * FROM orders;
