/*
 * ============================================================
 * FILE        : Bank.cpp
 * DESCRIPTION : Implementation file for the Bank class.
 *               Defines all member functions declared in Bank.h
 *               Uses scope resolution operator (::) throughout.
 * AUTHOR      : ATM Banking System Project
 * ============================================================
 */

#include "Bank.h"
#include <iomanip>   // For setw, setprecision formatting

// ============================================================
// CONSTRUCTOR: Bank::Bank()
// PURPOSE    : Initializes all bank and account details
//              with hardcoded dummy/default data.
// ============================================================
Bank::Bank()
{
    // Initialize bank details
    bankName          = "State Bank of India (SBI)";
    accountHolderName = "Prerna Sharma";
    accountNumber     = "XXXX-XXXX-5678";   // Dummy account number
    accountType       = "Savings Account";
    branchName        = "Connaught Place Branch, New Delhi";
    ifscCode          = "SBIN0001234";       // Dummy IFSC code

    // --------------------------------------------------------
    // IMPORTANT: Two balance values as specified in assessment:
    //   initialBalance  = Rs. 60000  (original/maximum balance)
    //   presentBalance  = Rs. 20000  (current transaction balance)
    // --------------------------------------------------------
    initialBalance  = 60000.00;   // Balance at account opening
    presentBalance  = 20000.00;   // Current available balance
}

// ============================================================
// FUNCTION : Bank::displayBankInfo()
// PURPOSE  : Displays complete bank and account information
//            in a formatted, readable layout.
// ============================================================
void Bank::displayBankInfo() const
{
    cout << "\n";
    cout << "  ╔══════════════════════════════════════════════════╗" << endl;
    cout << "  ║           BANK ACCOUNT INFORMATION               ║" << endl;
    cout << "  ╚══════════════════════════════════════════════════╝" << endl;
    cout << "\n";
    cout << "  ┌──────────────────────────────────────────────────┐" << endl;
    cout << "  │  Bank Name      : " << left << setw(31) << bankName          << "│" << endl;
    cout << "  │  Account Holder : " << left << setw(31) << accountHolderName << "│" << endl;
    cout << "  │  Account Number : " << left << setw(31) << accountNumber     << "│" << endl;
    cout << "  │  Account Type   : " << left << setw(31) << accountType       << "│" << endl;
    cout << "  │  Branch Name    : " << left << setw(31) << branchName        << "│" << endl;
    cout << "  │  IFSC Code      : " << left << setw(31) << ifscCode          << "│" << endl;
    cout << "  ├──────────────────────────────────────────────────┤" << endl;
    cout << "  │  Initial Balance: Rs. " << fixed << setprecision(2)
         << left << setw(27) << initialBalance                                 << "│" << endl;
    cout << "  │  Present Balance: Rs. " << fixed << setprecision(2)
         << left << setw(27) << presentBalance                                 << "│" << endl;
    cout << "  └──────────────────────────────────────────────────┘" << endl;
    cout << "\n";
    cout << "  [NOTE] Initial Balance = Rs.60000 (Balance at account opening)" << endl;
    cout << "  [NOTE] Present Balance = Rs.20000 (Current available balance)"  << endl;
    cout << "\n";
}

// ============================================================
// FUNCTION : Bank::getPresentBalance()
// PURPOSE  : Returns the current present balance.
// ============================================================
double Bank::getPresentBalance() const
{
    return presentBalance;
}

// ============================================================
// FUNCTION : Bank::setPresentBalance()
// PURPOSE  : Updates the present balance with a new value.
//            Called after deposit or withdrawal transactions.
// ============================================================
void Bank::setPresentBalance(double newBalance)
{
    presentBalance = newBalance;
}

// ============================================================
// FUNCTION : Bank::getInitialBalance()
// PURPOSE  : Returns the initial/opening account balance.
// ============================================================
double Bank::getInitialBalance() const
{
    return initialBalance;
}

// ============================================================
// FUNCTION : Bank::getBankName()
// PURPOSE  : Returns the name of the bank.
// ============================================================
string Bank::getBankName() const
{
    return bankName;
}

// ============================================================
// FUNCTION : Bank::getAccountHolderName()
// PURPOSE  : Returns the account holder's name.
// ============================================================
string Bank::getAccountHolderName() const
{
    return accountHolderName;
}
