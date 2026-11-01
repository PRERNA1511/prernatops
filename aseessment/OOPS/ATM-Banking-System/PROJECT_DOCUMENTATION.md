# PROJECT DOCUMENTATION
## ATM Banking Management System — C++ OOP

---

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [File Structure Explained](#2-file-structure-explained)
3. [Bank Class — Full Documentation](#3-bank-class--full-documentation)
4. [ATM Class — Full Documentation](#4-atm-class--full-documentation)
5. [main.cpp — Entry Point](#5-maincpp--entry-point)
6. [OOP Concepts — Explained Simply](#6-oop-concepts--explained-simply)
7. [Program Flow Diagram](#7-program-flow-diagram)
8. [Input Validation Details](#8-input-validation-details)
9. [Balance Logic Explained](#9-balance-logic-explained)
10. [Viva/Interview Q&A](#10-vivainterview-qa)

---

## 1. Project Overview

This project is a **console-based ATM Banking System** written in **C++**. It simulates the basic operations of an ATM machine:

- Welcoming the user with live date/time
- Authenticating the user with a PIN (one attempt only)
- Allowing balance enquiry, deposit, withdrawal, and bank info display
- Handling all invalid/bad inputs gracefully

The project uses **two separate classes** (`Bank` and `ATM`) stored in separate `.h` and `.cpp` files, following proper C++ project structure.

---

## 2. File Structure Explained

| File | Role |
|---|---|
| `Bank.h` | Declares the `Bank` class (attributes + function prototypes) |
| `Bank.cpp` | Implements (defines) all `Bank` class functions |
| `ATM.h` | Declares the `ATM` class (attributes + function prototypes) |
| `ATM.cpp` | Implements (defines) all `ATM` class functions |
| `main.cpp` | Program entry point — creates ATM object, starts the app |
| `README.md` | User-facing guide (features, compile, run, git) |
| `PROJECT_DOCUMENTATION.md` | This file — technical documentation |
| `.gitignore` | Tells Git which files to ignore (compiled `.exe`, `.o` files) |

---

## 3. Bank Class — Full Documentation

### File: `Bank.h` and `Bank.cpp`

### Purpose
The `Bank` class stores and manages all **bank and account-related data**. It acts as the data layer of the application.

---

### Private Data Members

```cpp
string bankName;          // "State Bank of India (SBI)"
string accountHolderName; // "Prerna Sharma"
string accountNumber;     // "XXXX-XXXX-5678" (dummy)
string accountType;       // "Savings Account"
string branchName;        // "Connaught Place Branch, New Delhi"
string ifscCode;          // "SBIN0001234" (dummy)
double initialBalance;    // Rs. 60000.00
double presentBalance;    // Rs. 20000.00
```

> **Why private?** Private members cannot be accessed directly from outside the class. This enforces **data security and encapsulation** — a core OOP principle.

---

### Constructor: `Bank::Bank()`

```cpp
Bank::Bank()
{
    bankName          = "State Bank of India (SBI)";
    accountHolderName = "Prerna Sharma";
    accountNumber     = "XXXX-XXXX-5678";
    accountType       = "Savings Account";
    branchName        = "Connaught Place Branch, New Delhi";
    ifscCode          = "SBIN0001234";
    initialBalance    = 60000.00;
    presentBalance    = 20000.00;
}
```

**What it does:** Called automatically when a `Bank` object is created. Sets all default/dummy data. No manual initialization needed.

---

### Public Member Functions

#### `void displayBankInfo() const`
- **What it does:** Prints a formatted table with all bank and account details.
- **`const` keyword:** The function does NOT modify any data — it only reads and displays.
- **Called from:** `ATM::runATM()` → when user selects option [4].

---

#### `double getPresentBalance() const`
- **What it does:** Returns the current account balance.
- **Type:** Getter function (read-only access to private `presentBalance`).
- **Called from:** `ATM::checkBalance()`, `ATM::depositMoney()`, `ATM::withdrawMoney()`.

---

#### `void setPresentBalance(double newBalance)`
- **What it does:** Updates the `presentBalance` with a new value.
- **Type:** Setter function (controlled write access to private `presentBalance`).
- **Called from:** `ATM::depositMoney()` and `ATM::withdrawMoney()` after a transaction.

---

#### `double getInitialBalance() const`
- **What it does:** Returns the `initialBalance` (Rs. 60000 — fixed, never changes).
- **Called from:** `ATM::checkBalance()` and `Bank::displayBankInfo()`.

---

#### `string getBankName() const`
- **What it does:** Returns the bank name string.
- **Called from:** Can be used in ATM display functions.

---

#### `string getAccountHolderName() const`
- **What it does:** Returns the account holder's name.
- **Called from:** `ATM::checkBalance()`, `ATM::displayMainMenu()`, `ATM::authenticateUser()`.

---

## 4. ATM Class — Full Documentation

### File: `ATM.h` and `ATM.cpp`

### Purpose
The `ATM` class controls the **entire ATM application flow** — authentication, menu display, transactions, and the main loop.

---

### Private Data Members

```cpp
int  correctPIN;      // 12345 — the valid ATM PIN
bool isAuthenticated; // false initially; true after correct PIN
Bank bankAccount;     // A Bank object (composition)
```

> `Bank bankAccount` inside ATM is called **composition** — "ATM has-a Bank account".

---

### Private Helper Functions

#### `void printSeparator() const`
- Prints a single decorative line for UI formatting.

#### `void printDoubleSeparator() const`
- Prints a double decorative line for headers.

#### `void clearInput()`
- Clears the `cin` input stream when the user types a non-numeric value.
- Uses `cin.clear()` + `cin.ignore()` to recover from bad input.
- Prevents infinite loops when `cin.fail()` is triggered.

---

### Constructor: `ATM::ATM()`

```cpp
ATM::ATM()
{
    correctPIN      = 12345;
    isAuthenticated = false;
    // bankAccount is auto-initialized by Bank's constructor
}
```

**What it does:** Initializes the ATM with the correct PIN and marks the user as NOT authenticated. When `bankAccount` (a `Bank` object) is created as a member, `Bank::Bank()` runs automatically.

---

### Public Member Functions

#### `void displayDateTime() const`
- **What it does:** Gets the current system time using `time(0)` from `<ctime>` and formats it as `DD/MM/YYYY HH:MM:SS`.
- **Key C++ concepts:** `time_t`, `tm*`, `localtime()`, `setw()`, `setfill()`.

---

#### `void displayWelcomeScreen() const`
- **What it does:** Prints the ATM welcome banner with bank name, live date/time, and 3 menu options (Login, Help, Exit).
- **Called from:** `ATM::runATM()` — at the start of every welcome loop iteration.

---

#### `bool authenticateUser()`
- **What it does:**
  1. Prompts user to enter PIN.
  2. Checks for non-numeric input (`cin.fail()`).
  3. Compares entered PIN to `correctPIN`.
  4. Sets `isAuthenticated = true` if correct.
  5. Returns `true` (access granted) or `false` (access denied).
- **ONE ATTEMPT ONLY:** There is no loop inside this function. One wrong entry and it returns `false`.

---

#### `void displayHelp() const`
- **What it does:** Displays a formatted help screen with instructions for all ATM operations and customer support contact info.

---

#### `void displayMainMenu() const`
- **What it does:** Displays the main ATM menu (5 options) after successful authentication.

---

#### `void checkBalance() const`
- **What it does:**
  - Calls `bankAccount.getPresentBalance()` to get current balance.
  - Calls `bankAccount.getInitialBalance()` to get initial balance.
  - Displays both values in a formatted table.
  - `const` function — does not modify any data.

---

#### `void depositMoney()`
- **What it does:**
  1. Shows current balance.
  2. Asks user to enter deposit amount.
  3. Validates: checks `cin.fail()` and `amount <= 0`.
  4. If valid: `newBalance = oldBalance + depositAmount`.
  5. Calls `bankAccount.setPresentBalance(newBalance)` to save.
  6. Displays receipt with old, deposited, and new balances.

---

#### `void withdrawMoney()`
- **What it does:**
  1. Shows available balance.
  2. Asks user to enter withdrawal amount.
  3. Validates: checks `cin.fail()` and `amount <= 0`.
  4. Checks: `if (withdrawAmount > presentBalance)` → insufficient.
  5. If sufficient: `newBalance = oldBalance - withdrawAmount`.
  6. Calls `bankAccount.setPresentBalance(newBalance)` to save.
  7. Displays receipt with old, withdrawn, and new balances.

---

#### `void runATM()`
- **What it does:** The **main controller** — runs the entire ATM application.
- **Flow:**
  ```
  while(true) {
      displayWelcomeScreen()
      Get choice (1/2/3)
      switch(choice):
          case 1: authenticateUser()
              if success:
                  while(true) {
                      displayMainMenu()
                      switch(choice 1-5):
                          1 → checkBalance()
                          2 → depositMoney()
                          3 → withdrawMoney()
                          4 → bankAccount.displayBankInfo()
                          5 → return (exit)
                  }
              else:
                  return (terminate)
          case 2: displayHelp()
          case 3: return (exit welcome)
  }
  ```

---

## 5. main.cpp — Entry Point

```cpp
int main()
{
    ATM myATM;      // Creates ATM object → runs ATM() and Bank() constructors
    myATM.runATM(); // Starts the full ATM application
    return 0;
}
```

**That's all that main needs!** Everything else is handled inside the classes. This is the power of OOP.

---

## 6. OOP Concepts — Explained Simply

### Classes and Objects
A **class** is like a blueprint. An **object** is the actual thing built from that blueprint.
```cpp
// Bank is the blueprint (class)
// bankAccount is the object built from it
Bank bankAccount;
```

### Constructor
A **constructor** runs automatically when an object is created. It sets initial values.
```cpp
Bank::Bank() {
    presentBalance = 20000.00; // Set when Bank object is created
}
```

### Private and Public
- **Private** = only accessible inside the class (like a vault).
- **Public** = accessible from outside the class (like a counter).

### Scope Resolution Operator (`::`)
Used to define member functions **outside** the class body.
```cpp
// Bank is the class, getPresentBalance is the function
double Bank::getPresentBalance() const {
    return presentBalance;
}
```

### Encapsulation
Keeping data private and providing controlled public access through getters/setters.

### Composition
One class contains an object of another class.
```cpp
class ATM {
    Bank bankAccount; // ATM "has-a" Bank — this is composition
};
```

---

## 7. Program Flow Diagram

```
START
  │
  ▼
ATM Object Created (constructors run)
  │
  ▼
Welcome Screen (with live date/time)
  │
  ├── [1] Login ──► Enter PIN
  │                    │
  │              ┌─────┴─────┐
  │          Correct?      Wrong?
  │              │              │
  │         Main Menu    "Access Denied"
  │              │          → EXIT
  │      ┌───────┼───────┐
  │   Balance Deposit Withdraw BankInfo
  │      │       │       │       │
  │   Display  Add $  Check $  Show
  │   Balance  to Bal  Bal+Deduct  Info
  │
  ├── [2] Help Screen
  │
  └── [3] EXIT
```

---

## 8. Input Validation Details

| Scenario | Validation Used | Response |
|---|---|---|
| Non-numeric PIN | `cin.fail()` | "Invalid PIN format. Session terminated." |
| Wrong numeric PIN | `if (enteredPIN != correctPIN)` | "Access denied. Card blocked." |
| Non-numeric deposit | `cin.fail()` | "Invalid input. Please enter a valid amount." |
| Deposit ≤ 0 | `if (depositAmount <= 0)` | "Amount must be greater than Rs. 0." |
| Non-numeric withdrawal | `cin.fail()` | "Invalid input. Please enter a valid amount." |
| Withdrawal ≤ 0 | `if (withdrawAmount <= 0)` | "Amount must be greater than Rs. 0." |
| Insufficient balance | `if (amount > presentBalance)` | "Insufficient Balance. Transaction failed." |
| Invalid menu choice | `default` in switch | "Invalid option! Please select X–Y." |

---

## 9. Balance Logic Explained

Two balance values are used as specified in the assessment:

| Balance | Value | Meaning |
|---|---|---|
| `initialBalance` | **Rs. 60,000** | The balance when the account was first opened. This value is **fixed** and never changes — it's a historical record. |
| `presentBalance` | **Rs. 20,000** | The **current** balance available for transactions. This changes after every deposit or withdrawal. |

**Why two balances?**
Real banks maintain both — the original amount credited and the running transaction balance. This teaches students about state management in OOP.

---

## 10. Viva/Interview Q&A

**Q: What is a constructor? Where did you use it?**
> A constructor is a special function that runs automatically when an object is created. I used it in `Bank::Bank()` to set the initial balance, bank name, and account details, and in `ATM::ATM()` to set the PIN and authentication flag.

**Q: What is the scope resolution operator?**
> The `::` operator is used to define a class's member function outside the class body. For example, `double Bank::getPresentBalance()` means I am defining the `getPresentBalance` function that belongs to the `Bank` class.

**Q: What is encapsulation?**
> Encapsulation means keeping data private inside a class and providing public functions (getters/setters) to access it. In my project, `presentBalance` is private — it can only be read via `getPresentBalance()` and updated via `setPresentBalance()`.

**Q: What is composition? Where did you use it?**
> Composition is when one class contains an object of another class. In my project, the `ATM` class has a `Bank bankAccount` member. This means "ATM has-a Bank account."

**Q: Why does the ATM allow only one PIN attempt?**
> Because there is no loop in `authenticateUser()`. It asks for the PIN once, checks it, and returns true or false. One wrong entry → returns false → session terminates. This is both a security feature and an OOP design decision.

**Q: How does the balance update work?**
> After a valid deposit or withdrawal, I calculate the new balance in a local variable, then call `bankAccount.setPresentBalance(newBalance)` which updates the private `presentBalance` through the setter function. This respects encapsulation.

---

*Documentation prepared for C++ OOP ATM Banking System Assessment*
