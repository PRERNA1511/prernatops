/*
 * ============================================================
 * FILE        : main.cpp
 * DESCRIPTION : Entry point of the ATM Banking System.
 *               Creates an ATM object and starts the application.
 * AUTHOR      : ATM Banking System Project
 * ============================================================
 */

#include <iostream>
#include "ATM.h"      // Include ATM class header

using namespace std;

// ============================================================
// FUNCTION : main()
// PURPOSE  : Program entry point.
//            Creates an ATM object and runs the ATM application.
// ============================================================
int main()
{
    // --------------------------------------------------------
    // Create an ATM object.
    // This automatically calls:
    //   - ATM constructor (sets PIN = 12345)
    //   - Bank constructor (sets initial balance = 60000,
    //                       present balance = 20000)
    // --------------------------------------------------------
    ATM myATM;

    // --------------------------------------------------------
    // Start the ATM application.
    // This runs the complete welcome → login → menu → exit flow.
    // --------------------------------------------------------
    myATM.runATM();

    // --------------------------------------------------------
    // Program ends here after the user exits the ATM.
    // --------------------------------------------------------
    return 0;
}
