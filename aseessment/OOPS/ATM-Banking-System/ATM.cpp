/*
 * ============================================================
 * FILE        : ATM.cpp
 * DESCRIPTION : Implementation file for the ATM class.
 *               Defines all member functions declared in ATM.h
 *               Uses scope resolution operator (::) throughout.
 * AUTHOR      : ATM Banking System Project
 * ============================================================
 */

#include "ATM.h"
#include <iomanip>   // For formatted output (setw, setprecision)
#include <limits>    // For numeric_limits (input validation)

// ============================================================
// CONSTRUCTOR: ATM::ATM()
// PURPOSE    : Initializes the ATM with the correct PIN and
//              sets authentication status to false (not logged in).
// ============================================================
ATM::ATM()
{
    correctPIN      = 12345;   // The valid ATM PIN
    isAuthenticated = false;   // User is NOT authenticated at start
    // bankAccount is auto-initialized by Bank's constructor
}

// ============================================================
// PRIVATE FUNCTION: ATM::printSeparator()
// PURPOSE         : Prints a single decorative line separator.
// ============================================================
void ATM::printSeparator() const
{
    cout << "  ════════════════════════════════════════════════════" << endl;
}

// ============================================================
// PRIVATE FUNCTION: ATM::printDoubleSeparator()
// PURPOSE         : Prints a double decorative line separator.
// ============================================================
void ATM::printDoubleSeparator() const
{
    cout << "  ╔══════════════════════════════════════════════════╗" << endl;
}

// ============================================================
// PRIVATE FUNCTION: ATM::clearInput()
// PURPOSE         : Clears invalid/bad input from cin stream.
//                   Prevents infinite loops on bad input.
// ============================================================
void ATM::clearInput()
{
    cin.clear();                                              // Clear error flags
    cin.ignore(numeric_limits<streamsize>::max(), '\n');     // Discard bad characters
}

// ============================================================
// FUNCTION : ATM::displayDateTime()
// PURPOSE  : Fetches and displays the current system date
//            and time dynamically using <ctime> library.
// ============================================================
void ATM::displayDateTime() const
{
    // Get current system time
    time_t now     = time(0);
    tm*    timePtr = localtime(&now);

    // Format and display the date and time
    cout << "  Date : " << setfill('0')
         << setw(2) << timePtr->tm_mday << "/"
         << setw(2) << (timePtr->tm_mon + 1) << "/"      // tm_mon is 0-indexed
         << (timePtr->tm_year + 1900)                    // tm_year is years since 1900
         << "   Time : "
         << setw(2) << timePtr->tm_hour << ":"
         << setw(2) << timePtr->tm_min  << ":"
         << setw(2) << timePtr->tm_sec
         << setfill(' ') << endl;
}

// ============================================================
// FUNCTION : ATM::displayWelcomeScreen()
// PURPOSE  : Shows the professional ATM welcome screen with
//            bank name, date/time, and initial menu options.
// ============================================================
void ATM::displayWelcomeScreen() const
{
    cout << "\n\n";
    cout << "  ╔══════════════════════════════════════════════════╗" << endl;
    cout << "  ║                                                  ║" << endl;
    cout << "  ║         STATE BANK OF INDIA (SBI)                ║" << endl;
    cout << "  ║            ATM BANKING SYSTEM                    ║" << endl;
    cout << "  ║                                                  ║" << endl;
    cout << "  ╚══════════════════════════════════════════════════╝" << endl;
    cout << "\n";

    // Display current date and time dynamically
    displayDateTime();

    cout << "\n";
    cout << "  ════════════════════════════════════════════════════" << endl;
    cout << "               WELCOME TO SBI ATM                     " << endl;
    cout << "  ════════════════════════════════════════════════════" << endl;
    cout << "\n";
    cout << "  Please select an option:" << endl;
    cout << "\n";
    cout << "    [ 1 ]  Login to ATM" << endl;
    cout << "    [ 2 ]  Help" << endl;
    cout << "    [ 3 ]  Exit" << endl;
    cout << "\n";
    cout << "  ────────────────────────────────────────────────────" << endl;
    cout << "  Enter your choice: ";
}

// ============================================================
// FUNCTION : ATM::authenticateUser()
// PURPOSE  : Prompts the user to enter their ATM PIN.
//            Only ONE attempt is allowed.
//            Returns true if PIN matches, false otherwise.
// ============================================================
bool ATM::authenticateUser()
{
    int enteredPIN = 0;

    cout << "\n";
    cout << "  ╔══════════════════════════════════════════════════╗" << endl;
    cout << "  ║              ATM PIN AUTHENTICATION              ║" << endl;
    cout << "  ╚══════════════════════════════════════════════════╝" << endl;
    cout << "\n";
    cout << "  ⚠  IMPORTANT: You have only ONE attempt to enter PIN." << endl;
    cout << "  ⚠  Incorrect PIN will terminate the session."          << endl;
    cout << "\n";
    cout << "  Enter your ATM PIN: ";
    cin  >> enteredPIN;

    // Check if user entered a non-numeric value
    if (cin.fail())
    {
        clearInput();
        cout << "\n";
        cout << "  ╔══════════════════════════════════════════════════╗" << endl;
        cout << "  ║          ❌  AUTHENTICATION FAILED               ║" << endl;
        cout << "  ╚══════════════════════════════════════════════════╝" << endl;
        cout << "\n";
        cout << "  Invalid PIN format! Please enter numeric digits only." << endl;
        cout << "  Session terminated for security reasons."              << endl;
        cout << "\n";
        isAuthenticated = false;
        return false;
    }

    // Validate the entered PIN against the correct PIN
    if (enteredPIN == correctPIN)
    {
        // PIN is correct — grant access
        isAuthenticated = true;
        cout << "\n";
        cout << "  ╔══════════════════════════════════════════════════╗" << endl;
        cout << "  ║          ✔  AUTHENTICATION SUCCESSFUL            ║" << endl;
        cout << "  ╚══════════════════════════════════════════════════╝" << endl;
        cout << "\n";
        cout << "  Welcome, " << bankAccount.getAccountHolderName() << "!" << endl;
        cout << "  You have successfully logged in to your account."       << endl;
        cout << "\n";
        return true;
    }
    else
    {
        // PIN is incorrect — deny access and terminate
        isAuthenticated = false;
        cout << "\n";
        cout << "  ╔══════════════════════════════════════════════════╗" << endl;
        cout << "  ║          ❌  AUTHENTICATION FAILED               ║" << endl;
        cout << "  ╚══════════════════════════════════════════════════╝" << endl;
        cout << "\n";
        cout << "  Incorrect PIN entered. Access denied!"                << endl;
        cout << "  Your card has been blocked for security reasons."     << endl;
        cout << "  Please contact your bank for assistance."             << endl;
        cout << "\n";
        return false;
    }
}

// ============================================================
// FUNCTION : ATM::displayHelp()
// PURPOSE  : Displays helpful instructions and contact info
//            for users who need guidance using the ATM.
// ============================================================
void ATM::displayHelp() const
{
    cout << "\n";
    cout << "  ╔══════════════════════════════════════════════════╗" << endl;
    cout << "  ║              ATM HELP & INSTRUCTIONS             ║" << endl;
    cout << "  ╚══════════════════════════════════════════════════╝" << endl;
    cout << "\n";

    cout << "  ┌──────────────────────────────────────────────────┐" << endl;
    cout << "  │  1. HOW TO LOGIN                                 │" << endl;
    cout << "  │     - Select option [1] on the welcome screen.   │" << endl;
    cout << "  │     - Enter your 5-digit ATM PIN when prompted.  │" << endl;
    cout << "  │     - You have only ONE attempt to enter PIN.    │" << endl;
    cout << "  │     - Sample PIN for testing: 12345              │" << endl;
    cout << "  ├──────────────────────────────────────────────────┤" << endl;
    cout << "  │  2. HOW TO CHECK BALANCE                         │" << endl;
    cout << "  │     - Login to the ATM first.                    │" << endl;
    cout << "  │     - Select option [1] from the main menu.      │" << endl;
    cout << "  │     - Your current balance will be displayed.    │" << endl;
    cout << "  ├──────────────────────────────────────────────────┤" << endl;
    cout << "  │  3. HOW TO DEPOSIT MONEY                         │" << endl;
    cout << "  │     - Login to the ATM first.                    │" << endl;
    cout << "  │     - Select option [2] from the main menu.      │" << endl;
    cout << "  │     - Enter the amount you wish to deposit.      │" << endl;
    cout << "  │     - Amount must be greater than Rs. 0.         │" << endl;
    cout << "  ├──────────────────────────────────────────────────┤" << endl;
    cout << "  │  4. HOW TO WITHDRAW MONEY                        │" << endl;
    cout << "  │     - Login to the ATM first.                    │" << endl;
    cout << "  │     - Select option [3] from the main menu.      │" << endl;
    cout << "  │     - Enter the amount you wish to withdraw.     │" << endl;
    cout << "  │     - Ensure sufficient balance is available.    │" << endl;
    cout << "  ├──────────────────────────────────────────────────┤" << endl;
    cout << "  │  5. CONTACT / CUSTOMER SUPPORT                   │" << endl;
    cout << "  │     - SBI Helpline     : 1800-11-2211            │" << endl;
    cout << "  │     - Toll Free        : 1800-425-3800           │" << endl;
    cout << "  │     - Email            : care@sbi.co.in          │" << endl;
    cout << "  │     - Website          : www.sbi.co.in           │" << endl;
    cout << "  └──────────────────────────────────────────────────┘" << endl;
    cout << "\n";
}

// ============================================================
// FUNCTION : ATM::displayMainMenu()
// PURPOSE  : Displays the main ATM menu after successful login.
// ============================================================
void ATM::displayMainMenu() const
{
    cout << "\n";
    cout << "  ╔══════════════════════════════════════════════════╗" << endl;
    cout << "  ║              MAIN ATM MENU                       ║" << endl;
    cout << "  ╚══════════════════════════════════════════════════╝" << endl;
    cout << "\n";
    cout << "  Account: " << bankAccount.getAccountHolderName() << endl;
    cout << "\n";
    cout << "    [ 1 ]  Check Account Balance" << endl;
    cout << "    [ 2 ]  Deposit Money"         << endl;
    cout << "    [ 3 ]  Withdraw Money"        << endl;
    cout << "    [ 4 ]  Bank Information"      << endl;
    cout << "    [ 5 ]  Exit"                  << endl;
    cout << "\n";
    cout << "  ────────────────────────────────────────────────────" << endl;
    cout << "  Enter your choice: ";
}

// ============================================================
// FUNCTION : ATM::checkBalance()
// PURPOSE  : Retrieves and displays the current account balance
//            along with the initial balance for reference.
// ============================================================
void ATM::checkBalance() const
{
    cout << "\n";
    cout << "  ╔══════════════════════════════════════════════════╗" << endl;
    cout << "  ║              ACCOUNT BALANCE                     ║" << endl;
    cout << "  ╚══════════════════════════════════════════════════╝" << endl;
    cout << "\n";
    cout << "  ┌──────────────────────────────────────────────────┐" << endl;
    cout << "  │  Account Holder : " << left << setw(31)
         << bankAccount.getAccountHolderName()                        << "│" << endl;
    cout << "  ├──────────────────────────────────────────────────┤" << endl;
    cout << "  │  Initial Balance: Rs. " << fixed << setprecision(2)
         << left << setw(27) << bankAccount.getInitialBalance()       << "│" << endl;
    cout << "  │  Current Balance: Rs. " << fixed << setprecision(2)
         << left << setw(27) << bankAccount.getPresentBalance()       << "│" << endl;
    cout << "  └──────────────────────────────────────────────────┘" << endl;
    cout << "\n";
    cout << "  [INFO] Initial Balance = Amount at the time of account opening." << endl;
    cout << "  [INFO] Current Balance = Amount available for transactions."      << endl;
    cout << "\n";
}

// ============================================================
// FUNCTION : ATM::depositMoney()
// PURPOSE  : Handles the deposit transaction.
//            Validates input, updates balance, shows receipt.
// ============================================================
void ATM::depositMoney()
{
    double depositAmount = 0.0;

    cout << "\n";
    cout << "  ╔══════════════════════════════════════════════════╗" << endl;
    cout << "  ║              DEPOSIT MONEY                       ║" << endl;
    cout << "  ╚══════════════════════════════════════════════════╝" << endl;
    cout << "\n";
    cout << "  Current Balance : Rs. " << fixed << setprecision(2)
         << bankAccount.getPresentBalance() << endl;
    cout << "\n";
    cout << "  Enter deposit amount (Rs.): ";
    cin  >> depositAmount;

    // --------------------------------------------------------
    // Input Validation: Check for non-numeric input
    // --------------------------------------------------------
    if (cin.fail())
    {
        clearInput();
        cout << "\n";
        cout << "  ❌ Invalid input! Please enter a valid numeric amount." << endl;
        cout << "\n";
        return;   // Go back to main menu
    }

    // --------------------------------------------------------
    // Validation: Amount must be greater than zero
    // --------------------------------------------------------
    if (depositAmount <= 0)
    {
        cout << "\n";
        cout << "  ❌ Invalid amount! Deposit amount must be greater than Rs. 0." << endl;
        cout << "\n";
        return;   // Go back to main menu
    }

    // --------------------------------------------------------
    // Valid deposit: Update the balance
    // --------------------------------------------------------
    double oldBalance = bankAccount.getPresentBalance();
    double newBalance = oldBalance + depositAmount;
    bankAccount.setPresentBalance(newBalance);   // Update balance via setter

    // Display deposit receipt
    cout << "\n";
    cout << "  ╔══════════════════════════════════════════════════╗" << endl;
    cout << "  ║         ✔  DEPOSIT SUCCESSFUL                    ║" << endl;
    cout << "  ╚══════════════════════════════════════════════════╝" << endl;
    cout << "\n";
    cout << "  ┌──────────────────────────────────────────────────┐" << endl;
    cout << "  │  Previous Balance : Rs. " << fixed << setprecision(2)
         << left << setw(26) << oldBalance                            << "│" << endl;
    cout << "  │  Amount Deposited : Rs. " << fixed << setprecision(2)
         << left << setw(26) << depositAmount                         << "│" << endl;
    cout << "  │  Updated Balance  : Rs. " << fixed << setprecision(2)
         << left << setw(26) << newBalance                            << "│" << endl;
    cout << "  └──────────────────────────────────────────────────┘" << endl;
    cout << "\n";
    cout << "  ✔ Transaction Complete. Thank you for using SBI ATM!" << endl;
    cout << "\n";
}

// ============================================================
// FUNCTION : ATM::withdrawMoney()
// PURPOSE  : Handles the withdrawal transaction.
//            Validates amount, checks balance, updates account.
// ============================================================
void ATM::withdrawMoney()
{
    double withdrawAmount = 0.0;

    cout << "\n";
    cout << "  ╔══════════════════════════════════════════════════╗" << endl;
    cout << "  ║              WITHDRAW MONEY                      ║" << endl;
    cout << "  ╚══════════════════════════════════════════════════╝" << endl;
    cout << "\n";
    cout << "  Available Balance: Rs. " << fixed << setprecision(2)
         << bankAccount.getPresentBalance() << endl;
    cout << "\n";
    cout << "  Enter withdrawal amount (Rs.): ";
    cin  >> withdrawAmount;

    // --------------------------------------------------------
    // Input Validation: Check for non-numeric input
    // --------------------------------------------------------
    if (cin.fail())
    {
        clearInput();
        cout << "\n";
        cout << "  ❌ Invalid input! Please enter a valid numeric amount." << endl;
        cout << "\n";
        return;   // Go back to main menu
    }

    // --------------------------------------------------------
    // Validation: Amount must be greater than zero
    // --------------------------------------------------------
    if (withdrawAmount <= 0)
    {
        cout << "\n";
        cout << "  ❌ Invalid amount! Withdrawal amount must be greater than Rs. 0." << endl;
        cout << "\n";
        return;
    }

    // --------------------------------------------------------
    // Check sufficient balance
    // --------------------------------------------------------
    if (withdrawAmount > bankAccount.getPresentBalance())
    {
        // Insufficient balance — transaction failed
        cout << "\n";
        cout << "  ╔══════════════════════════════════════════════════╗" << endl;
        cout << "  ║       ❌  WITHDRAWAL UNSUCCESSFUL                ║" << endl;
        cout << "  ╚══════════════════════════════════════════════════╝" << endl;
        cout << "\n";
        cout << "  Insufficient Balance!"                                         << endl;
        cout << "  Requested Amount : Rs. " << fixed << setprecision(2)
             << withdrawAmount                                                    << endl;
        cout << "  Available Balance: Rs. " << fixed << setprecision(2)
             << bankAccount.getPresentBalance()                                   << endl;
        cout << "\n";
        cout << "  Please enter an amount less than or equal to your balance."   << endl;
        cout << "\n";
        return;
    }

    // --------------------------------------------------------
    // Sufficient balance — process withdrawal
    // --------------------------------------------------------
    double oldBalance = bankAccount.getPresentBalance();
    double newBalance = oldBalance - withdrawAmount;
    bankAccount.setPresentBalance(newBalance);   // Update balance via setter

    // Display withdrawal receipt
    cout << "\n";
    cout << "  ╔══════════════════════════════════════════════════╗" << endl;
    cout << "  ║         ✔  WITHDRAWAL SUCCESSFUL                 ║" << endl;
    cout << "  ╚══════════════════════════════════════════════════╝" << endl;
    cout << "\n";
    cout << "  ┌──────────────────────────────────────────────────┐" << endl;
    cout << "  │  Previous Balance : Rs. " << fixed << setprecision(2)
         << left << setw(26) << oldBalance                            << "│" << endl;
    cout << "  │  Amount Withdrawn : Rs. " << fixed << setprecision(2)
         << left << setw(26) << withdrawAmount                        << "│" << endl;
    cout << "  │  Updated Balance  : Rs. " << fixed << setprecision(2)
         << left << setw(26) << newBalance                            << "│" << endl;
    cout << "  └──────────────────────────────────────────────────┘" << endl;
    cout << "\n";
    cout << "  ✔ Please collect your cash. Thank you for using SBI ATM!" << endl;
    cout << "\n";
}

// ============================================================
// FUNCTION : ATM::runATM()
// PURPOSE  : Main controller function. Runs the full ATM loop
//            from welcome screen through all operations to exit.
// ============================================================
void ATM::runATM()
{
    int welcomeChoice = 0;   // Stores choice from welcome menu
    int mainChoice    = 0;   // Stores choice from main ATM menu

    // --------------------------------------------------------
    // WELCOME SCREEN LOOP
    // Keeps running until the user logs in, views help, or exits
    // --------------------------------------------------------
    while (true)
    {
        displayWelcomeScreen();   // Show the welcome screen
        cin >> welcomeChoice;

        // Validate numeric input
        if (cin.fail())
        {
            clearInput();
            cout << "\n  ❌ Invalid input! Please enter 1, 2, or 3.\n" << endl;
            continue;   // Show welcome screen again
        }

        // Handle welcome menu choice using switch
        switch (welcomeChoice)
        {
            // --------------------------------------------------
            case 1:   // Login to ATM
            // --------------------------------------------------
                if (authenticateUser())   // Try to authenticate
                {
                    // PIN correct — enter main ATM menu loop
                    while (true)
                    {
                        displayMainMenu();   // Show main menu
                        cin >> mainChoice;

                        // Validate numeric input
                        if (cin.fail())
                        {
                            clearInput();
                            cout << "\n  ❌ Invalid input! Please enter 1–5.\n" << endl;
                            continue;
                        }

                        // Handle main menu choices
                        switch (mainChoice)
                        {
                            case 1:
                                // Check Account Balance
                                checkBalance();
                                break;

                            case 2:
                                // Deposit Money
                                depositMoney();
                                break;

                            case 3:
                                // Withdraw Money
                                withdrawMoney();
                                break;

                            case 4:
                                // Bank Information
                                bankAccount.displayBankInfo();
                                break;

                            case 5:
                                // Exit from main menu
                                cout << "\n";
                                cout << "  ╔══════════════════════════════════════════════════╗" << endl;
                                cout << "  ║              THANK YOU FOR USING                 ║" << endl;
                                cout << "  ║            STATE BANK OF INDIA ATM               ║" << endl;
                                cout << "  ║                                                  ║" << endl;
                                cout << "  ║   Please take your card. Have a great day! 😊    ║" << endl;
                                cout << "  ╚══════════════════════════════════════════════════╝" << endl;
                                cout << "\n";
                                return;   // Exit the entire ATM application

                            default:
                                // Invalid choice in main menu
                                cout << "\n  ❌ Invalid option! Please select 1–5.\n" << endl;
                                break;
                        }
                    }
                }
                else
                {
                    // PIN incorrect — session terminated
                    cout << "  Session terminated. Goodbye!" << endl;
                    cout << "\n";
                    return;   // Exit the ATM application
                }
                break;

            // --------------------------------------------------
            case 2:   // Help
            // --------------------------------------------------
                displayHelp();
                break;

            // --------------------------------------------------
            case 3:   // Exit from welcome screen
            // --------------------------------------------------
                cout << "\n";
                cout << "  ════════════════════════════════════════════════════" << endl;
                cout << "      Thank you for visiting SBI ATM. Goodbye!        " << endl;
                cout << "  ════════════════════════════════════════════════════" << endl;
                cout << "\n";
                return;   // Exit the application

            // --------------------------------------------------
            default:   // Invalid choice on welcome screen
            // --------------------------------------------------
                cout << "\n  ❌ Invalid option! Please select 1, 2, or 3.\n" << endl;
                break;
        }
    }
}
