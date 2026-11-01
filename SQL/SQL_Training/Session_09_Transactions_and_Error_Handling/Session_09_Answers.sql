-- ==========================================
-- SESSION 09: TRANSACTIONS AND ERROR HANDLING
-- ==========================================
-- File   : Session_09_Answers.sql
-- Author : SQL Training
-- Date   : 2026-10-29
-- Description: Answers for Session 09 - Transactions and Error Handling
--              Covers START TRANSACTION, COMMIT, ROLLBACK, SAVEPOINT,
--              SIGNAL, DECLARE HANDLER, and error handling in procedures.
-- How to Run:
--   Open in MySQL Workbench.
--   Run section by section with Ctrl+Enter.
--   Read comments carefully before running ROLLBACK examples.
-- ==========================================


-- ==========================================
-- SETUP
-- ==========================================
CREATE DATABASE IF NOT EXISTS session09_transactions;
USE session09_transactions;

-- Bank accounts table for transaction examples:
CREATE TABLE IF NOT EXISTS bank_accounts (
    account_id    INT           PRIMARY KEY AUTO_INCREMENT,
    account_no    CHAR(10)      UNIQUE NOT NULL,
    holder_name   VARCHAR(100)  NOT NULL,
    balance       DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    account_type  VARCHAR(20)   DEFAULT 'Savings',
    created_at    TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT chk_balance CHECK (balance >= 0)  -- balance cannot go negative
);

-- Transaction log table:
CREATE TABLE IF NOT EXISTS transaction_log (
    log_id        INT           PRIMARY KEY AUTO_INCREMENT,
    from_account  CHAR(10),
    to_account    CHAR(10),
    amount        DECIMAL(12,2),
    txn_type      VARCHAR(20),  -- TRANSFER, DEPOSIT, WITHDRAWAL
    status        VARCHAR(10),  -- SUCCESS, FAILED, ROLLED_BACK
    txn_time      TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
    notes         VARCHAR(200)
);

-- Insert initial account data:
INSERT INTO bank_accounts (account_no, holder_name, balance, account_type) VALUES
('SB001',    'Ananya Sharma',  50000.00, 'Savings'),
('SB002',    'Rohan Patel',    25000.00, 'Savings'),
('SB003',    'Priya Nair',     75000.00, 'Savings'),
('CA001',    'ABC Traders',   200000.00, 'Current');

-- ==========================================
-- Task 1: What is a Transaction?
-- ==========================================
-- Question: Define a transaction. Explain the ACID properties with examples.

-- Solution (Explanation in comments):
-- A TRANSACTION is a sequence of one or more SQL operations that are
-- treated as a SINGLE UNIT OF WORK.
-- Either ALL operations succeed → COMMIT (saved permanently)
-- Or if any operation fails  → ROLLBACK (all operations undone)
--
-- CLASSIC EXAMPLE: Bank Transfer of Rs. 5000 from Account A to Account B
--   Step 1: Deduct Rs. 5000 from Account A  (UPDATE)
--   Step 2: Add    Rs. 5000 to  Account B   (UPDATE)
-- Both steps MUST succeed together. If Step 2 fails after Step 1,
-- we ROLLBACK so Account A's money is restored.

-- ACID PROPERTIES:
-- ┌─────────────────┬──────────────────────────────────────────────────────┐
-- │ A - Atomicity   │ ALL operations succeed OR ALL are rolled back.       │
-- │                 │ Example: Transfer either completes fully or not at all│
-- ├─────────────────┼──────────────────────────────────────────────────────┤
-- │ C - Consistency │ Database moves from one valid state to another.      │
-- │                 │ Example: Total money in bank stays the same after a  │
-- │                 │ transfer (money doesn't appear or disappear).        │
-- ├─────────────────┼──────────────────────────────────────────────────────┤
-- │ I - Isolation   │ Concurrent transactions don't interfere with each    │
-- │                 │ other. Each sees a consistent view of the data.      │
-- │                 │ Example: Two ATMs withdrawing simultaneously don't   │
-- │                 │ both see the same Rs. 5000 and both succeed.         │
-- ├─────────────────┼──────────────────────────────────────────────────────┤
-- │ D - Durability  │ Once committed, changes are permanent — even if the  │
-- │                 │ system crashes immediately after.                    │
-- │                 │ Example: After COMMIT, the balance is saved on disk. │
-- └─────────────────┴──────────────────────────────────────────────────────┘

-- Demonstration of current state:
SELECT * FROM bank_accounts;


-- ==========================================
-- Task 2: START TRANSACTION, COMMIT, ROLLBACK
-- ==========================================
-- Question: Demonstrate a successful bank transfer using a transaction
--           (START TRANSACTION + COMMIT).
--           Then demonstrate a failed transfer that is rolled back.

-- Solution:

-- ---- PART A: Successful Transfer (COMMIT) ----
-- Transfer Rs. 10,000 from SB001 (Ananya) to SB002 (Rohan)

START TRANSACTION;

-- Step 1: Deduct from sender
UPDATE bank_accounts
SET    balance = balance - 10000.00
WHERE  account_no = 'SB001';

-- Step 2: Add to receiver
UPDATE bank_accounts
SET    balance = balance + 10000.00
WHERE  account_no = 'SB002';

-- Step 3: Log the transaction
INSERT INTO transaction_log (from_account, to_account, amount, txn_type, status, notes)
VALUES ('SB001', 'SB002', 10000.00, 'TRANSFER', 'SUCCESS', 'Successful transfer');

-- All steps succeeded → COMMIT to make changes permanent:
COMMIT;

-- Verification:
SELECT account_no, holder_name, balance FROM bank_accounts;

-- Expected Output:
-- SB001 Ananya Sharma: 40000.00 (was 50000)
-- SB002 Rohan Patel  : 35000.00 (was 25000)

-- ---- PART B: Failed Transfer (ROLLBACK) ----
-- Attempt to transfer Rs. 50,000 from SB002 to SB001
-- SB002 only has Rs. 35,000 — this should fail and rollback.

START TRANSACTION;

-- Step 1: Deduct from sender (will violate CHECK constraint)
UPDATE bank_accounts
SET    balance = balance - 50000.00
WHERE  account_no = 'SB002';
-- This will fail because balance would go negative (-15000) violating CHECK

-- MySQL raises an error here. In Workbench, you would see the error.
-- We manually ROLLBACK:
ROLLBACK;

-- Verification — SB002 balance should be UNCHANGED at 35000:
SELECT account_no, holder_name, balance FROM bank_accounts WHERE account_no = 'SB002';

-- Explanation:
-- START TRANSACTION → begins a new transaction.
-- COMMIT            → makes all changes since START TRANSACTION permanent.
-- ROLLBACK          → undoes ALL changes since START TRANSACTION.
-- AUTO-COMMIT: By default MySQL auto-commits each statement.
--              START TRANSACTION temporarily disables auto-commit.


-- ==========================================
-- Task 3: SAVEPOINT
-- ==========================================
-- Question: Explain SAVEPOINT. Demonstrate partial rollback using SAVEPOINT.
--           Scenario: Update three accounts. Rollback only the last update.

-- Solution:
-- SAVEPOINT creates a named checkpoint within a transaction.
-- You can ROLLBACK TO SAVEPOINT to undo only the changes after that point.

START TRANSACTION;

-- Update 1: Add Rs. 5000 to SB003 (Priya)
UPDATE bank_accounts SET balance = balance + 5000.00 WHERE account_no = 'SB003';
SELECT account_no, balance FROM bank_accounts WHERE account_no = 'SB003';

-- Create a savepoint after first update
SAVEPOINT after_priya_update;

-- Update 2: Deduct Rs. 2000 from SB001 (Ananya)
UPDATE bank_accounts SET balance = balance - 2000.00 WHERE account_no = 'SB001';
SELECT account_no, balance FROM bank_accounts WHERE account_no = 'SB001';

-- Create another savepoint
SAVEPOINT after_ananya_update;

-- Update 3: Deduct Rs. 100,000 from CA001 (ABC Traders) — this seems wrong
UPDATE bank_accounts SET balance = balance - 100000.00 WHERE account_no = 'CA001';
SELECT account_no, balance FROM bank_accounts WHERE account_no = 'CA001';

-- We realise Update 3 was a mistake — rollback to BEFORE update 3:
ROLLBACK TO SAVEPOINT after_ananya_update;

-- Check: CA001 should be back to 200000, but SB003 and SB001 changes remain:
SELECT account_no, holder_name, balance FROM bank_accounts;

-- Release the savepoint (optional cleanup):
RELEASE SAVEPOINT after_ananya_update;

-- Commit the valid changes (SB003 +5000, SB001 -2000):
COMMIT;

-- Final Verification:
SELECT account_no, holder_name, balance FROM bank_accounts;

-- Explanation:
-- SAVEPOINT name           → creates a named checkpoint.
-- ROLLBACK TO SAVEPOINT name → undoes changes after that checkpoint.
-- RELEASE SAVEPOINT name   → removes the savepoint (optional, freed at COMMIT).
-- Multiple savepoints can exist within one transaction.


-- ==========================================
-- Task 4: Error Handling with DECLARE HANDLER
-- ==========================================
-- Question: Create a stored procedure transfer_funds that:
--           - Accepts from_account, to_account, and amount
--           - Validates the sender has enough balance
--           - Performs the transfer inside a transaction
--           - Handles errors gracefully with ROLLBACK
--           - Returns a success or error message

-- Solution:
DELIMITER $$

CREATE PROCEDURE transfer_funds(
    IN  p_from_acc  CHAR(10),
    IN  p_to_acc    CHAR(10),
    IN  p_amount    DECIMAL(12,2),
    OUT p_message   VARCHAR(200)
)
BEGIN
    -- Declare variables
    DECLARE v_from_balance   DECIMAL(12,2);
    DECLARE v_error_occurred BOOLEAN DEFAULT FALSE;
    DECLARE v_error_msg      VARCHAR(200) DEFAULT '';

    -- Declare error handler: catches ANY SQL exception
    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
    BEGIN
        SET v_error_occurred = TRUE;
        SET v_error_msg = 'A database error occurred during the transfer.';
        ROLLBACK;
    END;

    -- Start transaction
    START TRANSACTION;

    -- Step 1: Check sender's balance
    SELECT balance INTO v_from_balance
    FROM   bank_accounts
    WHERE  account_no = p_from_acc
    FOR UPDATE;   -- Lock the row during the transaction

    -- Step 2: Validate balance
    IF v_from_balance IS NULL THEN
        SET v_error_occurred = TRUE;
        SET v_error_msg = CONCAT('ERROR: Account ', p_from_acc, ' not found.');
        ROLLBACK;
    ELSEIF v_from_balance < p_amount THEN
        SET v_error_occurred = TRUE;
        SET v_error_msg = CONCAT('ERROR: Insufficient balance. Available: ', v_from_balance);
        ROLLBACK;
    ELSEIF p_amount <= 0 THEN
        SET v_error_occurred = TRUE;
        SET v_error_msg = 'ERROR: Transfer amount must be greater than zero.';
        ROLLBACK;
    ELSE
        -- Step 3: Deduct from sender
        UPDATE bank_accounts
        SET    balance = balance - p_amount
        WHERE  account_no = p_from_acc;

        -- Step 4: Add to receiver
        UPDATE bank_accounts
        SET    balance = balance + p_amount
        WHERE  account_no = p_to_acc;

        -- Step 5: Log the transaction
        INSERT INTO transaction_log (from_account, to_account, amount, txn_type, status, notes)
        VALUES (p_from_acc, p_to_acc, p_amount, 'TRANSFER', 'SUCCESS',
                CONCAT('Transfer of ', p_amount, ' completed.'));

        COMMIT;
        SET p_message = CONCAT('SUCCESS: Rs. ', p_amount, ' transferred from ',
                               p_from_acc, ' to ', p_to_acc);
    END IF;

    -- Return error message if error occurred:
    IF v_error_occurred THEN
        -- Log the failed attempt
        INSERT INTO transaction_log (from_account, to_account, amount, txn_type, status, notes)
        VALUES (p_from_acc, p_to_acc, p_amount, 'TRANSFER', 'FAILED', v_error_msg);

        SET p_message = v_error_msg;
    END IF;

END $$

DELIMITER ;

-- Test Case 1: Valid transfer (SB003 → SB001, Rs. 5000)
CALL transfer_funds('SB003', 'SB001', 5000.00, @msg);
SELECT @msg AS result;
SELECT account_no, holder_name, balance FROM bank_accounts;

-- Test Case 2: Insufficient funds (SB002 → SB001, Rs. 100000)
CALL transfer_funds('SB002', 'SB001', 100000.00, @msg);
SELECT @msg AS result;
SELECT account_no, holder_name, balance FROM bank_accounts;   -- No change expected

-- Test Case 3: Zero amount (invalid)
CALL transfer_funds('SB001', 'SB002', 0.00, @msg);
SELECT @msg AS result;

-- View transaction log:
SELECT * FROM transaction_log ORDER BY log_id DESC;

-- Explanation:
-- DECLARE CONTINUE HANDLER FOR SQLEXCEPTION → catches ANY SQL error.
-- CONTINUE HANDLER → after handling the error, execution continues from next line.
-- EXIT HANDLER → after handling the error, execution exits the BEGIN...END block.
-- FOR UPDATE → locks the selected row so another transaction cannot change it.


-- ==========================================
-- Task 5: SIGNAL - Raising Custom Errors
-- ==========================================
-- Question: Create a procedure validate_deposit that raises a custom
--           error if the deposit amount is negative or zero.

-- Solution:
DELIMITER $$

CREATE PROCEDURE validate_deposit(
    IN p_account_no CHAR(10),
    IN p_amount     DECIMAL(12,2)
)
BEGIN
    -- Raise a custom error if amount is invalid:
    IF p_amount <= 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'ERROR: Deposit amount must be greater than zero.';
    END IF;

    IF p_amount > 1000000 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'ERROR: Deposit amount exceeds the maximum limit of Rs. 10,00,000.';
    END IF;

    -- If validation passes, perform the deposit:
    START TRANSACTION;

    UPDATE bank_accounts
    SET    balance = balance + p_amount
    WHERE  account_no = p_account_no;

    INSERT INTO transaction_log (to_account, amount, txn_type, status)
    VALUES (p_account_no, p_amount, 'DEPOSIT', 'SUCCESS');

    COMMIT;

    SELECT CONCAT('SUCCESS: Rs. ', p_amount, ' deposited into ', p_account_no) AS result;
END $$

DELIMITER ;

-- Test Case 1: Valid deposit
CALL validate_deposit('SB001', 5000.00);
SELECT account_no, balance FROM bank_accounts WHERE account_no = 'SB001';

-- Test Case 2: Invalid deposit (negative amount) — will show custom error
-- CALL validate_deposit('SB001', -500.00);

-- Test Case 3: Exceeds limit — will show custom error
-- CALL validate_deposit('SB001', 2000000.00);

-- Explanation:
-- SIGNAL SQLSTATE '45000' → raises a user-defined error.
-- SQLSTATE '45000' is the standard code for user-defined errors.
-- SET MESSAGE_TEXT → specifies the error message shown to the user.
-- MySQL will display this as an ERROR that can be caught by handlers.


-- ==========================================
-- Task 6: AUTO-COMMIT and IMPLICIT TRANSACTIONS
-- ==========================================
-- Question: What is AUTO-COMMIT in MySQL? How do you control it?
--           What is an implicit transaction?

-- Solution (Explanation in comments):
-- AUTO-COMMIT:
--   By default, every SQL statement in MySQL is AUTO-COMMITTED.
--   This means each statement is immediately and permanently saved.
--   There is no way to ROLLBACK a single auto-committed statement.

-- Check current auto-commit setting:
SELECT @@autocommit AS auto_commit_status;
-- 1 = ON (default), 0 = OFF

-- Turn OFF auto-commit for the session:
SET autocommit = 0;

-- Now DML statements are NOT committed until you explicitly COMMIT:
UPDATE bank_accounts SET balance = balance + 1000 WHERE account_no = 'SB002';
-- Balance appears changed in this session but is NOT saved to disk yet.

ROLLBACK;   -- Undo the change

SELECT account_no, balance FROM bank_accounts WHERE account_no = 'SB002';
-- Balance should be unchanged

-- Turn auto-commit back ON:
SET autocommit = 1;

-- IMPLICIT TRANSACTION:
-- START TRANSACTION implicitly disables auto-commit for the duration.
-- The next COMMIT or ROLLBACK ends the transaction and auto-commit resumes.


-- ==========================================
-- Task 7: Triggers as Transaction-Aware Code
-- ==========================================
-- Question: Create a BEFORE INSERT trigger on bank_accounts that
--           prevents inserting accounts with a negative initial balance.
--           Create an AFTER UPDATE trigger that logs balance changes.

-- Solution:
DELIMITER $$

-- BEFORE INSERT: Validate initial balance
CREATE TRIGGER trg_before_account_insert
BEFORE INSERT ON bank_accounts
FOR EACH ROW
BEGIN
    IF NEW.balance < 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Initial balance cannot be negative.';
    END IF;
END $$

-- AFTER UPDATE: Log balance changes
CREATE TRIGGER trg_after_balance_update
AFTER UPDATE ON bank_accounts
FOR EACH ROW
BEGIN
    IF OLD.balance <> NEW.balance THEN
        INSERT INTO transaction_log (from_account, to_account, amount, txn_type, status, notes)
        VALUES (
            OLD.account_no,
            NEW.account_no,
            ABS(NEW.balance - OLD.balance),
            CASE WHEN NEW.balance > OLD.balance THEN 'CREDIT' ELSE 'DEBIT' END,
            'SUCCESS',
            CONCAT('Balance changed from ', OLD.balance, ' to ', NEW.balance)
        );
    END IF;
END $$

DELIMITER ;

-- Test the BEFORE INSERT trigger (should fail):
-- INSERT INTO bank_accounts (account_no, holder_name, balance) VALUES ('SB999', 'Test', -100);

-- Test the AFTER UPDATE trigger (should log automatically):
UPDATE bank_accounts SET balance = balance + 500 WHERE account_no = 'SB001';

-- View the auto-generated log:
SELECT * FROM transaction_log ORDER BY log_id DESC LIMIT 5;

-- Explanation:
-- BEFORE INSERT → fires BEFORE the row is inserted; can prevent bad data.
-- AFTER UPDATE  → fires AFTER the update; useful for audit logging.
-- NEW           → refers to the new values being inserted/updated.
-- OLD           → refers to the old values before the update.
-- FOR EACH ROW  → trigger fires once per affected row.


-- ==========================================
-- Task 8: Viewing and Dropping Triggers
-- ==========================================
-- Question: How do you view existing triggers? How do you drop them?

-- Solution:
-- View all triggers in the current database:
SHOW TRIGGERS;

-- View triggers on a specific table:
SHOW TRIGGERS LIKE 'bank_accounts';

-- Drop a trigger:
-- DROP TRIGGER IF EXISTS trg_before_account_insert;
-- DROP TRIGGER IF EXISTS trg_after_balance_update;

-- List triggers from information_schema:
SELECT TRIGGER_NAME, EVENT_MANIPULATION, EVENT_OBJECT_TABLE, ACTION_TIMING
FROM   information_schema.TRIGGERS
WHERE  TRIGGER_SCHEMA = 'session09_transactions';


-- ==========================================
-- Task 9: Full Practical Summary
-- ==========================================
-- Question: Write a final comprehensive query showing all accounts
--           and their transaction history.

-- Solution:
SELECT ba.account_no,
       ba.holder_name,
       ba.balance          AS current_balance,
       COUNT(tl.log_id)    AS total_transactions,
       IFNULL(SUM(CASE WHEN tl.txn_type IN ('CREDIT','DEPOSIT') THEN tl.amount ELSE 0 END),0) AS total_credited,
       IFNULL(SUM(CASE WHEN tl.txn_type IN ('DEBIT','WITHDRAWAL') THEN tl.amount ELSE 0 END),0) AS total_debited
FROM   bank_accounts ba
LEFT JOIN transaction_log tl ON ba.account_no = tl.from_account
                              OR ba.account_no = tl.to_account
GROUP BY ba.account_no, ba.holder_name, ba.balance
ORDER BY ba.account_no;


-- ==========================================
-- END OF SESSION 09 ANSWERS
-- ==========================================
-- Topics Covered:
--   Transactions (START TRANSACTION, COMMIT, ROLLBACK)
--   ACID Properties (Atomicity, Consistency, Isolation, Durability)
--   SAVEPOINT (create, rollback to, release)
--   Error Handling (DECLARE HANDLER FOR SQLEXCEPTION)
--   SIGNAL (raising custom errors with SQLSTATE '45000')
--   AUTO-COMMIT (SET autocommit = 0/1)
--   Triggers (BEFORE INSERT, AFTER UPDATE)
--   FOR EACH ROW, NEW, OLD keywords
-- ==========================================
