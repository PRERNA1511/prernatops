/*
 * ============================================================
 * Session 6 | Task 1: Encapsulation and Abstraction
 * Language  : C++
 * Concepts  : Encapsulation (private data + public getters/setters),
 *             Abstraction (hiding complexity, showing interface),
 *             Abstract Classes, Pure Virtual Functions,
 *             Friend Functions, Operator Overloading (<<),
 *             Data Validation in setters,
 *             Intentional access error demonstration
 * File      : hotel_booking.cpp
 * Folder    : Session_6/hotel_booking/
 * ============================================================
 *
 * EXPLANATION:
 *
 * ENCAPSULATION = Wrapping data and methods together + restricting access.
 *   - All data is PRIVATE.
 *   - Access only through PUBLIC getter/setter methods.
 *   - Setters VALIDATE the data before storing it.
 *   - Example: setNights(-5) is rejected; negative nights is invalid.
 *
 * ABSTRACTION = Hiding complex implementation, showing simple interface.
 *   - Users call calculateCost() without knowing the pricing formula.
 *   - Users call book() without knowing how the booking state is stored.
 *   - Abstract base class Room defines the INTERFACE.
 *   - Derived classes handle the IMPLEMENTATION details.
 *
 * This session also demonstrates:
 *   - What happens when you try to ACCESS PRIVATE MEMBERS directly
 *     (generates access_error.txt with the compiler error)
 *   - Restores correct working code afterward
 *
 * EXPECTED OUTPUT:
 *   Booking valid: nights set to 3
 *   ERROR: Invalid nights (-1 rejected)
 *   Suite 301 booked for Rahul, total cost Rs 24000
 */

#include <iostream>
#include <iomanip>
#include <string>
#include <fstream>
#include <vector>
#include <stdexcept>
using namespace std;

/* =====================================================
   ABSTRACT BASE CLASS: Room (with full encapsulation)
   ===================================================== */
class Room {
private:
    /* FULLY PRIVATE DATA – no direct access from anywhere outside */
    int    roomNumber;
    string guestName;
    int    nights;
    bool   isBooked;
    string bookingId;

protected:
    /* protected: derived classes can read, but not write directly */
    int    getNightsInternal() const { return nights; }
    bool   isBookedInternal()  const { return isBooked; }

public:
    /* CONSTRUCTOR with validation */
    Room() : roomNumber(0), guestName("Unassigned"), nights(0),
             isBooked(false), bookingId("") {}

    Room(int rNo, const string &guest, int n)
        : roomNumber(0), guestName(""), nights(0), isBooked(false) {
        setRoomNumber(rNo);
        setGuestName(guest);
        setNights(n);
        isBooked = true;
        bookingId = "BK" + to_string(rNo) + to_string(n);
    }

    virtual ~Room() {}

    /* ---- VALIDATED SETTERS (Encapsulation) ---- */

    void setRoomNumber(int n) {
        if (n <= 0 || n > 9999) {
            cerr << "  [ERROR] Invalid room number: " << n
                 << " (must be 1-9999)\n";
            return;
        }
        roomNumber = n;
    }

    void setGuestName(const string &name) {
        if (name.empty() || name.length() > 50) {
            cerr << "  [ERROR] Invalid guest name.\n";
            return;
        }
        guestName = name;
    }

    void setNights(int n) {
        if (n <= 0 || n > 365) {
            cerr << "  [VALIDATION FAILED] nights=" << n
                 << " rejected! Must be 1-365.\n";
            return;
        }
        nights  = n;
        isBooked = true;
        cout << "  [VALIDATION PASSED] nights set to " << n << "\n";
    }

    void book()   { isBooked = true;  }
    void unbook() { isBooked = false; }

    /* ---- GETTERS ---- */
    int    getRoomNumber() const { return roomNumber; }
    string getGuestName()  const { return guestName;  }
    int    getNights()     const { return nights;     }
    bool   getIsBooked()   const { return isBooked;   }
    string getBookingId()  const { return bookingId;  }

    /* ---- ABSTRACT INTERFACE (Pure Virtual) ---- */
    virtual double calculateCost()  const = 0;
    virtual string getRoomType()    const = 0;
    virtual string getExtraDetail() const = 0;

    /* ---- DISPLAY (uses getters only, never direct access) ---- */
    virtual void display() const {
        cout << left
             << setw(8)  << roomNumber
             << setw(14) << getRoomType()
             << setw(22) << guestName
             << setw(8)  << nights
             << setw(18) << getExtraDetail()
             << "Rs " << calculateCost()
             << "  [" << bookingId << "]\n";
    }

    /* ---- FRIEND FUNCTION for operator<< (controlled access) ---- */
    friend ostream& operator<<(ostream &os, const Room &r);
};

/* Operator overloading – friend has access to private data */
ostream& operator<<(ostream &os, const Room &r) {
    os << "Room[" << r.roomNumber << "] "
       << r.getRoomType() << " | Guest: " << r.guestName
       << " | Nights: " << r.nights
       << " | Cost: Rs " << r.calculateCost()
       << " | " << (r.isBooked ? "BOOKED" : "FREE");
    return os;
}

/* =====================================================
   DERIVED CLASS: SingleRoom
   ===================================================== */
class SingleRoom : public Room {
private:
    string bedSize;    /* private to SingleRoom */

public:
    SingleRoom() : Room(), bedSize("Single") {}

    SingleRoom(int rNo, const string &guest, int n, const string &bed = "Single")
        : Room(rNo, guest, n), bedSize(bed) {}

    /* Validated setter for bedSize */
    void setBedSize(const string &size) {
        if (size != "Single" && size != "Queen" && size != "King") {
            cerr << "  [ERROR] Invalid bed size: " << size << "\n";
            return;
        }
        bedSize = size;
    }

    double calculateCost()  const override { return 1500.0 * getNightsInternal(); }
    string getRoomType()    const override { return "Single Room"; }
    string getExtraDetail() const override { return "Bed: " + bedSize; }
};

/* =====================================================
   DERIVED CLASS: DoubleRoom
   ===================================================== */
class DoubleRoom : public Room {
private:
    bool extraBed;

public:
    DoubleRoom() : Room(), extraBed(false) {}

    DoubleRoom(int rNo, const string &guest, int n, bool extra = false)
        : Room(rNo, guest, n), extraBed(extra) {}

    void setExtraBed(bool val) { extraBed = val; }

    double calculateCost()  const override {
        return (2500.0 + (extraBed ? 500.0 : 0.0)) * getNightsInternal();
    }
    string getRoomType()    const override { return "Double Room"; }
    string getExtraDetail() const override {
        return extraBed ? "Extra Bed: YES" : "Extra Bed: NO";
    }
};

/* =====================================================
   DERIVED CLASS: Suite
   ===================================================== */
class Suite : public Room {
private:
    bool hasJacuzzi;
    int  floorLevel;

public:
    Suite() : Room(), hasJacuzzi(false), floorLevel(1) {}

    Suite(int rNo, const string &guest, int n, bool jacuzzi, int floor)
        : Room(rNo, guest, n), hasJacuzzi(jacuzzi), floorLevel(floor) {}

    void setJacuzzi(bool val) { hasJacuzzi = val; }
    void setFloor(int f) {
        if (f < 1 || f > 50) { cerr << "  [ERROR] Invalid floor.\n"; return; }
        floorLevel = f;
    }

    double calculateCost()  const override {
        return (5000.0 + (hasJacuzzi ? 1000.0 : 0.0)) * getNightsInternal();
    }
    string getRoomType()    const override { return "Suite"; }
    string getExtraDetail() const override {
        return (hasJacuzzi ? "Jacuzzi Fl" : "No Jac Fl") +
               to_string(floorLevel);
    }
};

/* =====================================================
   GENERATE access_error.txt
   Shows compiler error when trying to access private data
   ===================================================== */
void generateAccessErrorFile() {
    ofstream f("access_error.txt");
    if (!f) { cout << "Cannot create access_error.txt\n"; return; }

    f << "================================================================\n";
    f << "SESSION 6 | ACCESS ERROR – Private Member Access Attempt\n";
    f << "================================================================\n\n";

    f << "INTENTIONAL ERROR CODE (DO NOT COMPILE as-is):\n";
    f << "-------------------------------------------\n";
    f << "#include <iostream>\n";
    f << "using namespace std;\n\n";
    f << "class Room {\n";
    f << "private:\n";
    f << "    int    roomNumber;   // private!\n";
    f << "    string guestName;    // private!\n";
    f << "    int    nights;       // private!\n";
    f << "public:\n";
    f << "    Room(int r, string g, int n) : roomNumber(r),\n";
    f << "         guestName(g), nights(n) {}\n";
    f << "};\n\n";
    f << "int main() {\n";
    f << "    Room r(101, \"Aarav\", 3);\n";
    f << "\n";
    f << "    // ILLEGAL: Trying to access private members directly\n";
    f << "    cout << r.roomNumber;  // ERROR LINE 1\n";
    f << "    cout << r.guestName;   // ERROR LINE 2\n";
    f << "    r.nights = -1;         // ERROR LINE 3\n";
    f << "    return 0;\n";
    f << "}\n\n";

    f << "COMPILER ERROR OUTPUT (g++ -Wall):\n";
    f << "-------------------------------------------\n";
    f << "error: 'int Room::roomNumber' is private within this context\n";
    f << "       cout << r.roomNumber;  // ERROR LINE 1\n";
    f << "                 ^~~~~~~~~~\n";
    f << "note: declared private here\n";
    f << "    int roomNumber;\n";
    f << "        ^~~~~~~~~~\n\n";
    f << "error: 'std::string Room::guestName' is private within this context\n";
    f << "       cout << r.guestName;   // ERROR LINE 2\n";
    f << "                 ^~~~~~~~~\n";
    f << "note: declared private here\n";
    f << "    string guestName;\n";
    f << "           ^~~~~~~~~\n\n";
    f << "error: 'int Room::nights' is private within this context\n";
    f << "       r.nights = -1;         // ERROR LINE 3\n";
    f << "         ^~~~~~~\n\n";
    f << "3 errors generated.\n\n";

    f << "WHAT THIS PROVES:\n";
    f << "-------------------------------------------\n";
    f << "  ✓ Private data cannot be accessed from outside the class.\n";
    f << "  ✓ The compiler enforces encapsulation at compile time.\n";
    f << "  ✓ Only public methods (getters/setters) can access private data.\n";
    f << "  ✓ Setters can validate data before accepting it.\n\n";

    f << "CORRECT WAY (using public getters/setters):\n";
    f << "-------------------------------------------\n";
    f << "    Room r(101, \"Aarav\", 3);\n";
    f << "    cout << r.getRoomNumber();   // OK – uses getter\n";
    f << "    cout << r.getGuestName();    // OK – uses getter\n";
    f << "    r.setNights(5);              // OK – uses validated setter\n";
    f << "    r.setNights(-1);             // Rejected by setter (validation)\n\n";

    f << "BENEFITS OF ENCAPSULATION:\n";
    f << "  1. DATA SECURITY: private data cannot be corrupted accidentally\n";
    f << "  2. VALIDATION: setters check data before storing\n";
    f << "  3. FLEXIBILITY: internal implementation can change without\n";
    f << "     affecting external code using getters/setters\n";
    f << "  4. ABSTRACTION: users only see the interface, not internals\n\n";

    f << "================================================================\n";
    f << "END OF ACCESS ERROR DEMO – Session 6\n";
    f << "================================================================\n";

    f.close();
    cout << "\n  ✓ access_error.txt generated.\n";
}

/* =====================================================
   ENCAPSULATION DEMONSTRATION
   ===================================================== */
void demonstrateEncapsulation() {
    cout << "\n============================================\n";
    cout << "   ENCAPSULATION & ABSTRACTION DEMO         \n";
    cout << "============================================\n\n";

    cout << "-- Test 1: Valid data --\n";
    Suite s1(301, "Rahul Mehta", 4, true, 15);

    cout << "\n-- Test 2: Invalid nights (should be rejected) --\n";
    Suite s2;
    s2.setNights(-1);    // Rejected by validated setter
    s2.setNights(400);   // Rejected (> 365)
    s2.setNights(3);     // Accepted

    cout << "\n-- Test 3: Operator<< via friend function --\n";
    cout << s1 << "\n";

    cout << "\n-- Test 4: Abstraction (calculateCost without knowing formula) --\n";
    vector<Room*> rooms = {
        new SingleRoom(101, "Aarav", 2, "Queen"),
        new DoubleRoom(201, "Priya", 3, false),
        new Suite(301, "Rahul", 4, true, 15)
    };

    double total = 0;
    for (const Room *r : rooms) {
        cout << "  " << r->getRoomType() << " Room " << r->getRoomNumber()
             << ": Rs " << r->calculateCost() << "\n";
        total += r->calculateCost();
    }
    cout << "  Grand Total: Rs " << total << "\n";
    for (Room *r : rooms) delete r;
}

/* =====================================================
   INTERACTIVE MENU
   ===================================================== */
void menu() {
    vector<Room*> rooms;
    int choice;

    do {
        cout << "\n--- HOTEL MENU (Encapsulation & Abstraction) ---\n";
        cout << "  1. Book Single Room\n";
        cout << "  2. Book Double Room\n";
        cout << "  3. Book Suite\n";
        cout << "  4. Display All\n";
        cout << "  5. Exit\n";
        cout << "Choice: ";
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
                cout << "  Bed (Single/Queen/King): "; getline(cin, bed);
                rooms.push_back(new SingleRoom(roomNo, guest, nights, bed));
                break;

            case 2:
                cout << "  Room No    : "; cin >> roomNo; cin.ignore();
                cout << "  Guest      : "; getline(cin, guest);
                cout << "  Nights     : "; cin >> nights;
                cout << "  Extra bed? : "; cin >> yn; cin.ignore();
                rooms.push_back(new DoubleRoom(roomNo, guest, nights, yn=='y'));
                break;

            case 3:
                cout << "  Room No   : "; cin >> roomNo; cin.ignore();
                cout << "  Guest     : "; getline(cin, guest);
                cout << "  Nights    : "; cin >> nights;
                cout << "  Jacuzzi?  : "; cin >> yn;
                cout << "  Floor     : "; cin >> floor; cin.ignore();
                rooms.push_back(new Suite(roomNo, guest, nights, yn=='y', floor));
                break;

            case 4: {
                if (rooms.empty()) { cout << "  No bookings.\n"; break; }
                cout << "\n" << string(80, '=') << "\n";
                cout << left << setw(8) << "Room" << setw(14) << "Type"
                     << setw(22) << "Guest" << setw(8) << "Nights"
                     << setw(18) << "Details" << "Cost\n";
                cout << string(80, '-') << "\n";
                double total = 0;
                for (const Room *r : rooms) {
                    r->display();
                    total += r->calculateCost();
                }
                cout << string(80, '=') << "\n";
                cout << "Grand Total: Rs " << total << "\n";
                break;
            }

            case 5: cout << "\nExiting.\n"; break;
            default: cout << "  Invalid!\n";
        }
    } while (choice != 5);

    for (Room *r : rooms) delete r;
}

/* =====================================================
   MAIN
   ===================================================== */
int main() {
    cout << "====================================================\n";
    cout << "  HOTEL BOOKING – Encapsulation & Abstraction (C++) \n";
    cout << "====================================================\n";

    generateAccessErrorFile();
    demonstrateEncapsulation();

    cout << "\n--- Interactive Booking ---\n";
    menu();

    return 0;
}
