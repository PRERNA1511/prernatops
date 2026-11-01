# ATM Banking Management System 🏦

## Project Introduction

This is a **console-based ATM Banking Management System** built in **C++** using **Object-Oriented Programming (OOP)** concepts. The project simulates real-world ATM operations including PIN authentication, balance enquiry, money deposit, and withdrawal — all through a clean, menu-driven interface.

This project is developed as part of a C++ OOP assessment and is designed to be **beginner-friendly**, making it easy to understand, explain, and demonstrate during a viva or lab examination.

---

## Project Objectives

- Implement a working ATM system using C++ OOP principles.
- Practice the use of **classes**, **objects**, **constructors**, **access specifiers**, and **scope resolution operator**.
- Handle user input validation and edge cases (invalid PIN, insufficient balance, bad input).
- Build a professional console-based UI using formatted output.
- Practice clean code structure with separate header (`.h`) and implementation (`.cpp`) files.

---

## Features

| Feature | Description |
|---|---|
| 🔐 PIN Authentication | Single-attempt PIN check (PIN: `12345`). Wrong PIN terminates session. |
| 💰 Check Balance | Displays both initial balance (Rs. 60000) and current balance (Rs. 20000). |
| ➕ Deposit Money | Add funds with input validation (must be > Rs. 0). |
| ➖ Withdraw Money | Withdraw with balance check; shows error if insufficient. |
| 🏦 Bank Information | Displays full account and branch details. |
| ❓ Help Screen | Instructions for all ATM operations and contact info. |
| 📅 Live Date & Time | Displays the current system date and time dynamically. |
| ✅ Input Validation | Handles all invalid inputs (non-numeric, negative, zero). |

---

## OOP Concepts Used

| Concept | Where Used |
|---|---|
| **Classes** | `Bank` class and `ATM` class |
| **Objects** | `Bank bankAccount` (inside ATM), `ATM myATM` (in main) |
| **Constructor** | `Bank::Bank()` and `ATM::ATM()` initialize data at object creation |
| **Private Members** | Balance, PIN, flags — hidden inside classes |
| **Public Members** | `displayBankInfo()`, `depositMoney()`, etc. — accessible from outside |
| **Scope Resolution (`::`)** | All member functions defined in `.cpp` files using `ClassName::function()` |
| **Encapsulation** | Data is private; accessed only through public getter/setter functions |
| **Composition** | `ATM` class contains a `Bank` object as a member |
| **Loops** | `while(true)` for menu loops; `for` loops in formatted output |
| **Conditionals** | `if-else` for balance/PIN checks, `switch` for menu navigation |
| **Functions** | Separate functions for each ATM operation (modular design) |

---

## Folder Structure

```
OOPS/
└── ATM-Banking-System/
    ├── main.cpp                 ← Program entry point
    ├── ATM.h                    ← ATM class declaration
    ├── ATM.cpp                  ← ATM class implementation
    ├── Bank.h                   ← Bank class declaration
    ├── Bank.cpp                 ← Bank class implementation
    ├── README.md                ← This file
    ├── PROJECT_DOCUMENTATION.md ← Detailed class/function docs
    └── .gitignore               ← Files to ignore in Git
```

---

## Sample Login PIN

```
ATM PIN: 12345
```

> ⚠️ You have **only ONE attempt** to enter the PIN. Incorrect PIN terminates the session immediately.

---

## Installation & Compilation

### Prerequisites
- A C++ compiler: **g++ (MinGW/GCC)** or **MSVC**
- **VS Code** with the C/C++ extension (recommended)

### Compile via Terminal (g++)

```bash
# Navigate to the project folder
cd OOPS/ATM-Banking-System

# Compile all files together
g++ main.cpp Bank.cpp ATM.cpp -o ATM_System

# Run the program
./ATM_System       # Linux/Mac
ATM_System.exe     # Windows
```

### Compile in VS Code

1. Open VS Code and go to **File → Open Folder**.
2. Select the `ATM-Banking-System` folder.
3. Open the **Terminal** (`Ctrl + ~`).
4. Run the compile command above.
5. Press `F5` or run `ATM_System.exe` from the terminal.

> 💡 **Tip**: If using VS Code with Code Runner extension, right-click `main.cpp` → **Run Code** (after compiling all files together via terminal first).

---

## How to Execute

```
Step 1: Compile the project using the g++ command above.
Step 2: Run ATM_System.exe (Windows) or ./ATM_System (Linux/Mac).
Step 3: The welcome screen appears with date, time, and menu.
Step 4: Select [1] to Login, [2] for Help, or [3] to Exit.
Step 5: Enter PIN 12345 to authenticate.
Step 6: Use the main menu to Check Balance, Deposit, Withdraw, or view Bank Info.
Step 7: Select [5] to Exit gracefully.
```

---

## Sample Output

```
  ╔══════════════════════════════════════════════════╗
  ║                                                  ║
  ║         STATE BANK OF INDIA (SBI)                ║
  ║            ATM BANKING SYSTEM                    ║
  ║                                                  ║
  ╚══════════════════════════════════════════════════╝

  Date : 30/10/2026   Time : 12:40:26

  ════════════════════════════════════════════════════
               WELCOME TO SBI ATM
  ════════════════════════════════════════════════════

  Please select an option:

    [ 1 ]  Login to ATM
    [ 2 ]  Help
    [ 3 ]  Exit

  Enter your choice: 1

  Enter your ATM PIN: 12345

  ╔══════════════════════════════════════════════════╗
  ║          ✔  AUTHENTICATION SUCCESSFUL            ║
  ╚══════════════════════════════════════════════════╝

  Welcome, Prerna Sharma!
```

---

## Git Commands to Upload to GitHub

```bash
# Step 1: Initialize Git inside the project folder
cd OOPS/ATM-Banking-System
git init

# Step 2: Add all files
git add .

# Step 3: Initial commit on main
git commit -m "Initial project setup"

# Step 4: Create and switch to develop branch
git checkout -b develop

# Step 5: Make commits on develop
git add .
git commit -m "Implement ATM authentication"
git commit -m "Add deposit and withdrawal features"
git commit -m "Add bank information module"
git commit -m "Complete documentation"

# Step 6: Push develop to GitHub
git remote add origin https://github.com/YOUR_USERNAME/ATM-Banking-System.git
git push -u origin develop

# Step 7: Merge develop into main
git checkout main
git merge develop

# Step 8: Push main to GitHub
git push -u origin main
```

---

## Author

**Prerna Sharma**  
C++ OOP Assessment Project — ATM Banking Management System

---

*Built with ❤️ using C++ OOP Principles*
