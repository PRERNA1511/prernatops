/*
 * ================================================================
 * MINI PROJECT 2: Hardware Inventory Management System
 * Language  : C++
 * Concepts  : ALL OOP Concepts Combined:
 *             - Classes and Objects
 *             - Constructors and Destructors
 *             - Inheritance (Item → HardwareItem)
 *             - Polymorphism (virtual functions)
 *             - Encapsulation (private data, validated setters)
 *             - Abstraction (abstract base class)
 *             - File Handling (inventory.txt persistence)
 *             - STL (vector, sort, algorithm)
 *             - Exception Handling (try-catch)
 * File      : inventory.cpp
 * Folder    : Mini_Project_2/hardware_inventory/
 * ================================================================
 *
 * EXPLANATION:
 * This is a complete Hardware Inventory Management System that
 * combines ALL concepts from Sessions 1-7 into one program.
 *
 * The system manages inventory for a computer hardware shop:
 *   - Add hardware items (CPU, RAM, GPU, SSD, etc.)
 *   - View all inventory with formatted table
 *   - Search items by name or category
 *   - Update item quantity or price
 *   - Delete an item by ID
 *   - Calculate total inventory value
 *   - Save all data to inventory.txt (persists between runs)
 *   - Load data from inventory.txt on startup
 *   - Generate inventory report
 *
 * INHERITANCE HIERARCHY:
 *   Item (Abstract Base)
 *     └── HardwareItem (Concrete Derived)
 *           └── [Specific types tracked via category field]
 *
 * EXPECTED OUTPUT:
 *   [Loads from file: X items found]
 *   HARDWARE INVENTORY MENU
 *   [Full CRUD operations with file persistence]
 *   Total Inventory Value: Rs XXXXX
 *
 * ================================================================
 */

#include <iostream>
#include <iomanip>
#include <fstream>
#include <sstream>
#include <string>
#include <vector>
#include <algorithm>
#include <stdexcept>
#include <cctype>
using namespace std;

/* ================================================================
   ABSTRACT BASE CLASS: Item
   Defines the interface for any inventory item.
   ================================================================ */
class Item {
protected:
    int    itemId;
    string itemName;
    double price;
    int    quantity;

public:
    Item() : itemId(0), itemName(""), price(0.0), quantity(0) {}

    Item(int id, const string &name, double p, int qty)
        : itemId(id), itemName(name), price(p), quantity(qty) {}

    virtual ~Item() {}

    /* ---- Pure virtual interface ---- */
    virtual string getCategory()    const = 0;
    virtual void   display()        const = 0;
    virtual void   writeToFile(ofstream &f) const = 0;

    /* ---- Validated setters ---- */
    void setPrice(double p) {
        if (p < 0) throw invalid_argument("Price cannot be negative.");
        price = p;
    }

    void setQuantity(int q) {
        if (q < 0) throw invalid_argument("Quantity cannot be negative.");
        quantity = q;
    }

    void setName(const string &n) {
        if (n.empty()) throw invalid_argument("Name cannot be empty.");
        itemName = n;
    }

    /* ---- Getters ---- */
    int    getId()       const { return itemId;   }
    string getName()     const { return itemName; }
    double getPrice()    const { return price;    }
    int    getQuantity() const { return quantity; }

    /* ---- Computed value ---- */
    double getTotalValue() const { return price * quantity; }

    /* ---- Search helpers ---- */
    bool matchesName(const string &query) const {
        string lName = itemName, lQuery = query;
        for (char &c : lName)  c = tolower((unsigned char)c);
        for (char &c : lQuery) c = tolower((unsigned char)c);
        return lName.find(lQuery) != string::npos;
    }

    bool matchesCategory(const string &cat) const {
        string lCat = getCategory(), lQ = cat;
        for (char &c : lCat) c = tolower((unsigned char)c);
        for (char &c : lQ)   c = tolower((unsigned char)c);
        return lCat.find(lQ) != string::npos;
    }
};

/* ================================================================
   DERIVED CLASS: HardwareItem
   Represents a specific computer hardware product.
   ================================================================ */
class HardwareItem : public Item {
private:
    string category;     // CPU, RAM, GPU, SSD, HDD, Monitor, etc.
    string brand;
    string specs;        // e.g., "Intel Core i9-14900K, 5.8GHz"
    string warrantyYears;

    static int nextId;   // Auto-increment ID

public:
    /* Default Constructor */
    HardwareItem()
        : Item(), category("Misc"), brand("Unknown"),
          specs(""), warrantyYears("1 year") {}

    /* Parameterized Constructor */
    HardwareItem(const string &name, const string &cat, const string &br,
                 double p, int qty, const string &sp, const string &warranty)
        : Item(nextId++, name, p, qty),
          category(cat), brand(br), specs(sp), warrantyYears(warranty) {}

    /* Constructor for file loading (with existing ID) */
    HardwareItem(int id, const string &name, const string &cat, const string &br,
                 double p, int qty, const string &sp, const string &warranty)
        : Item(id, name, p, qty),
          category(cat), brand(br), specs(sp), warrantyYears(warranty) {
        if (id >= nextId) nextId = id + 1;
    }

    /* Setters */
    void setCategory(const string &c) { category     = c; }
    void setBrand(const string &b)    { brand        = b; }
    void setSpecs(const string &s)    { specs        = s; }
    void setWarranty(const string &w) { warrantyYears = w; }

    /* Getters */
    string getCategory()  const override { return category;      }
    string getBrand()     const          { return brand;         }
    string getSpecs()     const          { return specs;         }
    string getWarranty()  const          { return warrantyYears; }

    /* ---- Display in table row (polymorphic) ---- */
    void display() const override {
        cout << left
             << setw(6)  << itemId
             << setw(25) << itemName
             << setw(12) << category
             << setw(16) << brand
             << setw(10) << quantity
             << "Rs " << right << setw(10) << fixed << setprecision(2) << price
             << "  |  Rs " << setw(12) << getTotalValue()
             << "\n";
    }

    /* ---- Display detailed card ---- */
    void displayDetail() const {
        cout << "\n  " << string(65, '=') << "\n";
        cout << "  ITEM ID   : " << itemId   << "\n";
        cout << "  Name      : " << itemName << "\n";
        cout << "  Category  : " << category << "\n";
        cout << "  Brand     : " << brand    << "\n";
        cout << "  Specs     : " << specs    << "\n";
        cout << "  Warranty  : " << warrantyYears << "\n";
        cout << "  Quantity  : " << quantity << " units\n";
        cout << "  Unit Price: Rs " << fixed << setprecision(2) << price << "\n";
        cout << "  Stock Val : Rs " << fixed << setprecision(2) << getTotalValue() << "\n";
        cout << "  " << string(65, '=') << "\n";
    }

    /* ---- Write to file ---- */
    void writeToFile(ofstream &f) const override {
        f << "---ITEM---\n";
        f << "ID: "       << itemId       << "\n";
        f << "Name: "     << itemName     << "\n";
        f << "Category: " << category     << "\n";
        f << "Brand: "    << brand        << "\n";
        f << "Price: "    << fixed << setprecision(2) << price << "\n";
        f << "Quantity: " << quantity     << "\n";
        f << "Specs: "    << specs        << "\n";
        f << "Warranty: " << warrantyYears << "\n";
        f << "---END---\n\n";
    }

    /* ---- Read from file (static factory) ---- */
    static HardwareItem* readFromFile(ifstream &f) {
        string line;
        /* Find marker */
        while (getline(f, line)) {
            if (line == "---ITEM---") break;
            if (f.eof()) return nullptr;
        }
        if (f.eof()) return nullptr;

        int    id = 0, qty = 0;
        double p  = 0;
        string name, cat, brand, specs, warranty;

        auto getValue = [](const string &ln) -> string {
            size_t pos = ln.find(": ");
            return (pos == string::npos) ? "" : ln.substr(pos + 2);
        };

        while (getline(f, line) && line != "---END---") {
            if      (line.rfind("ID:",       0) == 0) id      = stoi(getValue(line));
            else if (line.rfind("Name:",     0) == 0) name    = getValue(line);
            else if (line.rfind("Category:", 0) == 0) cat     = getValue(line);
            else if (line.rfind("Brand:",    0) == 0) brand   = getValue(line);
            else if (line.rfind("Price:",    0) == 0) p       = stod(getValue(line));
            else if (line.rfind("Quantity:", 0) == 0) qty     = stoi(getValue(line));
            else if (line.rfind("Specs:",    0) == 0) specs   = getValue(line);
            else if (line.rfind("Warranty:", 0) == 0) warranty = getValue(line);
        }

        if (name.empty()) return nullptr;
        return new HardwareItem(id, name, cat, brand, p, qty, specs, warranty);
    }
};

/* Initialize static ID counter */
int HardwareItem::nextId = 1001;

/* ================================================================
   CLASS: Inventory
   Full CRUD + file operations for hardware inventory
   ================================================================ */
class Inventory {
private:
    static const string FILENAME;
    vector<Item*>  items;      // polymorphic: base class pointers
    string shopName;

    /* ---- File: save all ---- */
    void saveToFile() const {
        ofstream f(FILENAME);
        if (!f.is_open()) {
            cerr << "  ERROR: Cannot save to " << FILENAME << "\n";
            return;
        }
        f << "================================================================\n";
        f << "HARDWARE INVENTORY – " << shopName << "\n";
        f << "Generated by: inventory.cpp (Mini Project 2)\n";
        f << "Total Items: " << items.size() << "\n";
        f << "================================================================\n\n";

        for (const Item *it : items)
            it->writeToFile(f);

        f.close();
        cout << "  ✓ Inventory saved to " << FILENAME
             << " (" << items.size() << " items)\n";
    }

    /* ---- File: load all ---- */
    void loadFromFile() {
        ifstream f(FILENAME);
        if (!f.is_open()) {
            cout << "  [Info] No existing inventory file found. Starting fresh.\n";
            return;
        }

        int count = 0;
        while (!f.eof()) {
            HardwareItem *item = HardwareItem::readFromFile(f);
            if (item) {
                items.push_back(item);
                count++;
            }
        }
        f.close();

        if (count > 0)
            cout << "  ✓ Loaded " << count << " items from " << FILENAME << "\n";
        else
            cout << "  [Info] File found but no valid items loaded.\n";
    }

    /* ---- Find item by ID ---- */
    int findById(int id) const {
        for (int i = 0; i < (int)items.size(); i++)
            if (items[i]->getId() == id) return i;
        return -1;
    }

    /* ---- Print table header ---- */
    void printHeader() const {
        cout << "\n" << string(95, '=') << "\n";
        cout << "  " << shopName << " – Hardware Inventory\n";
        cout << string(95, '=') << "\n";
        cout << left
             << setw(6)  << "ID"
             << setw(25) << "Item Name"
             << setw(12) << "Category"
             << setw(16) << "Brand"
             << setw(10) << "Qty"
             << setw(14) << "Unit Price"
             << "Stock Value"
             << "\n";
        cout << string(95, '-') << "\n";
    }

public:
    /* Constructor */
    Inventory(const string &name) : shopName(name) {
        cout << "\n[Inventory System: " << name << " initialized]\n";
        loadFromFile();
    }

    /* Destructor – save and free heap memory */
    ~Inventory() {
        saveToFile();
        for (Item *it : items) delete it;
        items.clear();
        cout << "[Inventory system closed. All data saved.]\n";
    }

    /* ---- ADD new hardware item ---- */
    void addItem() {
        cout << "\n--- Add New Hardware Item ---\n";

        string name, cat, brand, specs, warranty;
        double price;
        int    qty;

        cout << "  Item Name    : "; cin.ignore(); getline(cin, name);
        cout << "  Category     : "; getline(cin, cat);
        cout << "  Brand        : "; getline(cin, brand);
        cout << "  Specifications: "; getline(cin, specs);
        cout << "  Warranty     : "; getline(cin, warranty);
        cout << "  Unit Price   : Rs "; cin >> price;
        cout << "  Quantity     : "; cin >> qty;

        try {
            HardwareItem *item = new HardwareItem(name, cat, brand,
                                                  price, qty, specs, warranty);
            items.push_back(item);
            cout << "\n  ✓ Item added! ID: " << item->getId() << "\n";
            item->display();
        } catch (const invalid_argument &e) {
            cerr << "  ERROR: " << e.what() << "\n";
        }
        cin.ignore();
    }

    /* ---- DISPLAY all items ---- */
    void displayAll() const {
        if (items.empty()) {
            cout << "\n  Inventory is empty.\n";
            return;
        }

        printHeader();
        double grandTotal = 0;
        for (const Item *it : items) {
            it->display();
            grandTotal += it->getTotalValue();
        }
        cout << string(95, '=') << "\n";
        cout << right << setw(80) << "Grand Total Value: "
             << "Rs " << fixed << setprecision(2) << grandTotal << "\n";
        cout << "  Total Items: " << items.size() << "\n";
    }

    /* ---- SEARCH by name ---- */
    void searchByName() const {
        string query;
        cout << "\n  Search by name: ";
        cin.ignore();
        getline(cin, query);

        cout << "\n  Results for \"" << query << "\":\n";
        bool found = false;
        for (const Item *it : items) {
            if (it->matchesName(query)) {
                /* Polymorphic cast to display detail */
                const HardwareItem *hi = dynamic_cast<const HardwareItem*>(it);
                if (hi) hi->displayDetail();
                found = true;
            }
        }
        if (!found)
            cout << "  No items found matching \"" << query << "\".\n";
    }

    /* ---- SEARCH by category ---- */
    void searchByCategory() const {
        string query;
        cout << "\n  Search by category (CPU/RAM/GPU/SSD/etc.): ";
        cin.ignore();
        getline(cin, query);

        cout << "\n  Category: " << query << "\n";
        printHeader();
        int count = 0;
        double total = 0;
        for (const Item *it : items) {
            if (it->matchesCategory(query)) {
                it->display();
                total += it->getTotalValue();
                count++;
            }
        }
        cout << string(95, '=') << "\n";
        if (count == 0)
            cout << "  No items in category \"" << query << "\".\n";
        else {
            cout << "  Items: " << count
                 << "  | Category Total: Rs "
                 << fixed << setprecision(2) << total << "\n";
        }
    }

    /* ---- UPDATE item ---- */
    void updateItem() {
        int id;
        cout << "\n  Enter Item ID to update: ";
        cin >> id;

        int idx = findById(id);
        if (idx == -1) {
            cout << "  Item ID " << id << " not found.\n";
            return;
        }

        cout << "  What to update?\n";
        cout << "    1. Price\n";
        cout << "    2. Quantity\n";
        cout << "    3. Both\n";
        cout << "  Choice: ";
        int ch; cin >> ch;

        try {
            if (ch == 1 || ch == 3) {
                double newPrice;
                cout << "  New Price: Rs ";
                cin >> newPrice;
                items[idx]->setPrice(newPrice);
            }
            if (ch == 2 || ch == 3) {
                int newQty;
                cout << "  New Quantity: ";
                cin >> newQty;
                items[idx]->setQuantity(newQty);
            }
            cout << "  ✓ Item " << id << " updated.\n";
            items[idx]->display();
        } catch (const invalid_argument &e) {
            cerr << "  ERROR: " << e.what() << "\n";
        }
        cin.ignore();
    }

    /* ---- DELETE item ---- */
    void deleteItem() {
        int id;
        cout << "\n  Enter Item ID to delete: ";
        cin >> id;

        int idx = findById(id);
        if (idx == -1) {
            cout << "  Item ID " << id << " not found.\n";
            return;
        }

        cout << "  Deleting: ";
        items[idx]->display();
        cout << "  Confirm delete? (y/n): ";
        char c; cin >> c;
        if (c == 'y' || c == 'Y') {
            delete items[idx];
            items.erase(items.begin() + idx);
            cout << "  ✓ Item deleted.\n";
        } else {
            cout << "  Delete cancelled.\n";
        }
        cin.ignore();
    }

    /* ---- SORT by price ---- */
    void sortByPrice() {
        sort(items.begin(), items.end(),
             [](const Item *a, const Item *b) {
                 return a->getPrice() < b->getPrice();
             });
        cout << "  ✓ Sorted by Unit Price (ascending).\n";
        displayAll();
    }

    /* ---- SORT by quantity ---- */
    void sortByQuantity() {
        sort(items.begin(), items.end(),
             [](const Item *a, const Item *b) {
                 return a->getQuantity() < b->getQuantity();
             });
        cout << "  ✓ Sorted by Quantity (ascending).\n";
        displayAll();
    }

    /* ---- LOW STOCK ALERT ---- */
    void lowStockAlert(int threshold = 5) const {
        cout << "\n  --- LOW STOCK ALERT (< " << threshold << " units) ---\n";
        bool found = false;
        for (const Item *it : items) {
            if (it->getQuantity() < threshold) {
                it->display();
                found = true;
            }
        }
        if (!found)
            cout << "  All items have sufficient stock.\n";
    }

    /* ---- SUMMARY REPORT ---- */
    void generateReport() const {
        cout << "\n" << string(70, '=') << "\n";
        cout << "         INVENTORY SUMMARY REPORT\n";
        cout << "         " << shopName << "\n";
        cout << string(70, '=') << "\n";

        double totalValue  = 0;
        int    totalUnits  = 0;
        double mostExpensive = 0;
        string mostExpName;

        for (const Item *it : items) {
            totalValue  += it->getTotalValue();
            totalUnits  += it->getQuantity();
            if (it->getPrice() > mostExpensive) {
                mostExpensive = it->getPrice();
                mostExpName   = it->getName();
            }
        }

        cout << "  Total Distinct Items  : " << items.size() << "\n";
        cout << "  Total Units in Stock  : " << totalUnits << "\n";
        cout << "  Total Inventory Value : Rs "
             << fixed << setprecision(2) << totalValue << "\n";
        cout << "  Most Expensive Item   : " << mostExpName
             << " (Rs " << fixed << setprecision(2) << mostExpensive << ")\n";
        cout << string(70, '=') << "\n";
    }

    /* ---- PRELOAD SAMPLE DATA ---- */
    void loadSampleData() {
        if (!items.empty()) return;  // Don't overwrite loaded data

        vector<HardwareItem*> samples = {
            new HardwareItem("Intel Core i9-14900K", "CPU", "Intel",
                             42999, 15, "24-core, 5.8GHz, LGA1700", "3 years"),
            new HardwareItem("AMD Ryzen 9 7950X",    "CPU", "AMD",
                             38999, 8,  "16-core, 5.7GHz, AM5",     "3 years"),
            new HardwareItem("Corsair Vengeance 32GB","RAM", "Corsair",
                             8499,  20, "DDR5, 5600MHz, CL36",       "Lifetime"),
            new HardwareItem("Kingston Fury 16GB",    "RAM", "Kingston",
                             4299,  35, "DDR4, 3200MHz, CL16",       "Lifetime"),
            new HardwareItem("NVIDIA RTX 4090",       "GPU", "NVIDIA",
                             159999, 4, "24GB GDDR6X, 16384 CUDA",   "3 years"),
            new HardwareItem("AMD RX 7900 XTX",       "GPU", "AMD",
                             89999, 6, "24GB GDDR6, 6144 SP",        "3 years"),
            new HardwareItem("Samsung 990 Pro 1TB",   "SSD", "Samsung",
                             11999, 25, "NVMe PCIe 4.0, 7450MB/s",   "5 years"),
            new HardwareItem("WD Black 4TB",          "HDD", "Western Digital",
                             8999,  12, "7200 RPM, SATA 3",          "5 years"),
            new HardwareItem("LG 27GP950 4K",         "Monitor","LG",
                             54999, 5, "27\" 4K 144Hz IPS, 1ms",    "3 years"),
            new HardwareItem("Logitech MX Keys",      "Keyboard","Logitech",
                             9999,  3, "Wireless, Multi-device",     "1 year"),
        };

        for (HardwareItem *item : samples)
            items.push_back(item);

        cout << "  ✓ " << samples.size() << " sample hardware items loaded.\n";
    }
};

const string Inventory::FILENAME = "inventory.txt";

/* ================================================================
   MAIN MENU
   ================================================================ */
int main() {
    cout << "\n";
    cout << "  ╔══════════════════════════════════════════════════╗\n";
    cout << "  ║   HARDWARE INVENTORY MANAGEMENT SYSTEM (C++)    ║\n";
    cout << "  ║   Mini Project 2 – All OOP Concepts Combined    ║\n";
    cout << "  ╚══════════════════════════════════════════════════╝\n";

    Inventory inv("TechZone Hardware Store");

    /* Load sample data only if inventory is empty */
    inv.loadSampleData();

    int choice;
    do {
        cout << "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        cout << "   INVENTORY MENU\n";
        cout << "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        cout << "  1.  Add New Item\n";
        cout << "  2.  Display All Items\n";
        cout << "  3.  Search by Name\n";
        cout << "  4.  Search by Category\n";
        cout << "  5.  Update Item (Price/Quantity)\n";
        cout << "  6.  Delete Item\n";
        cout << "  7.  Sort by Price\n";
        cout << "  8.  Sort by Quantity\n";
        cout << "  9.  Low Stock Alert\n";
        cout << "  10. Inventory Summary Report\n";
        cout << "  11. Save to File\n";
        cout << "  0.  Exit\n";
        cout << "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        cout << "Enter choice: ";
        cin >> choice;

        switch (choice) {
            case 1:  inv.addItem();                break;
            case 2:  inv.displayAll();             break;
            case 3:  inv.searchByName();           break;
            case 4:  inv.searchByCategory();       break;
            case 5:  inv.updateItem();             break;
            case 6:  inv.deleteItem();             break;
            case 7:  inv.sortByPrice();            break;
            case 8:  inv.sortByQuantity();         break;
            case 9:  inv.lowStockAlert(5);         break;
            case 10: inv.generateReport();         break;
            case 11: cout << "  Saved.\n";         break;
            case 0:  cout << "\n  Thank you! Goodbye!\n"; break;
            default: cout << "  Invalid choice!\n";
        }
    } while (choice != 0);

    /* Destructor called automatically: saves to file */
    return 0;
}
