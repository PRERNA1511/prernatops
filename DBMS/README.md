# sql-lab

Public GitHub repository for DBMS lab sessions.

## Repository Structure

```
sql-lab/
├── bus_pass/
│   ├── workbench_connected.png      # MySQL Workbench connected screenshot
│   ├── bus_pass_tables.drawio       # Draw.io ER diagram of bus pass tables
│   ├── db_comparison.txt            # MySQL vs PostgreSQL vs SQLite comparison
│   └── passengers_table.png         # SELECT * FROM passengers result screenshot
│
├── school_db/
│   ├── school_setup.sql             # Session 2 – DDL: CREATE, ALTER, TEMP TABLE
│   ├── school_data.sql              # Session 3 – DML: INSERT, UPDATE, DELETE
│   ├── school_queries.sql           # Session 4 – SELECT, aggregates, topper query
│   ├── school_joins.sql             # Session 5 – FK constraints, INNER/LEFT/RIGHT JOIN
│   ├── show_tables.png              # SHOW TABLES result screenshot
│   └── topper.png                   # Topper query result screenshot
│
└── canteen_db/
    ├── canteen_setup.sql            # Session 8 – Tables: menu_items, orders
    ├── canteen_procedures.sql       # Session 8 – Procedures: show_item_status,
    │                                #             restock_all, inventory_value
    ├── canteen_transactions.sql     # Session 9 – Transactions, SAVEPOINT, place_order,
    │                                #             trg_reduce_stock trigger
    └── ai_test_scenarios.sql        # Session 9 – 3 test scenarios with expected/actual results
```

## Sessions Covered

| Session | Topic | Files |
|---------|-------|-------|
| Session 1 | Introduction to Databases | `bus_pass/` folder |
| Session 2 | SQL Basics & Commands (DDL) | `school_db/school_setup.sql` |
| Session 3 | DML Operations | `school_db/school_data.sql` |
| Session 4 | Data Retrieval with SELECT | `school_db/school_queries.sql` |
| Session 5 | Joins and Relationships | `school_db/school_joins.sql` |
| Session 8 | Introduction to PL/SQL | `canteen_db/canteen_setup.sql`, `canteen_db/canteen_procedures.sql` |
| Session 9 | Transactions & Error Handling | `canteen_db/canteen_transactions.sql`, `canteen_db/ai_test_scenarios.sql` |

## Tools Used

- **Database**: MySQL Community Edition 8.x (free)
- **GUI**: MySQL Workbench
- **Diagrams**: Draw.io (app.diagrams.net)
- **Version Control**: Git + GitHub
