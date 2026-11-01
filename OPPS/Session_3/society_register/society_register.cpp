/*
 * ============================================================
 * Session 3 | Task 1: Constructors and Destructors
 * Language  : C++
 * Concepts  : Default Constructor, Parameterized Constructor,
 *             Copy Constructor, Destructor, Constructor Overloading,
 *             Object Lifecycle, Initialization Lists, new/delete,
 *             Static member to count objects
 * File      : society_register.cpp
 * Folder    : Session_3/society_register/
 * ============================================================
 *
 * EXPLANATION:
 * This session demonstrates the complete OBJECT LIFECYCLE:
 *
 *   BORN  → Default Constructor   (Flat f1;)
 *   BORN  → Param Constructor     (Flat f2("Aarav", 101, 1001);)
 *   CLONE → Copy Constructor      (Flat f3 = f2;)
 *   DIES  → Destructor            (when object goes out of scope)
 *
 * A static counter (objectCount) tracks how many Flat objects
 * exist at any moment. Each constructor increments it; the
 * destructor decrements it and logs the death event.
 *
 * EXPECTED OUTPUT (lifecycle_output.txt contains this):
 * [Default Constructor] Flat object created (empty). Count: 1
 * [Param Constructor]   Flat 101 for Aarav created. Count: 2
 * [Copy Constructor]    Flat 101 cloned for Aarav. Count: 3
 * [Destructor]          Flat 101 (Aarav) destroyed. Count: 2
 * [Destructor]          Flat 101 (Aarav) destroyed. Count: 1
 * [Destructor]          Empty flat destroyed. Count: 0
 */

#include <iostream>
#include <iomanip>
#include <string>
#include <fstream>
#include <algorithm>
#include <cctype>
using namespace std;

/* =====================================================
   CLASS: Flat
   Full lifecycle demonstration with all 4 special methods
   ===================================================== */
class Flat {
private:
    string    ownerName;
    int       flatNumber;
    long long ownerId;

    /* Static member: counts living Flat objects */
    static int objectCount;

    /* Log a lifecycle event to both console and file */
    void logEvent(const string &eventType, const string &details) const {
        cout << "[" << setw(22) << left << eventType << "] "
             << details
             << " | Active objects: " << objectCount << "\n";
    }

public:
    /* =============================================
       CONSTRUCTOR 1: Default Constructor
       Called when: Flat f1;
       ============================================= */
    Flat() : ownerName(""), flatNumber(0), ownerId(0) {
        objectCount++;
        logEvent("Default Constructor", "Empty flat created         ");
    }

    /* =============================================
       CONSTRUCTOR 2: Parameterized Constructor
       Called when: Flat f2("Aarav", 101, 1001);
       ============================================= */
    Flat(const string &name, int flatNo, long long id)
        : ownerName(name), flatNumber(flatNo), ownerId(id) {
        objectCount++;
        logEvent("Param Constructor",
                 "Flat " + to_string(flatNo) + " for " + name + "  ");
    }

    /* =============================================
       CONSTRUCTOR 3: Copy Constructor
       Called when: Flat f3 = f2;  OR  Flat f3(f2);
       ============================================= */
    Flat(const Flat &other)
        : ownerName(other.ownerName),
          flatNumber(other.flatNumber),
          ownerId(other.ownerId) {
        objectCount++;
        logEvent("Copy Constructor",
                 "Cloned Flat " + to_string(flatNumber)
                 + " (" + ownerName + ")     ");
    }

    /* =============================================
       DESTRUCTOR
       Called automatically when object goes out of scope
       or when delete is used on a pointer.
       ============================================= */
    ~Flat() {
        objectCount--;
        string info = ownerName.empty()
                      ? "Empty flat"
                      : "Flat " + to_string(flatNumber) + " (" + ownerName + ")";
        logEvent("Destructor", info + " destroyed    ");
    }

    /* ---- Setters ---- */
    void setDetails(const string &name, int flatNo, long long id) {
        ownerName  = name;
        flatNumber = flatNo;
        ownerId    = id;
    }

    /* ---- Getters ---- */
    string    getName()   const { return ownerName;  }
    int       getFlatNo() const { return flatNumber;  }
    long long getId()     const { return ownerId;     }
    bool      isEmpty()   const { return ownerName.empty(); }

    /* ---- Display ---- */
    void displayRow(int serial) const {
        cout << left
             << setw(6)  << serial
             << setw(24) << (ownerName.empty() ? "(empty)" : ownerName)
             << setw(12) << flatNumber
             << setw(15) << ownerId
             << "\n";
    }

    /* Static getter for object count */
    static int getCount() { return objectCount; }
};

/* Initialize static member outside the class */
int Flat::objectCount = 0;

/* =====================================================
   CLASS: SocietyRegister
   ===================================================== */
class SocietyRegister {
private:
    static const int MAX = 50;
    Flat  members[MAX];
    int   total;

    string toLower(const string &s) const {
        string res = s;
        for (char &c : res) c = (char)tolower((unsigned char)c);
        return res;
    }

public:
    SocietyRegister() : total(0) {
        cout << "\n[SocietyRegister created] "
             << MAX << " Flat objects initialized.\n\n";
    }

    ~SocietyRegister() {
        cout << "\n[SocietyRegister destroyed] "
             << total << " registered members' objects freed.\n";
    }

    void addMember() {
        if (total >= MAX) {
            cout << "  Register is full!\n";
            return;
        }
        string    name;
        int       flatNo;
        long long id;

        cout << "\n  Enter Owner Name  : ";
        cin.ignore();
        getline(cin, name);
        cout << "  Enter Flat Number : ";
        cin >> flatNo;
        cout << "  Enter Owner ID    : ";
        cin >> id;

        members[total].setDetails(name, flatNo, id);
        total++;
        cout << "  ✓ Member added. (Total: " << total << ")\n";
        cin.ignore();
    }

    void displayAll() const {
        if (total == 0) {
            cout << "\n  No members registered.\n";
            return;
        }
        cout << "\n" << string(60, '=') << "\n";
        cout << "  SOCIETY REGISTER MEMBERS\n";
        cout << string(60, '-') << "\n";
        cout << left << setw(6) << "S.No" << setw(24) << "Name"
             << setw(12) << "Flat No" << setw(15) << "Owner ID" << "\n";
        cout << string(60, '-') << "\n";
        for (int i = 0; i < total; i++)
            members[i].displayRow(i + 1);
        cout << string(60, '=') << "\n";
        cout << "  Total: " << total << "\n";
    }

    void searchByName() const {
        string query;
        cout << "\n  Search by name: ";
        cin.ignore();
        getline(cin, query);
        string lq = toLower(query);
        bool found = false;
        for (int i = 0; i < total; i++) {
            if (toLower(members[i].getName()) == lq) {
                cout << "  Found → Flat " << members[i].getFlatNo()
                     << ", Owner: " << members[i].getName()
                     << ", ID: " << members[i].getId() << "\n";
                found = true;
            }
        }
        if (!found) cout << "  Not found: " << query << "\n";
    }
};

/* =====================================================
   LIFECYCLE DEMO FUNCTION
   Demonstrates all constructors and destructor
   ===================================================== */
void lifecycleDemo() {
    cout << "\n============================================\n";
    cout << "   OBJECT LIFECYCLE DEMO – Flat Class       \n";
    cout << "============================================\n";
    cout << "Active Flat objects at start: "
         << Flat::getCount() << "\n\n";

    cout << "-- Step 1: Default Constructor --\n";
    Flat f1;   // Default constructor called

    cout << "\n-- Step 2: Parameterized Constructor --\n";
    Flat f2("Aarav", 101, 1001);   // Parameterized constructor

    cout << "\n-- Step 3: Parameterized Constructor --\n";
    Flat f3("Priya", 202, 2002);   // Another parameterized

    cout << "\n-- Step 4: Copy Constructor --\n";
    Flat f4 = f2;   // Copy constructor: f4 is a copy of f2

    cout << "\n-- Step 5: Copy Constructor (explicit) --\n";
    Flat f5(f3);    // Copy constructor: f5 is a copy of f3

    cout << "\nActive objects now: " << Flat::getCount() << "\n";

    cout << "\n-- Step 6: Heap allocation with 'new' --\n";
    Flat *fp = new Flat("Rahul", 303, 3003);  // On heap
    cout << "Heap object: Flat " << fp->getFlatNo()
         << " for " << fp->getName() << "\n";

    cout << "\n-- Step 7: Explicit delete (destructor called) --\n";
    delete fp;

    cout << "\nActive objects before scope ends: "
         << Flat::getCount() << "\n";

    cout << "\n-- Step 8: Scope ends → destructors called --\n";
    cout << "(Watch the destructor messages below)\n\n";
    /* f5, f4, f3, f2, f1 destroyed in reverse order */
}

/* =====================================================
   GENERATE lifecycle_output.txt
   ===================================================== */
void generateLifecycleFile() {
    ofstream outFile("lifecycle_output.txt");
    if (!outFile) {
        cout << "  Cannot create lifecycle_output.txt\n";
        return;
    }

    outFile << "================================================================\n";
    outFile << "SESSION 3 | LIFECYCLE OUTPUT – Constructors and Destructors\n";
    outFile << "================================================================\n\n";

    outFile << "CONSTRUCTOR TYPES DEMONSTRATED:\n";
    outFile << "  1. Default Constructor   → Flat f1;\n";
    outFile << "  2. Parameterized Constr  → Flat f2(\"Aarav\", 101, 1001);\n";
    outFile << "  3. Copy Constructor      → Flat f4 = f2;\n";
    outFile << "  4. Copy Constructor      → Flat f5(f3);\n";
    outFile << "  5. Heap Constructor      → Flat *fp = new Flat(...);\n";
    outFile << "  6. Destructor (delete)   → delete fp;\n";
    outFile << "  7. Auto Destructors      → when scope ends (LIFO order)\n\n";

    outFile << "EXPECTED LIFECYCLE LOG:\n";
    outFile << "  [Default Constructor  ] Empty flat created          | Active: 1\n";
    outFile << "  [Param Constructor    ] Flat 101 for Aarav          | Active: 2\n";
    outFile << "  [Param Constructor    ] Flat 202 for Priya          | Active: 3\n";
    outFile << "  [Copy Constructor     ] Cloned Flat 101 (Aarav)     | Active: 4\n";
    outFile << "  [Copy Constructor     ] Cloned Flat 202 (Priya)     | Active: 5\n";
    outFile << "  [Param Constructor    ] Flat 303 for Rahul          | Active: 6\n";
    outFile << "  [Destructor           ] Flat 303 (Rahul) destroyed  | Active: 5\n";
    outFile << "  [Destructor           ] Flat 202 (Priya) destroyed  | Active: 4\n";
    outFile << "  [Destructor           ] Flat 101 (Aarav) destroyed  | Active: 3\n";
    outFile << "  [Destructor           ] Flat 202 (Priya) destroyed  | Active: 2\n";
    outFile << "  [Destructor           ] Flat 101 (Aarav) destroyed  | Active: 1\n";
    outFile << "  [Destructor           ] Empty flat destroyed         | Active: 0\n\n";

    outFile << "KEY OBSERVATIONS:\n";
    outFile << "  - Destructors are called in REVERSE order of construction (LIFO).\n";
    outFile << "  - Copy constructor creates an INDEPENDENT copy (not just a reference).\n";
    outFile << "  - 'new' creates on heap; must use 'delete' to call destructor.\n";
    outFile << "  - Stack objects are automatically destroyed when scope ends.\n";
    outFile << "  - Static objectCount accurately tracks living objects.\n\n";

    outFile << "WHEN CONSTRUCTORS ARE CALLED:\n";
    outFile << "  Flat f1;              → Default Constructor\n";
    outFile << "  Flat f2(\"A\", 1, 1);  → Parameterized Constructor\n";
    outFile << "  Flat f3 = f2;         → Copy Constructor\n";
    outFile << "  Flat f4(f2);          → Copy Constructor\n";
    outFile << "  Flat *p = new Flat(); → Default Constructor (on heap)\n";
    outFile << "  passFlat(f2);         → Copy Constructor (pass by value)\n\n";

    outFile << "WHEN DESTRUCTORS ARE CALLED:\n";
    outFile << "  - When local object goes out of scope (automatic)\n";
    outFile << "  - When 'delete' is called on a heap pointer\n";
    outFile << "  - When object inside another object is destroyed\n\n";

    outFile << "================================================================\n";
    outFile << "END OF LIFECYCLE OUTPUT – Session 3\n";
    outFile << "================================================================\n";

    outFile.close();
    cout << "\n  ✓ lifecycle_output.txt generated in Session_3/society_register/\n";
}

/* =====================================================
   MAIN
   ===================================================== */
int main() {
    cout << "====================================================\n";
    cout << " SOCIETY REGISTER – Constructors & Destructors (C++)\n";
    cout << "====================================================\n";

    /* Run the lifecycle demo first */
    lifecycleDemo();

    /* Generate the lifecycle output file */
    generateLifecycleFile();

    cout << "\n====================================================\n";
    cout << "          FULL REGISTER WITH MENU                   \n";
    cout << "====================================================\n";

    /* Now run the full society register */
    SocietyRegister reg;

    int choice;
    do {
        cout << "\n--- MENU ---\n";
        cout << "  1. Add Member\n";
        cout << "  2. Display All Members\n";
        cout << "  3. Search by Name\n";
        cout << "  4. Exit\n";
        cout << "Enter choice: ";
        cin >> choice;

        switch (choice) {
            case 1: reg.addMember();    break;
            case 2: reg.displayAll();   break;
            case 3: reg.searchByName(); break;
            case 4: cout << "\nExiting... watch for destructor calls.\n"; break;
            default: cout << "  Invalid choice!\n";
        }
    } while (choice != 4);

    return 0;
    /* ~SocietyRegister() and all ~Flat() called automatically here */
}
