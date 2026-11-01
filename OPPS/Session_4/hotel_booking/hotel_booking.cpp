/*
 * ============================================================
 * Session 4 | Task 1: Inheritance – Hotel Booking System
 * Language  : C++
 * Concepts  : Single Inheritance, Multi-level Inheritance,
 *             Base Class, Derived Classes, 'protected' access,
 *             Constructor Chaining (base class constructors),
 *             Method Overriding (without virtual), 'is-a' relationship
 * File      : hotel_booking.cpp
 * Folder    : Session_4/hotel_booking/
 * ============================================================
 *
 * EXPLANATION:
 * This program builds a Hotel Booking System using INHERITANCE.
 *
 * Inheritance means: a DERIVED class gets all the properties and
 * behaviors of a BASE class. "A Suite IS-A Room" → Suite inherits Room.
 *
 * CLASS HIERARCHY:
 *   Room (Base)
 *     ├── SingleRoom  (Derived – inherits Room)
 *     ├── DoubleRoom  (Derived – inherits Room)
 *     └── Suite       (Derived – inherits Room)
 *
 * Room has common data: roomNumber, guestName, isBooked
 * Derived classes add their own data:
 *   SingleRoom → bedSize (string)
 *   DoubleRoom → extraBed (bool)
 *   Suite      → hasJacuzzi (bool), floorLevel (int)
 *
 * EXPECTED OUTPUT:
 * ============================
 * HOTEL BOOKING – Inheritance Demo
 * [Room 101 SingleRoom booked for Aarav at Rs 1500/night]
 * [Room 201 DoubleRoom booked for Priya at Rs 2500/night]
 * [Room 301 Suite      booked for Rahul at Rs 5000/night]
 * [Display shows all bookings with room-specific details]
 * ============================
 */

#include <iostream>
#include <iomanip>
#include <string>
#include <vector>
using namespace std;

/* =====================================================
   BASE CLASS: Room
   Contains common data for ALL room types.
   ===================================================== */
class Room {
protected:
    /* 'protected' = accessible in this class and derived classes */
    int    roomNumber;
    string guestName;
    int    nights;
    bool   isBooked;

public:
    /* Base class constructor */
    Room() : roomNumber(0), guestName(""), nights(0), isBooked(false) {}

    Room(int rNo, const string &gName, int n)
        : roomNumber(rNo), guestName(gName), nights(n), isBooked(true) {}

    /* Base class destructor (virtual for proper cleanup) */
    virtual ~Room() {}

    /* Getters */
    int    getRoomNo()   const { return roomNumber; }
    string getGuest()    const { return guestName;  }
    int    getNights()   const { return nights;     }
    bool   getBooked()   const { return isBooked;   }

    /* Setters */
    void setRoomNo(int n)           { roomNumber = n; }
    void setGuest(const string &g)  { guestName  = g; }
    void setNights(int n)           { nights     = n; }
    void book()                     { isBooked   = true;  }
    void unbook()                   { isBooked   = false; }

    /* Base rate (to be overridden by derived classes) */
    virtual double calculateCost() const {
        return 1000.0 * nights;  // base rate
    }

    /* Display (to be overridden) */
    virtual void display() const {
        cout << left
             << setw(8)  << roomNumber
             << setw(20) << guestName
             << setw(8)  << nights
             << setw(12) << (isBooked ? "Booked" : "Free")
             << setw(12) << calculateCost()
             << "\n";
    }

    /* Print room type label */
    virtual string getRoomType() const { return "Room"; }
};

/* =====================================================
   DERIVED CLASS 1: SingleRoom (inherits Room)
   "SingleRoom IS-A Room" with a bed size option.
   ===================================================== */
class SingleRoom : public Room {
private:
    string bedSize;   // "Single" or "Queen"

public:
    /* Default Constructor */
    SingleRoom() : Room(), bedSize("Single") {}

    /* Parameterized Constructor – calls base class constructor */
    SingleRoom(int rNo, const string &guest, int n, const string &bed = "Single")
        : Room(rNo, guest, n), bedSize(bed) {}

    /* Rate: Rs 1500/night for SingleRoom */
    double calculateCost() const override {
        return 1500.0 * nights;
    }

    string getRoomType() const override { return "Single Room"; }

    void display() const override {
        cout << left
             << setw(8)  << roomNumber
             << setw(14) << getRoomType()
             << setw(20) << guestName
             << setw(8)  << nights
             << setw(12) << bedSize
             << "Rs " << calculateCost()
             << "\n";
    }

    string getBedSize() const { return bedSize; }
};

/* =====================================================
   DERIVED CLASS 2: DoubleRoom (inherits Room)
   "DoubleRoom IS-A Room" with optional extra bed.
   ===================================================== */
class DoubleRoom : public Room {
private:
    bool extraBed;   // extra bed for third person?

public:
    DoubleRoom() : Room(), extraBed(false) {}

    DoubleRoom(int rNo, const string &guest, int n, bool extra = false)
        : Room(rNo, guest, n), extraBed(extra) {}

    /* Rate: Rs 2500/night, Rs 500 extra if extra bed */
    double calculateCost() const override {
        return (2500.0 + (extraBed ? 500.0 : 0.0)) * nights;
    }

    string getRoomType() const override { return "Double Room"; }

    void display() const override {
        cout << left
             << setw(8)  << roomNumber
             << setw(14) << getRoomType()
             << setw(20) << guestName
             << setw(8)  << nights
             << setw(12) << (extraBed ? "Extra Bed" : "Standard")
             << "Rs " << calculateCost()
             << "\n";
    }

    bool hasExtraBed() const { return extraBed; }
};

/* =====================================================
   DERIVED CLASS 3: Suite (inherits Room)
   "Suite IS-A Room" with jacuzzi and floor level.
   ===================================================== */
class Suite : public Room {
private:
    bool hasJacuzzi;
    int  floorLevel;

public:
    Suite() : Room(), hasJacuzzi(false), floorLevel(1) {}

    Suite(int rNo, const string &guest, int n, bool jacuzzi, int floor)
        : Room(rNo, guest, n), hasJacuzzi(jacuzzi), floorLevel(floor) {}

    /* Rate: Rs 5000/night, Rs 1000 extra for jacuzzi */
    double calculateCost() const override {
        return (5000.0 + (hasJacuzzi ? 1000.0 : 0.0)) * nights;
    }

    string getRoomType() const override { return "Suite"; }

    void display() const override {
        cout << left
             << setw(8)  << roomNumber
             << setw(14) << getRoomType()
             << setw(20) << guestName
             << setw(8)  << nights
             << setw(12) << (hasJacuzzi ? "Jacuzzi" : "No Jacuzzi")
             << "Rs " << calculateCost()
             << " | Floor " << floorLevel
             << "\n";
    }

    bool getJacuzzi() const  { return hasJacuzzi; }
    int  getFloor()   const  { return floorLevel;  }
};

/* =====================================================
   CLASS: Hotel
   Manages all room bookings using inheritance
   ===================================================== */
class Hotel {
private:
    string hotelName;

    /* Vectors for each room type */
    vector<SingleRoom> singleRooms;
    vector<DoubleRoom> doubleRooms;
    vector<Suite>      suites;

    void printHeader() const {
        cout << "\n" << string(80, '=') << "\n";
        cout << "  " << hotelName << " – Room Bookings\n";
        cout << string(80, '=') << "\n";
        cout << left
             << setw(8)  << "Room No"
             << setw(14) << "Type"
             << setw(20) << "Guest Name"
             << setw(8)  << "Nights"
             << setw(12) << "Details"
             << "Total Cost"
             << "\n";
        cout << string(80, '-') << "\n";
    }

public:
    Hotel(const string &name) : hotelName(name) {
        cout << "\n[Hotel '" << name << "' system initialized.]\n";
    }

    /* Book a Single Room */
    void bookSingle(int roomNo, const string &guest, int nights, const string &bed) {
        singleRooms.push_back(SingleRoom(roomNo, guest, nights, bed));
        cout << "  ✓ Single Room " << roomNo << " booked for "
             << guest << " (" << nights << " nights)\n";
    }

    /* Book a Double Room */
    void bookDouble(int roomNo, const string &guest, int nights, bool extra) {
        doubleRooms.push_back(DoubleRoom(roomNo, guest, nights, extra));
        cout << "  ✓ Double Room " << roomNo << " booked for "
             << guest << " (" << nights << " nights)\n";
    }

    /* Book a Suite */
    void bookSuite(int roomNo, const string &guest, int nights, bool jacuzzi, int floor) {
        suites.push_back(Suite(roomNo, guest, nights, jacuzzi, floor));
        cout << "  ✓ Suite " << roomNo << " booked for "
             << guest << " (" << nights << " nights)\n";
    }

    /* Display all bookings */
    void displayAll() const {
        printHeader();

        for (const auto &r : singleRooms) r.display();
        for (const auto &r : doubleRooms) r.display();
        for (const auto &r : suites)      r.display();

        cout << string(80, '=') << "\n";

        /* Calculate grand total */
        double total = 0;
        for (const auto &r : singleRooms) total += r.calculateCost();
        for (const auto &r : doubleRooms) total += r.calculateCost();
        for (const auto &r : suites)      total += r.calculateCost();
        cout << "  Grand Total Revenue: Rs " << total << "\n";
    }

    /* Total number of bookings */
    int totalBookings() const {
        return (int)(singleRooms.size() + doubleRooms.size() + suites.size());
    }
};

/* =====================================================
   INTERACTIVE BOOKING MENU
   ===================================================== */
void interactiveMenu(Hotel &hotel) {
    int choice;
    do {
        cout << "\n--- HOTEL BOOKING MENU ---\n";
        cout << "  1. Book Single Room\n";
        cout << "  2. Book Double Room\n";
        cout << "  3. Book Suite\n";
        cout << "  4. Display All Bookings\n";
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
                cout << "  Room Number: "; cin >> roomNo; cin.ignore();
                cout << "  Guest Name : "; getline(cin, guest);
                cout << "  Nights     : "; cin >> nights; cin.ignore();
                cout << "  Bed Size (Single/Queen): "; getline(cin, bed);
                hotel.bookSingle(roomNo, guest, nights, bed);
                break;

            case 2:
                cout << "  Room Number    : "; cin >> roomNo; cin.ignore();
                cout << "  Guest Name     : "; getline(cin, guest);
                cout << "  Nights         : "; cin >> nights;
                cout << "  Extra bed? (y/n): "; cin >> yn;
                cin.ignore();
                hotel.bookDouble(roomNo, guest, nights, (yn == 'y' || yn == 'Y'));
                break;

            case 3:
                cout << "  Room Number   : "; cin >> roomNo; cin.ignore();
                cout << "  Guest Name    : "; getline(cin, guest);
                cout << "  Nights        : "; cin >> nights;
                cout << "  Jacuzzi? (y/n): "; cin >> yn;
                cout << "  Floor Level   : "; cin >> floor;
                cin.ignore();
                hotel.bookSuite(roomNo, guest, nights,
                                (yn == 'y' || yn == 'Y'), floor);
                break;

            case 4:
                hotel.displayAll();
                break;

            case 5:
                cout << "\nThank you! Closing Hotel System.\n";
                break;

            default:
                cout << "  Invalid choice!\n";
        }
    } while (choice != 5);
}

/* =====================================================
   MAIN
   ===================================================== */
int main() {
    cout << "====================================================\n";
    cout << "  HOTEL BOOKING SYSTEM – Inheritance Demo (C++)     \n";
    cout << "====================================================\n";

    Hotel hotel("Grand Palace Hotel");

    /* Pre-load demo data to show inheritance in action */
    cout << "\n--- Demo: Auto-booking sample rooms ---\n";
    hotel.bookSingle(101, "Aarav Sharma",  2, "Queen");
    hotel.bookSingle(102, "Neha Patel",    1, "Single");
    hotel.bookDouble(201, "Priya & Raj",   3, false);
    hotel.bookDouble(202, "Vikram Family", 2, true);
    hotel.bookSuite (301, "Rahul Mehta",   4, true,  15);
    hotel.bookSuite (302, "Anita Singh",   2, false,  8);

    hotel.displayAll();

    /* Now run interactive mode */
    cout << "\n--- Interactive Booking ---\n";
    interactiveMenu(hotel);

    return 0;
}
