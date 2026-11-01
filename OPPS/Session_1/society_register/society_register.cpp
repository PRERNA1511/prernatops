/*
 * ============================================================
 * Session 1 | Task 2: OOP Society Registration System
 * Language  : C++
 * Concepts  : Object-Oriented Programming, Classes, Objects,
 *             Encapsulation, Member Functions, Arrays of Objects,
 *             String, cin/cout, Menus
 * File      : society_register.cpp
 * Folder    : Session_1/society_register/
 * ============================================================
 *
 * EXPLANATION:
 * This program demonstrates the OBJECT-ORIENTED approach for the
 * same society registration problem solved in society_procedural.c.
 *
 * Key OOP Differences from Procedural:
 *   - A 'Flat' class bundles DATA (ownerName, flatNumber, ownerId)
 *     and BEHAVIOR (setDetails, display, getName, etc.) together.
 *   - A 'SocietyRegister' class manages an array of Flat objects.
 *   - Data is private; accessed only through public methods.
 *   - No global variables – everything is encapsulated inside objects.
 *
 * Class Design:
 *   Flat {
 *       - ownerName  : string
 *       - flatNumber : int
 *       - ownerId    : long long
 *       + setDetails(), display(), getName(), getFlatNo(), getId()
 *   }
 *   SocietyRegister {
 *       - members[]  : Flat[50]
 *       - total      : int
 *       + addMember(), displayAll(), searchByName()
 *   }
 *
 * EXPECTED OUTPUT:
 * ================================================
 * === SOCIETY REGISTRATION SYSTEM (OOP - C++) ===
 * 1. Add Member  2. Display All  3. Search  4. Exit
 * Enter choice: 1
 * Enter Name: Priya  Flat: 202  ID: 2002
 * Member added!
 * [Display shows formatted table of all members]
 * ================================================
 */

#include <iostream>
#include <iomanip>
#include <string>
#include <algorithm>
#include <cctype>
using namespace std;

/* =====================================================
   CLASS: Flat
   Represents a single flat and its owner details.
   ===================================================== */
class Flat {
private:
    string    ownerName;
    int       flatNumber;
    long long ownerId;

public:
    /* Default Constructor */
    Flat() : ownerName(""), flatNumber(0), ownerId(0) {}

    /* Parameterized Constructor */
    Flat(string name, int flatNo, long long id)
        : ownerName(name), flatNumber(flatNo), ownerId(id) {}

    /* Setter */
    void setDetails(const string &name, int flatNo, long long id) {
        ownerName  = name;
        flatNumber = flatNo;
        ownerId    = id;
    }

    /* Display this flat's info in a formatted row */
    void display(int serial) const {
        cout << left
             << setw(5)  << serial
             << setw(22) << ownerName
             << setw(12) << flatNumber
             << setw(15) << ownerId
             << "\n";
    }

    /* Getters */
    string    getName()   const { return ownerName;  }
    int       getFlatNo() const { return flatNumber;  }
    long long getId()     const { return ownerId;     }

    /* Check if slot is occupied */
    bool isEmpty() const { return ownerName.empty(); }
};

/* =====================================================
   CLASS: SocietyRegister
   Manages a collection of Flat objects.
   ===================================================== */
class SocietyRegister {
private:
    static const int MAX = 50;
    Flat members[MAX];
    int  total;

    /* Helper: convert string to lowercase */
    string toLower(const string &s) const {
        string result = s;
        transform(result.begin(), result.end(), result.begin(),
                  [](unsigned char c){ return tolower(c); });
        return result;
    }

public:
    /* Constructor */
    SocietyRegister() : total(0) {}

    /* Add a new member */
    void addMember() {
        if (total >= MAX) {
            cout << "Society register is full!\n";
            return;
        }
        string    name;
        int       flatNo;
        long long id;

        cout << "\n--- Add New Member ---\n";
        cout << "Enter Owner Name   : ";
        cin.ignore();
        getline(cin, name);
        cout << "Enter Flat Number  : ";
        cin >> flatNo;
        cout << "Enter Owner ID     : ";
        cin >> id;

        members[total].setDetails(name, flatNo, id);
        total++;
        cout << "Member added successfully! (Total: " << total << ")\n";
    }

    /* Display all members */
    void displayAll() const {
        if (total == 0) {
            cout << "\nNo members registered yet.\n";
            return;
        }
        cout << "\n=================================================\n";
        cout << "         REGISTERED SOCIETY MEMBERS (OOP)       \n";
        cout << "=================================================\n";
        cout << left
             << setw(5)  << "S.No"
             << setw(22) << "Owner Name"
             << setw(12) << "Flat No"
             << setw(15) << "Owner ID"
             << "\n";
        cout << string(54, '-') << "\n";

        for (int i = 0; i < total; i++)
            members[i].display(i + 1);

        cout << "=================================================\n";
        cout << "Total Members: " << total << "\n";
    }

    /* Search by name (case-insensitive) */
    void searchByName() const {
        string query;
        cout << "\nEnter name to search: ";
        cin.ignore();
        getline(cin, query);

        string lowerQuery = toLower(query);
        bool   found      = false;

        cout << "\n--- Search Results for \"" << query << "\" ---\n";

        for (int i = 0; i < total; i++) {
            if (toLower(members[i].getName()) == lowerQuery) {
                cout << "Found! --> Flat: " << members[i].getFlatNo()
                     << " | Owner: "        << members[i].getName()
                     << " | ID: "           << members[i].getId() << "\n";
                found = true;
            }
        }
        if (!found)
            cout << "No member found with name \"" << query << "\".\n";
    }
};

/* =====================================================
   MAIN
   ===================================================== */
int main() {
    SocietyRegister reg;
    int choice;

    cout << "=================================================\n";
    cout << "  SOCIETY REGISTRATION SYSTEM  (OOP - C++)      \n";
    cout << "=================================================\n";

    do {
        cout << "\n--- MENU ---\n";
        cout << "1. Add Member\n";
        cout << "2. Display All Members\n";
        cout << "3. Search Member by Name\n";
        cout << "4. Exit\n";
        cout << "Enter your choice: ";
        cin >> choice;

        switch (choice) {
            case 1: reg.addMember();    break;
            case 2: reg.displayAll();   break;
            case 3: reg.searchByName(); break;
            case 4: cout << "\nGoodbye! Exiting Society Register.\n"; break;
            default: cout << "Invalid choice! Please enter 1-4.\n";
        }
    } while (choice != 4);

    return 0;
}
