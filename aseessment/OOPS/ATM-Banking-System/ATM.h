/*
 * ============================================================
 * FILE        : ATM.h
 * DESCRIPTION : Header file for the ATM class.
 *               Declares all attributes and member functions
 *               related to ATM operations and application flow.
 * AUTHOR      : ATM Banking System Project
 * ============================================================
 */

#ifndef ATM_H
#define ATM_H

#include <iostream>
#include <string>
#include <ctime>       // For getting current date and time
#include "Bank.h"      // Include Bank class

using namespace std;

// ============================================================
// CLASS: ATM
// PURPOSE: Handles all ATM operations including authentication,
//          deposits, withdrawals, menu display, and app flow.
// ============================================================
class ATM
{
private:
    // ----------------------------------------------------------
    // Private Data Members
    // ----------------------------------------------------------
    int    correctPIN;      // The valid ATM PIN (set to 12345)
    bool   isAuthenticated; // Tracks whether user is logged in
    Bank   bankAccount;     // Bank object (composition relationship)

    // ----------------------------------------------------------
    // Private Helper Functions (internal use only)
    // ----------------------------------------------------------

    // Prints a decorative line separator
    void printSeparator() const;

    // Prints a double-line separator
    void printDoubleSeparator() const;

    // Clears invalid input from the stream
    void clearInput();

public:
    // ----------------------------------------------------------
    // Constructor Declaration
    // Initializes ATM with PIN and authentication status
    // ----------------------------------------------------------
    ATM();

    // ----------------------------------------------------------
    // Public Member Function Declarations
    // ----------------------------------------------------------

    // Displays the current system date and time
    void displayDateTime() const;

    // Displays the welcome / startup screen
    void displayWelcomeScreen() const;

    // Authenticates the user with PIN
    // Returns true if PIN is correct, false otherwise
    bool authenticateUser();

    // Displays the help/instructions screen
    void displayHelp() const;

    // Displays the main ATM menu after login
    void displayMainMenu() const;

    // Checks and displays account balance
    void checkBalance() const;

    // Handles money deposit transaction
    void depositMoney();

    // Handles money withdrawal transaction
    void withdrawMoney();

    // Starts the full ATM application loop
    void runATM();
};

#endif // ATM_H
