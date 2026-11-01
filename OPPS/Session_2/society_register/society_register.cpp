/*
 * ============================================================
 * Session 2 | Task 1: Classes and Objects – Society Register
 * Language  : C++
 * Concepts  : Classes, Objects, Member Functions, Constructors,
 *             Data Members, Access Specifiers (public/private),
 *             Object Arrays, Formatted Output (iomanip)
 * File      : society_register.cpp
 * Folder    : Session_2/society_register/
 * ============================================================
 *
 * EXPLANATION:
 * This session focuses on properly defining CLASSES and creating
 * OBJECTS. Building on Session 1, we now:
 *   1. Define the Flat class with clear private data and public methods.
 *   2. Define SocietyRegister as a manager class.
 *   3. Add sortByFlatNo() using bubble sort on objects.
 *   4. Add displayHeader() for clean table output.
 *   5. Objects fully encapsulate their own data.
 *
 * A CLASS is a blueprint. An OBJECT is an instance of that blueprint.
 * Example: Flat is the class; flat1 (Flat 101) is an object.
 *
 * EXPECTED OUTPUT:
 * ================================================
 *     SOCIETY REGISTER – Classes & Objects Demo
 * [Menu shown, user adds 3 members, displays sorted table]
 * S.No  Owner Name             Flat No      Owner ID
 * ----  ----------             -------      --------
 * 1     Aarav                  101          1001
 * 2     Priya                  202          2002
 * 3     Rahul                  303          3003
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
   Blueprint for a single flat / unit in the society.
   ===================================================== */
class Flat {
private:
    /* Private data members – only accessible through methods */
    string    ownerName;
    int       flatNumber;
    long long ownerId;
    bool      occupied;          // Is this slot filled?

public:
    /* ---- Constructors ---- */

    /* Default Constructor: initializes an empty slot */
    Flat() : ownerName(""), flatNumber(0), ownerId(0), occupied(false) {}

    /* Parameterized Constructor: create a filled flat directly */
    Flat(const string &name, int flatNo, long long id)
        : ownerName(name), flatNumber(flatNo), ownerId(id), occupied(true) {}

    /* ---- Setters ---- */
    void setName(const string &name)  { ownerName  = name;      }
    void setFlatNo(int flatNo)        { flatNumber = flatNo;     }
    void setOwnerId(long long id)     { ownerId    = id;         }
    void setOccupied(bool val)        { occupied   = val;        }

    void setDetails(const string &name, int flatNo, long long id) {
        ownerName  = name;
        flatNumber = flatNo;
        ownerId    = id;
        occupied   = true;
    }

    /* ---- Getters ---- */
    string    getName()     const { return ownerName;  }
    int       getFlatNo()   const { return flatNumber;  }
    long long getId()       const { return ownerId;     }
    bool      isOccupied()  const { return occupied;    }

    /* ---- Display Methods ---- */

    /* Print one row in the table */
    void displayRow(int serial) const {
        cout << left
             << setw(6)  << serial
             << setw(24) << ownerName
             << setw(12) << flatNumber
             << setw(15) << ownerId
             << "\n";
    }

    /* Print detailed info about this flat */
    void displayDetail() const {
        cout << "\n  +----------------------------+\n";
        cout << "  | Owner Name  : " << left << setw(14) << ownerName  << "|\n";
        cout << "  | Flat Number : " << left << setw(14) << flatNumber  << "|\n";
        cout << "  | Owner ID    : " << left << setw(14) << ownerId     << "|\n";
        cout << "  +----------------------------+\n";
    }
};

/* =====================================================
   CLASS: SocietyRegister
   Manager class: handles an array of Flat objects.
   ===================================================== */
class SocietyRegister {
private:
    static const int CAPACITY = 50;
    Flat members[CAPACITY];          // Array of Flat objects
    int  total;                      // Count of registered members

    /* ---- Private Helper Methods ---- */

    /* Convert string to lowercase for case-insensitive search */
    string toLower(const string &s) const {
        string res = s;
        for (char &c : res) c = (char)tolower((unsigned char)c);
        return res;
    }

    /* Print table header */
    void displayHeader() const {
        cout << "\n" << string(60, '=') << "\n";
        cout << left
             << setw(6)  << "S.No"
             << setw(24) << "Owner Name"
             << setw(12) << "Flat No"
             << setw(15) << "Owner ID"
             << "\n";
        cout << string(60, '-') << "\n";
    }

public:
    /* Constructor */
    SocietyRegister() : total(0) {
        cout << "[SocietyRegister object created. Capacity: "
             << CAPACITY << " flats]\n";
    }

    /* Get current member count */
    int getTotal() const { return total; }

    /* ---- Core Operations ---- */

    /* Add a new member (creates a Flat object) */
    void addMember() {
        if (total >= CAPACITY) {
            cout << "  ERROR: Register is full!\n";
            return;
        }

        string    name;
        int       flatNo;
        long long id;

        cout << "\n--- Add New Flat Owner ---\n";
        cout << "  Owner Name   : ";
        cin.ignore();
        getline(cin, name);

        cout << "  Flat Number  : ";
        cin >> flatNo;

        cout << "  Owner ID     : ";
        cin >> id;

        /* Verify flat number is unique */
        for (int i = 0; i < total; i++) {
            if (members[i].getFlatNo() == flatNo) {
                cout << "  ERROR: Flat " << flatNo << " is already registered!\n";
                cin.ignore();
                return;
            }
        }

        members[total].setDetails(name, flatNo, id);
        total++;
        cout << "  ✓ Member added! (Total registered: " << total << ")\n";
        cin.ignore();
    }

    /* Display all members in a formatted table */
    void displayAll() const {
        if (total == 0) {
            cout << "\n  No members registered yet.\n";
            return;
        }

        cout << "\n  SOCIETY REGISTER – All Members\n";
        displayHeader();

        for (int i = 0; i < total; i++)
            members[i].displayRow(i + 1);

        cout << string(60, '=') << "\n";
        cout << "  Total Members : " << total << " / " << CAPACITY << "\n";
    }

    /* Search member by name (case-insensitive) */
    void searchByName() const {
        if (total == 0) {
            cout << "\n  No members to search.\n";
            return;
        }

        string query;
        cout << "\n  Enter name to search: ";
        cin.ignore();
        getline(cin, query);
        string lowerQ = toLower(query);

        cout << "\n  Results for \"" << query << "\":\n";
        bool found = false;
        for (int i = 0; i < total; i++) {
            if (toLower(members[i].getName()) == lowerQ) {
                members[i].displayDetail();
                found = true;
            }
        }
        if (!found)
            cout << "  No member found with name \"" << query << "\".\n";
    }

    /* Sort members by flat number using bubble sort */
    void sortByFlatNo() {
        if (total < 2) {
            cout << "\n  Nothing to sort (fewer than 2 members).\n";
            return;
        }

        /* Bubble sort on the array of Flat objects */
        bool swapped;
        for (int i = 0; i < total - 1; i++) {
            swapped = false;
            for (int j = 0; j < total - i - 1; j++) {
                if (members[j].getFlatNo() > members[j + 1].getFlatNo()) {
                    /* Swap Flat objects directly */
                    Flat temp    = members[j];
                    members[j]   = members[j + 1];
                    members[j+1] = temp;
                    swapped = true;
                }
            }
            if (!swapped) break;
        }
        cout << "  ✓ Members sorted by Flat Number.\n";
        displayAll();
    }
};

/* =====================================================
   MAIN FUNCTION
   ===================================================== */
int main() {
    cout << "\n====================================================\n";
    cout << "    SOCIETY REGISTER  –  Classes & Objects (C++)    \n";
    cout << "====================================================\n";

    /* Creating an OBJECT of SocietyRegister class */
    SocietyRegister reg;

    int choice;
    do {
        cout << "\n--- MENU ---\n";
        cout << "  1. Add Member\n";
        cout << "  2. Display All Members\n";
        cout << "  3. Search by Name\n";
        cout << "  4. Sort by Flat Number\n";
        cout << "  5. Exit\n";
        cout << "Enter choice: ";
        cin >> choice;

        switch (choice) {
            case 1: reg.addMember();    break;
            case 2: reg.displayAll();   break;
            case 3: reg.searchByName(); break;
            case 4: reg.sortByFlatNo(); break;
            case 5: cout << "\nExiting... Goodbye!\n"; break;
            default: cout << "  Invalid choice!\n";
        }
    } while (choice != 5);

    return 0;
}
