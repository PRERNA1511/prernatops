/*
 * ============================================================
 * Session 7 | Task 1: File Handling – Cricket Scorecard
 * Language  : C++
 * Concepts  : File I/O (fstream, ifstream, ofstream),
 *             Text File Reading and Writing,
 *             Structured Data Persistence,
 *             File Parsing, Search in File,
 *             Append Mode, Error Handling for Files,
 *             Structured Classes with File Integration
 * File      : cricket_scorecard.cpp
 * Folder    : Session_7/cricket_scorecard/
 * ============================================================
 *
 * EXPLANATION:
 * This program implements a Cricket Scorecard system with FILE HANDLING.
 *
 * FILE HANDLING in C++ uses:
 *   ofstream → output file stream (write)
 *   ifstream → input file stream (read)
 *   fstream  → both read and write
 *
 * The program:
 *   1. Allows user to enter match details (teams, scores, result)
 *   2. SAVES match data to matches.txt
 *   3. READS and displays all matches from matches.txt
 *   4. Searches matches by team name
 *   5. Appends new matches without overwriting old data
 *
 * matches.txt format (one match per block):
 *   ---MATCH---
 *   MatchID: M001
 *   Team1: India
 *   Team2: Australia
 *   Score1: 287
 *   Score2: 265
 *   Overs1: 50.0
 *   Overs2: 48.3
 *   Winner: India
 *   Venue: Mumbai
 *   Date: 2024-01-15
 *   ---END---
 *
 * EXPECTED OUTPUT:
 *   Match saved to matches.txt
 *   [Display shows all matches from file]
 *   Search for "India": 2 matches found
 */

#include <iostream>
#include <iomanip>
#include <fstream>
#include <sstream>
#include <string>
#include <vector>
#include <algorithm>
#include <cctype>
using namespace std;

/* =====================================================
   STRUCT/CLASS: Match
   Holds all data for one cricket match
   ===================================================== */
class Match {
private:
    string matchId;
    string team1;
    string team2;
    int    score1;
    int    score2;
    double overs1;
    double overs2;
    string winner;
    string venue;
    string date;

public:
    /* Default Constructor */
    Match() : score1(0), score2(0), overs1(0.0), overs2(0.0) {}

    /* Parameterized Constructor */
    Match(const string &id, const string &t1, const string &t2,
          int s1, int s2, double o1, double o2,
          const string &win, const string &ven, const string &dt)
        : matchId(id), team1(t1), team2(t2),
          score1(s1), score2(s2), overs1(o1), overs2(o2),
          winner(win), venue(ven), date(dt) {}

    /* Setters */
    void setMatchId(const string &s) { matchId = s; }
    void setTeam1(const string &s)   { team1   = s; }
    void setTeam2(const string &s)   { team2   = s; }
    void setScore1(int n)             { score1  = n; }
    void setScore2(int n)             { score2  = n; }
    void setOvers1(double n)          { overs1  = n; }
    void setOvers2(double n)          { overs2  = n; }
    void setWinner(const string &s)   { winner  = s; }
    void setVenue(const string &s)    { venue   = s; }
    void setDate(const string &s)     { date    = s; }

    /* Getters */
    string getMatchId() const { return matchId; }
    string getTeam1()   const { return team1;   }
    string getTeam2()   const { return team2;   }
    int    getScore1()  const { return score1;  }
    int    getScore2()  const { return score2;  }
    double getOvers1()  const { return overs1;  }
    double getOvers2()  const { return overs2;  }
    string getWinner()  const { return winner;  }
    string getVenue()   const { return venue;   }
    string getDate()    const { return date;    }

    /* Display match details in console */
    void display() const {
        cout << "\n  " << string(60, '-') << "\n";
        cout << "  Match ID : " << matchId << "  | Date : " << date << "\n";
        cout << "  Venue    : " << venue   << "\n";
        cout << "  " << string(60, '-') << "\n";
        cout << "  " << left << setw(25) << team1
             << setw(10) << score1
             << "(" << fixed << setprecision(1) << overs1 << " overs)\n";
        cout << "  " << left << setw(25) << team2
             << setw(10) << score2
             << "(" << fixed << setprecision(1) << overs2 << " overs)\n";
        cout << "  " << string(60, '-') << "\n";

        if (winner == "Draw" || winner == "draw") {
            cout << "  Result   : Match Drawn\n";
        } else {
            int diff = abs(score1 - score2);
            cout << "  Winner   : " << winner
                 << " (by " << diff << " runs)\n";
        }
        cout << "  " << string(60, '-') << "\n";
    }

    /* Write match to file */
    void writeToFile(ofstream &f) const {
        f << "---MATCH---\n";
        f << "MatchID: " << matchId << "\n";
        f << "Team1: "   << team1   << "\n";
        f << "Team2: "   << team2   << "\n";
        f << "Score1: "  << score1  << "\n";
        f << "Score2: "  << score2  << "\n";
        f << "Overs1: "  << fixed << setprecision(1) << overs1 << "\n";
        f << "Overs2: "  << fixed << setprecision(1) << overs2 << "\n";
        f << "Winner: "  << winner  << "\n";
        f << "Venue: "   << venue   << "\n";
        f << "Date: "    << date    << "\n";
        f << "---END---\n\n";
    }

    /* Read match from file */
    bool readFromFile(ifstream &f) {
        string line;
        /* Find ---MATCH--- marker */
        while (getline(f, line)) {
            if (line == "---MATCH---") break;
            if (f.eof()) return false;
        }
        if (f.eof()) return false;

        auto getValue = [](const string &line) -> string {
            size_t pos = line.find(": ");
            if (pos == string::npos) return "";
            return line.substr(pos + 2);
        };

        while (getline(f, line) && line != "---END---") {
            if (line.substr(0, 8) == "MatchID:")  matchId = getValue(line);
            else if (line.substr(0, 5) == "Team1:") team1  = getValue(line);
            else if (line.substr(0, 5) == "Team2:") team2  = getValue(line);
            else if (line.substr(0, 6) == "Score1:") score1 = stoi(getValue(line));
            else if (line.substr(0, 6) == "Score2:") score2 = stoi(getValue(line));
            else if (line.substr(0, 6) == "Overs1:") overs1 = stod(getValue(line));
            else if (line.substr(0, 6) == "Overs2:") overs2 = stod(getValue(line));
            else if (line.substr(0, 6) == "Winner:") winner = getValue(line);
            else if (line.substr(0, 5) == "Venue:") venue  = getValue(line);
            else if (line.substr(0, 4) == "Date:")  date   = getValue(line);
        }
        return true;
    }

    /* Check if match involves a given team */
    bool involvesTeam(const string &teamName) const {
        string lower1 = team1, lower2 = team2, lowerQ = teamName;
        for (char &c : lower1) c = tolower((unsigned char)c);
        for (char &c : lower2) c = tolower((unsigned char)c);
        for (char &c : lowerQ) c = tolower((unsigned char)c);
        return (lower1.find(lowerQ) != string::npos ||
                lower2.find(lowerQ) != string::npos);
    }
};

/* =====================================================
   CLASS: Scorecard
   Manages all cricket matches with file I/O
   ===================================================== */
class Scorecard {
private:
    static const string FILENAME;
    int matchCounter;

    /* Get the next match ID */
    string getNextMatchId() {
        matchCounter++;
        ostringstream ss;
        ss << "M" << setfill('0') << setw(3) << matchCounter;
        return ss.str();
    }

    /* Count existing matches in file */
    int countMatchesInFile() {
        ifstream f(FILENAME);
        if (!f.is_open()) return 0;
        int count = 0;
        string line;
        while (getline(f, line))
            if (line == "---MATCH---") count++;
        f.close();
        return count;
    }

public:
    Scorecard() {
        matchCounter = countMatchesInFile();
        cout << "\n[Scorecard initialized. Existing matches: "
             << matchCounter << "]\n";
    }

    /* ---- INPUT: Enter a new match ---- */
    void addMatch() {
        cout << "\n--- Add New Cricket Match ---\n";

        string t1, t2, winner, venue, date;
        int s1, s2;
        double o1, o2;

        cout << "  Team 1 Name     : "; cin.ignore(); getline(cin, t1);
        cout << "  Team 2 Name     : "; getline(cin, t2);
        cout << "  Team 1 Score    : "; cin >> s1;
        cout << "  Team 2 Score    : "; cin >> s2;
        cout << "  Team 1 Overs    : "; cin >> o1;
        cout << "  Team 2 Overs    : "; cin >> o2;
        cin.ignore();
        cout << "  Winner (or Draw): "; getline(cin, winner);
        cout << "  Venue           : "; getline(cin, venue);
        cout << "  Date (YYYY-MM-DD): "; getline(cin, date);

        string id = getNextMatchId();
        Match m(id, t1, t2, s1, s2, o1, o2, winner, venue, date);

        /* WRITE to file (append mode) */
        ofstream f(FILENAME, ios::app);
        if (!f.is_open()) {
            cout << "  ERROR: Cannot open " << FILENAME << " for writing!\n";
            return;
        }
        m.writeToFile(f);
        f.close();

        cout << "\n  ✓ Match " << id << " saved to " << FILENAME << "\n";
        m.display();
    }

    /* ---- READ: Display all matches from file ---- */
    void displayAll() const {
        ifstream f(FILENAME);
        if (!f.is_open()) {
            cout << "\n  ERROR: " << FILENAME << " not found or cannot be opened.\n";
            cout << "  (Add a match first.)\n";
            return;
        }

        cout << "\n============================================\n";
        cout << "        ALL CRICKET MATCHES SCORECARD       \n";
        cout << "============================================\n";

        Match m;
        int count = 0;
        while (m.readFromFile(f)) {
            m.display();
            count++;
        }
        f.close();

        if (count == 0)
            cout << "  No matches found in " << FILENAME << ".\n";
        else
            cout << "\n  Total Matches Displayed: " << count << "\n";
    }

    /* ---- SEARCH: Find matches by team name ---- */
    void searchByTeam() const {
        string query;
        cout << "\n  Enter team name to search: ";
        cin.ignore();
        getline(cin, query);

        ifstream f(FILENAME);
        if (!f.is_open()) {
            cout << "  ERROR: " << FILENAME << " not found.\n";
            return;
        }

        cout << "\n  Search Results for \"" << query << "\":\n";
        int found = 0;
        Match m;
        while (m.readFromFile(f)) {
            if (m.involvesTeam(query)) {
                m.display();
                found++;
            }
        }
        f.close();

        if (found == 0)
            cout << "  No matches found for \"" << query << "\".\n";
        else
            cout << "\n  Found " << found << " match(es) for \"" << query << "\".\n";
    }

    /* ---- LOAD sample matches into file ---- */
    void loadSampleData() {
        /* Check if file already has data */
        if (countMatchesInFile() > 0) {
            cout << "  [Info] matches.txt already has data. Skipping sample load.\n";
            return;
        }

        ofstream f(FILENAME, ios::app);
        if (!f.is_open()) {
            cout << "  ERROR: Cannot create " << FILENAME << "\n";
            return;
        }

        /* Write file header */
        f << "================================================================\n";
        f << "CRICKET SCORECARD – Session 7 File Handling\n";
        f << "Generated by: cricket_scorecard.cpp\n";
        f << "================================================================\n\n";
        f.close();

        vector<Match> samples = {
            Match("M001", "India",     "Australia", 287, 265, 50.0, 48.3,
                  "India",     "Wankhede Stadium, Mumbai",    "2024-01-15"),
            Match("M002", "England",   "Pakistan",  245, 212, 50.0, 44.2,
                  "England",   "Lord's Cricket Ground, London","2024-02-20"),
            Match("M003", "India",     "England",   310, 308, 50.0, 50.0,
                  "India",     "Eden Gardens, Kolkata",       "2024-03-10"),
            Match("M004", "Australia", "New Zealand",275, 278, 49.5, 50.0,
                  "New Zealand","MCG, Melbourne",             "2024-04-05"),
            Match("M005", "Pakistan",  "Sri Lanka", 198, 201, 38.4, 40.0,
                  "Sri Lanka", "Gaddafi Stadium, Lahore",     "2024-05-12")
        };

        ofstream fa(FILENAME, ios::app);
        for (const Match &m : samples) {
            m.writeToFile(fa);
            matchCounter++;
        }
        fa.close();

        cout << "  ✓ " << samples.size() << " sample matches saved to " << FILENAME << "\n";
    }
};

/* Initialize static const member */
const string Scorecard::FILENAME = "matches.txt";

/* =====================================================
   MAIN
   ===================================================== */
int main() {
    cout << "====================================================\n";
    cout << "     CRICKET SCORECARD SYSTEM – File Handling (C++)\n";
    cout << "====================================================\n";

    Scorecard sc;

    /* Load sample data on first run */
    sc.loadSampleData();

    int choice;
    do {
        cout << "\n--- CRICKET SCORECARD MENU ---\n";
        cout << "  1. Add New Match\n";
        cout << "  2. Display All Matches\n";
        cout << "  3. Search by Team Name\n";
        cout << "  4. Exit\n";
        cout << "Enter choice: ";
        cin >> choice;

        switch (choice) {
            case 1: sc.addMatch();     break;
            case 2: sc.displayAll();   break;
            case 3: sc.searchByTeam(); break;
            case 4: cout << "\nGoodbye! Scorecard closed.\n"; break;
            default: cout << "  Invalid choice!\n";
        }
    } while (choice != 4);

    return 0;
}
