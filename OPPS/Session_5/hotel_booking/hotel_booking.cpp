/*
 * ============================================================
 * Session 5 | Task 1: Polymorphism – Hotel Booking System
 * Language  : C++
 * Concepts  : Polymorphism, Virtual Functions, Pure Virtual Functions,
 *             Abstract Base Class, Runtime Polymorphism,
 *             Base Class Pointers to Derived Objects,
 *             vtable, vptr, Method Overriding with 'override'
 * File      : hotel_booking.cpp
 * Folder    : Session_5/hotel_booking/
 * ============================================================
 *
 * EXPLANATION:
 * POLYMORPHISM = "many forms" – one interface, many behaviors.
 *
 * This session demonstrates RUNTIME POLYMORPHISM using virtual functions:
 *
 *   WITHOUT virtual:
 *     Room *r = new Suite(...);
 *     r->calculateCost();  --> calls Room::calculateCost() (WRONG!)
 *     [Early binding / Compile-time binding]
 *
 *   WITH virtual:
 *     Room *r = new Suite(...);
 *     r->calculateCost();  --> calls Suite::calculateCost() (CORRECT!)
 *     [Late binding / Runtime binding via vtable]
 *
 * Key features in this session:
 *   - Abstract base class (pure virtual function: = 0)
 *   - Array of base class pointers pointing to different derived objects
 *   - Loop through all rooms calling the same method → different behavior
 *   - Generate without_virtual.txt and with_virtual.txt to compare
 *
 * EXPECTED OUTPUT (with virtual):
 *   Room 101 (SingleRoom): Rs 3000   [1500 x 2 nights]
 *   Room 201 (DoubleRoom): Rs 7500   [2500 x 3 nights]
 *   Room 301 (Suite)     : Rs 24000  [6000 x 4 nights with jacuzzi]
 */

#include <iostream>
#include <iomanip>
#include <string>
#include <fstream>
#include <vector>
#include <memory>
using namespace std;

/* =====================================================
   ABSTRACT BASE CLASS: Room
   Has pure virtual functions → cannot be instantiated directly
   ===================================================== */
class Room {
protected:
    int    roomNumber;
    string guestName;
    int    nights;
    bool   isBooked;

public:
    Room() : roomNumber(0), guestName(""), nights(0), isBooked(false) {}

    Room(int rNo, const string &guest, int n)
        : roomNumber(rNo), guestName(guest), nights(n), isBooked(true) {}

    /* VIRTUAL DESTRUCTOR – essential when using base class pointers */
    virtual ~Room() {}

    /* PURE VIRTUAL FUNCTIONS – make Room an abstract class */
    virtual double calculateCost()  const = 0;   /* MUST override */
    virtual string getRoomType()    const = 0;   /* MUST override */

    /* VIRTUAL display – overridden with specific room details */
    virtual void display() const {
        cout << left
             << setw(8)  << roomNumber
             << setw(14) << getRoomType()
             << setw(22) << guestName
             << setw(8)  << nights
             << "Rs " << calculateCost() << "\n";
    }

    /* Non-virtual getters */
    int    getRoomNo() const { return roomNumber; }
    string getGuest()  const { return guestName;  }
    int    getNights() const { return nights;     }
    bool   getBooked() const { return isBooked;   }
};

/* =====================================================
   DERIVED CLASS 1: SingleRoom
   ===================================================== */
class SingleRoom : public Room {
private:
    string bedSize;

public:
    SingleRoom() : Room(), bedSize("Single") {}

    SingleRoom(int rNo, const string &guest, int n, const string &bed = "Single")
        : Room(rNo, guest, n), bedSize(bed) {}

    /* Override pure virtual functions */
    double calculateCost() const override {
        return 1500.0 * nights;
    }

    string getRoomType() const override { return "Single Room"; }

    void display() const override {
        cout << left
             << setw(8)  << roomNumber
             << setw(14) << getRoomType()
             << setw(22) << guestName
             << setw(8)  << nights
             << setw(14) << bedSize
             << "Rs " << calculateCost() << "\n";
    }
};

/* =====================================================
   DERIVED CLASS 2: DoubleRoom
   ===================================================== */
class DoubleRoom : public Room {
private:
    bool extraBed;

public:
    DoubleRoom() : Room(), extraBed(false) {}

    DoubleRoom(int rNo, const string &guest, int n, bool extra = false)
        : Room(rNo, guest, n), extraBed(extra) {}

    double calculateCost() const override {
        return (2500.0 + (extraBed ? 500.0 : 0.0)) * nights;
    }

    string getRoomType() const override { return "Double Room"; }

    void display() const override {
        cout << left
             << setw(8)  << roomNumber
             << setw(14) << getRoomType()
             << setw(22) << guestName
             << setw(8)  << nights
             << setw(14) << (extraBed ? "Extra Bed" : "Standard")
             << "Rs " << calculateCost() << "\n";
    }
};

/* =====================================================
   DERIVED CLASS 3: Suite
   ===================================================== */
class Suite : public Room {
private:
    bool hasJacuzzi;
    int  floorLevel;

public:
    Suite() : Room(), hasJacuzzi(false), floorLevel(1) {}

    Suite(int rNo, const string &guest, int n, bool jacuzzi, int floor)
        : Room(rNo, guest, n), hasJacuzzi(jacuzzi), floorLevel(floor) {}

    double calculateCost() const override {
        return (5000.0 + (hasJacuzzi ? 1000.0 : 0.0)) * nights;
    }

    string getRoomType() const override { return "Suite"; }

    void display() const override {
        cout << left
             << setw(8)  << roomNumber
             << setw(14) << getRoomType()
             << setw(22) << guestName
             << setw(8)  << nights
             << setw(14) << (hasJacuzzi ? "With Jacuzzi" : "No Jacuzzi")
             << "Rs " << calculateCost()
             << " | Floor " << floorLevel << "\n";
    }
};

/* =====================================================
   POLYMORPHISM DEMONSTRATION
   Using base class pointers to call derived methods
   ===================================================== */
void demonstratePolymorphism() {
    cout << "\n============================================\n";
    cout << "   POLYMORPHISM DEMO – Base Class Pointers  \n";
    cout << "============================================\n\n";

    /* Array of Room* (base class pointers) pointing to derived objects */
    vector<Room*> rooms;

    rooms.push_back(new SingleRoom(101, "Aarav Sharma",  2, "Queen"));
    rooms.push_back(new SingleRoom(102, "Neha Patel",    1, "Single"));
    rooms.push_back(new DoubleRoom(201, "Priya & Raj",   3, false));
    rooms.push_back(new DoubleRoom(202, "Vikram Family", 2, true));
    rooms.push_back(new Suite     (301, "Rahul Mehta",   4, true,  15));
    rooms.push_back(new Suite     (302, "Anita Singh",   2, false,  8));

    cout << "Calling display() via Room* pointers (Runtime Polymorphism):\n";
    cout << string(75, '-') << "\n";
    cout << left
         << setw(8)  << "Room"
         << setw(14) << "Type"
         << setw(22) << "Guest"
         << setw(8)  << "Nights"
         << setw(14) << "Details"
         << "Total Cost"
         << "\n";
    cout << string(75, '-') << "\n";

    double grandTotal = 0;
    for (const Room *r : rooms) {
        r->display();            /* Correct derived class method called! */
        grandTotal += r->calculateCost();
    }

    cout << string(75, '=') << "\n";
    cout << "Grand Total: Rs " << grandTotal << "\n";

    /* Clean up heap memory – virtual destructor ensures correct deletion */
    for (Room *r : rooms) delete r;
    rooms.clear();
}

/* =====================================================
   GENERATE without_virtual.txt
   Shows what happens WITHOUT virtual keyword
   ===================================================== */
void generateWithoutVirtualFile() {
    ofstream f("without_virtual.txt");
    if (!f) { cout << "Cannot create without_virtual.txt\n"; return; }

    f << "================================================================\n";
    f << "SESSION 5 | WITHOUT VIRTUAL – Static Binding Demo\n";
    f << "================================================================\n\n";

    f << "Code Fragment (WITHOUT virtual keyword):\n";
    f << "-------------------------------------------\n";
    f << "class Room {\n";
    f << "public:\n";
    f << "    double calculateCost() const {  // NOT virtual\n";
    f << "        return 1000.0 * nights;     // base rate\n";
    f << "    }\n";
    f << "};\n";
    f << "class Suite : public Room {\n";
    f << "public:\n";
    f << "    double calculateCost() const {  // hides base method\n";
    f << "        return 6000.0 * nights;     // suite rate\n";
    f << "    }\n";
    f << "};\n\n";

    f << "Test Code:\n";
    f << "    Suite s(301, \"Rahul\", 4, true, 15);\n";
    f << "    Room *r = &s;          // base pointer to derived object\n";
    f << "    cout << r->calculateCost();\n\n";

    f << "ACTUAL OUTPUT without virtual:\n";
    f << "    4000.00               <-- Room::calculateCost() called!\n";
    f << "    (1000 x 4 nights = 4000 – WRONG! Should be 24000)\n\n";

    f << "EXPLANATION:\n";
    f << "    Without 'virtual', function binding happens at COMPILE TIME\n";
    f << "    (called STATIC BINDING or EARLY BINDING).\n";
    f << "    The compiler sees Room* type, so calls Room::calculateCost().\n";
    f << "    It does NOT look at the actual object type (Suite) at runtime.\n";
    f << "    Result: WRONG function called, WRONG cost calculated!\n\n";

    f << "PROBLEM in Hotel System:\n";
    f << "    If we loop: for(Room* r : rooms) total += r->calculateCost();\n";
    f << "    WITHOUT virtual: ALL rooms charged at base rate (Rs 1000/night)\n";
    f << "    WITH    virtual: Each room type charged at its correct rate\n\n";

    f << "SOLUTION: Use 'virtual' keyword → see with_virtual.txt\n\n";

    f << "================================================================\n";
    f << "END OF WITHOUT VIRTUAL DEMO\n";
    f << "================================================================\n";

    f.close();
    cout << "\n  ✓ without_virtual.txt generated.\n";
}

/* =====================================================
   GENERATE with_virtual.txt
   Shows the correct behavior WITH virtual keyword
   ===================================================== */
void generateWithVirtualFile() {
    ofstream f("with_virtual.txt");
    if (!f) { cout << "Cannot create with_virtual.txt\n"; return; }

    f << "================================================================\n";
    f << "SESSION 5 | WITH VIRTUAL – Dynamic Binding Demo\n";
    f << "================================================================\n\n";

    f << "Code Fragment (WITH virtual keyword):\n";
    f << "-------------------------------------------\n";
    f << "class Room {\n";
    f << "public:\n";
    f << "    virtual double calculateCost() const = 0;  // pure virtual\n";
    f << "};\n";
    f << "class Suite : public Room {\n";
    f << "public:\n";
    f << "    double calculateCost() const override {\n";
    f << "        return (5000.0 + (hasJacuzzi ? 1000.0 : 0.0)) * nights;\n";
    f << "    }\n";
    f << "};\n\n";

    f << "Test Code:\n";
    f << "    Suite s(301, \"Rahul\", 4, true, 15);\n";
    f << "    Room *r = &s;         // base pointer to derived object\n";
    f << "    cout << r->calculateCost();\n\n";

    f << "ACTUAL OUTPUT with virtual:\n";
    f << "    24000.00              <-- Suite::calculateCost() called!\n";
    f << "    ((5000 + 1000) x 4 nights = 24000 – CORRECT!)\n\n";

    f << "EXPLANATION:\n";
    f << "    With 'virtual', function binding happens at RUNTIME\n";
    f << "    (called DYNAMIC BINDING or LATE BINDING).\n";
    f << "    C++ uses a vtable (virtual function table) internally.\n";
    f << "    At runtime, the vptr (virtual pointer) in the object\n";
    f << "    points to the correct vtable entry for the actual type.\n";
    f << "    So Suite::calculateCost() is correctly called via Room*.\n\n";

    f << "POLYMORPHISM IN ACTION:\n";
    f << "    Room* rooms[] = { new SingleRoom(...), new DoubleRoom(...), new Suite(...) };\n";
    f << "    for (Room* r : rooms) {\n";
    f << "        r->display();          // calls correct display() for each type\n";
    f << "        r->calculateCost();    // calls correct cost for each type\n";
    f << "    }\n\n";

    f << "EXPECTED OUTPUT (Polymorphic Cost Calculation):\n";
    f << "    Room 101  Single Room  Aarav Sharma  2 nights  Rs 3000\n";
    f << "    Room 102  Single Room  Neha Patel    1 night   Rs 1500\n";
    f << "    Room 201  Double Room  Priya & Raj   3 nights  Rs 7500\n";
    f << "    Room 202  Double Room  Vikram Family 2 nights  Rs 6000\n";
    f << "    Room 301  Suite        Rahul Mehta   4 nights  Rs 24000\n";
    f << "    Room 302  Suite        Anita Singh   2 nights  Rs 10000\n";
    f << "    Grand Total: Rs 52000\n\n";

    f << "KEY TERMS:\n";
    f << "  virtual     : enables runtime polymorphism\n";
    f << "  = 0         : makes it a pure virtual function\n";
    f << "  override    : confirms we're overriding a virtual function\n";
    f << "  abstract    : a class with at least one pure virtual function\n";
    f << "  vtable      : table of virtual function pointers (per class)\n";
    f << "  vptr        : pointer to vtable stored in each object\n";
    f << "  virtual ~   : virtual destructor needed for correct deletion\n\n";

    f << "================================================================\n";
    f << "END OF WITH VIRTUAL DEMO\n";
    f << "================================================================\n";

    f.close();
    cout << "  ✓ with_virtual.txt generated.\n";
}

/* =====================================================
   INTERACTIVE HOTEL BOOKING MENU
   ===================================================== */
void interactiveMenu() {
    vector<Room*> rooms;
    int choice;

    do {
        cout << "\n--- HOTEL BOOKING MENU (Polymorphism) ---\n";
        cout << "  1. Add Single Room Booking\n";
        cout << "  2. Add Double Room Booking\n";
        cout << "  3. Add Suite Booking\n";
        cout << "  4. Display All Bookings (Polymorphic)\n";
        cout << "  5. Exit\n";
        cout << "Enter choice: ";
        cin >> choice;
        cin.ignore();

        string guest, bed;
        int roomNo, nights, floor;
        bool extra, jacuzzi;
        char yn;

        switch (choice) {
            case 1:
                cout << "  Room No: "; cin >> roomNo; cin.ignore();
                cout << "  Guest  : "; getline(cin, guest);
                cout << "  Nights : "; cin >> nights; cin.ignore();
                cout << "  Bed (Single/Queen): "; getline(cin, bed);
                rooms.push_back(new SingleRoom(roomNo, guest, nights, bed));
                cout << "  ✓ Single Room booked.\n";
                break;

            case 2:
                cout << "  Room No    : "; cin >> roomNo; cin.ignore();
                cout << "  Guest      : "; getline(cin, guest);
                cout << "  Nights     : "; cin >> nights;
                cout << "  Extra bed? : "; cin >> yn; cin.ignore();
                rooms.push_back(new DoubleRoom(roomNo, guest, nights,
                                               yn=='y'||yn=='Y'));
                cout << "  ✓ Double Room booked.\n";
                break;

            case 3:
                cout << "  Room No   : "; cin >> roomNo; cin.ignore();
                cout << "  Guest     : "; getline(cin, guest);
                cout << "  Nights    : "; cin >> nights;
                cout << "  Jacuzzi?  : "; cin >> yn;
                cout << "  Floor     : "; cin >> floor; cin.ignore();
                rooms.push_back(new Suite(roomNo, guest, nights,
                                          yn=='y'||yn=='Y', floor));
                cout << "  ✓ Suite booked.\n";
                break;

            case 4: {
                if (rooms.empty()) { cout << "  No bookings yet.\n"; break; }
                cout << "\n" << string(70, '=') << "\n";
                cout << left << setw(8) << "Room" << setw(14) << "Type"
                     << setw(22) << "Guest" << setw(8) << "Nights"
                     << setw(14) << "Details" << "Cost\n";
                cout << string(70, '-') << "\n";
                double total = 0;
                for (const Room *r : rooms) {
                    r->display();
                    total += r->calculateCost();
                }
                cout << string(70, '=') << "\n";
                cout << "Grand Total: Rs " << total << "\n";
                break;
            }

            case 5:
                cout << "\nClosing Hotel System.\n";
                break;

            default:
                cout << "  Invalid choice!\n";
        }
    } while (choice != 5);

    /* Free heap memory */
    for (Room *r : rooms) delete r;
}

/* =====================================================
   MAIN
   ===================================================== */
int main() {
    cout << "====================================================\n";
    cout << "   HOTEL BOOKING SYSTEM – Polymorphism (C++)        \n";
    cout << "====================================================\n";

    /* Generate text comparison files */
    generateWithoutVirtualFile();
    generateWithVirtualFile();

    /* Demo polymorphism */
    demonstratePolymorphism();

    /* Interactive menu */
    cout << "\n--- Interactive Booking ---\n";
    interactiveMenu();

    return 0;
}
