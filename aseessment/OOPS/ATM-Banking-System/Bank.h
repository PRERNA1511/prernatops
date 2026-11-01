/*
 * ============================================================
 * FILE        : Bank.h
 * DESCRIPTION : Header file for the Bank class.
 *               Declares all attributes and member functions
 *               related to bank and account information.
 * AUTHOR      : ATM Banking System Project
 * ============================================================
 */

#ifndef BANK_H
#define BANK_H

#include <iostream>
#include <string>

using namespace std;

// ============================================================
// CLASS: Bank
// PURPOSE: Stores and displays all bank-related information
//          including account holder details and bank details.
// ============================================================
class Bank
{
private:
    // ----------------------------------------------------------
    // Private Data Members (accessible only within this class)
    // ----------------------------------------------------------
    string bankName;          // Name of the bank
    string accountHolderName; // Name of the account holder
    string accountNumber;     // Bank account number (dummy)
    string accountType;       // Type of account (Savings/Current)
    string branchName;        // Branch name
    string ifscCode;          // IFSC code of the branch (dummy)
    double initialBalance;    // Initial balance set at account opening
    double presentBalance;    // Current/present balance in account

public:
    // ----------------------------------------------------------
    // Constructor Declaration
    // Initializes all bank details with default values
    // ----------------------------------------------------------
    Bank();

    // ----------------------------------------------------------
    // Public Member Function Declarations
    // ----------------------------------------------------------

    // Displays complete bank and account information
    void displayBankInfo() const;

    // Getter: Returns the current present balance
    double getPresentBalance() const;

    // Setter: Updates the present balance
    void setPresentBalance(double newBalance);

    // Getter: Returns the initial balance
    double getInitialBalance() const;

    // Getter: Returns bank name
    string getBankName() const;

    // Getter: Returns account holder name
    string getAccountHolderName() const;
};

#endif // BANK_H
