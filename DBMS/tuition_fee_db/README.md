# tuition-fee-db

Public GitHub repository for Mini Project 3 – Tuition Fee Database.

## Project Overview

A MySQL database system to manage student tuition fee payments for a tuition centre. Tracks students, courses, and monthly payments with stored procedure reporting.

## Database: `tuition_fee_db`

### Tables

| Table | Description |
|-------|-------------|
| `students` | Student details (name, email, phone, city, enrolment date) |
| `courses` | Course catalogue (name, duration, monthly fee) |
| `payments` | Payment records with FK to students and courses |

### Relationships

```
students (student_id PK) ──< payments (student_id FK)
courses  (course_id  PK) ──< payments (course_id  FK)
```

## Files

```
tuition_fee_db/
├── tuition_fee_db.sql          # Full script: DDL + DML + JOINs + procedure
├── summary_month1.png          # CALL monthly_fee_summary('2026-09') screenshot
└── summary_month2.png          # CALL monthly_fee_summary('2026-10') screenshot
```

## Key Features

- **Primary Keys & Foreign Keys** with `ON DELETE RESTRICT ON UPDATE CASCADE`
- **CRUD Operations** on all three tables
- **JOIN Queries** (INNER JOIN, LEFT JOIN) for payment reports
- **Stored Procedure** `monthly_fee_summary(p_month)`:
  - Returns itemised payment list for the given month
  - Returns totals: count, sum, average

## Sample Data

- **8 Students** with real Indian city names (Mumbai, Pune, Delhi, Chennai, Bengaluru, Kolkata, Hyderabad, Ahmedabad)
- **5 Courses**: Mathematics, Science, English, Computer Fundamentals, Commerce
- **16 Payment records** across 2 months (2026-09 and 2026-10)

## How to Run

```sql
-- In MySQL Workbench:
-- File > Open SQL Script > tuition_fee_db.sql
-- Run All (Ctrl+Shift+Enter)

-- Then call the summary procedure:
CALL monthly_fee_summary('2026-09');
CALL monthly_fee_summary('2026-10');
```

## Tools Used

- **Database**: MySQL Community Edition 8.x
- **GUI**: MySQL Workbench
- **Version Control**: Git + GitHub
