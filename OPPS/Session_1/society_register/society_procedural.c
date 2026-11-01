/*
 * ============================================================
 * Session 1 | Task 1: Procedural Society Registration System
 * Language  : C
 * Concepts  : Procedural Programming, Global Arrays, Functions,
 *             Structs, scanf/printf, Loops, Switch-Case
 * File      : society_procedural.c
 * Folder    : Session_1/society_register/
 * ============================================================
 *
 * EXPLANATION:
 * This program demonstrates the PROCEDURAL approach to building a
 * society member registration system. In procedural style:
 *   - Data is stored in separate global arrays (names, flatNumbers, ownerIds).
 *   - Functions operate ON that global data from outside.
 *   - There is no concept of binding data + functions together.
 * This is contrasted later in Session 1 Task 2 with the OOP approach.
 *
 * EXPECTED OUTPUT:
 * ================================================
 * === SOCIETY REGISTRATION SYSTEM (Procedural) ===
 * --- MENU ---
 * 1. Add Member
 * 2. Display All Members
 * 3. Search by Name
 * 4. Exit
 * Enter your choice: 1
 * Enter Name: Aarav
 * Enter Flat Number: 101
 * Enter Owner ID: 1001
 * Member added successfully!
 * ...
 * Name                 Flat No         Owner ID
 * ----                 -------         --------
 * Aarav                101             1001
 * ================================================
 */

#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <ctype.h>

#define MAX_MEMBERS 50

/* -------------------------------------------------------
   GLOBAL DATA ARRAYS (Procedural: data lives separately)
   ------------------------------------------------------- */
char   names[MAX_MEMBERS][50];
int    flatNumbers[MAX_MEMBERS];
long long ownerIds[MAX_MEMBERS];
int    totalMembers = 0;

/* -------------------------------------------------------
   FUNCTION DECLARATIONS
   ------------------------------------------------------- */
void addMember(void);
void displayAll(void);
void searchByName(const char *searchName);
void displayMenu(void);
void clearInputBuffer(void);

/* =====================================================
   MAIN FUNCTION
   ===================================================== */
int main(void) {
    int  choice;
    char searchName[50];

    printf("=================================================\n");
    printf("  SOCIETY REGISTRATION SYSTEM  (Procedural - C) \n");
    printf("=================================================\n");

    do {
        displayMenu();
        printf("Enter your choice: ");
        if (scanf("%d", &choice) != 1) {
            clearInputBuffer();
            choice = -1;
        }
        clearInputBuffer();

        switch (choice) {
            case 1:
                addMember();
                break;
            case 2:
                displayAll();
                break;
            case 3:
                printf("Enter name to search: ");
                fgets(searchName, sizeof(searchName), stdin);
                /* remove trailing newline */
                searchName[strcspn(searchName, "\n")] = '\0';
                searchByName(searchName);
                break;
            case 4:
                printf("\nGoodbye! Exiting Society Register.\n");
                break;
            default:
                printf("Invalid choice! Please enter 1-4.\n");
        }
    } while (choice != 4);

    return 0;
}

/* =====================================================
   DISPLAY MENU
   ===================================================== */
void displayMenu(void) {
    printf("\n--- MENU ---\n");
    printf("1. Add Member\n");
    printf("2. Display All Members\n");
    printf("3. Search Member by Name\n");
    printf("4. Exit\n");
}

/* =====================================================
   ADD MEMBER – stores data in global arrays
   ===================================================== */
void addMember(void) {
    if (totalMembers >= MAX_MEMBERS) {
        printf("Society register is full! Cannot add more members.\n");
        return;
    }

    printf("\n--- Add New Member ---\n");
    printf("Enter Owner Name   : ");
    fgets(names[totalMembers], 50, stdin);
    names[totalMembers][strcspn(names[totalMembers], "\n")] = '\0';

    printf("Enter Flat Number  : ");
    scanf("%d", &flatNumbers[totalMembers]);
    clearInputBuffer();

    printf("Enter Owner ID     : ");
    scanf("%lld", &ownerIds[totalMembers]);
    clearInputBuffer();

    totalMembers++;
    printf("Member added successfully! (Total: %d)\n", totalMembers);
}

/* =====================================================
   DISPLAY ALL MEMBERS
   ===================================================== */
void displayAll(void) {
    int i;
    if (totalMembers == 0) {
        printf("\nNo members registered yet.\n");
        return;
    }

    printf("\n=================================================\n");
    printf("           REGISTERED SOCIETY MEMBERS           \n");
    printf("=================================================\n");
    printf("%-5s %-20s %-12s %-15s\n", "S.No", "Name", "Flat No", "Owner ID");
    printf("%-5s %-20s %-12s %-15s\n", "----", "----", "-------", "--------");

    for (i = 0; i < totalMembers; i++) {
        printf("%-5d %-20s %-12d %-15lld\n",
               i + 1,
               names[i],
               flatNumbers[i],
               ownerIds[i]);
    }
    printf("=================================================\n");
    printf("Total Members: %d\n", totalMembers);
}

/* =====================================================
   SEARCH BY NAME (case-insensitive on Windows)
   ===================================================== */
void searchByName(const char *searchName) {
    int i, found = 0;

    /* Convert search term to lowercase for comparison */
    char lowerSearch[50];
    char lowerStored[50];
    int  j;

    for (j = 0; searchName[j]; j++)
        lowerSearch[j] = (char)tolower((unsigned char)searchName[j]);
    lowerSearch[j] = '\0';

    printf("\n--- Search Results for \"%s\" ---\n", searchName);

    for (i = 0; i < totalMembers; i++) {
        for (j = 0; names[i][j]; j++)
            lowerStored[j] = (char)tolower((unsigned char)names[i][j]);
        lowerStored[j] = '\0';

        if (strcmp(lowerStored, lowerSearch) == 0) {
            printf("Found! --> Name: %-20s | Flat: %-6d | ID: %lld\n",
                   names[i], flatNumbers[i], ownerIds[i]);
            found = 1;
        }
    }

    if (!found)
        printf("No member found with name \"%s\".\n", searchName);
}

/* =====================================================
   CLEAR INPUT BUFFER UTILITY
   ===================================================== */
void clearInputBuffer(void) {
    int c;
    while ((c = getchar()) != '\n' && c != EOF);
}
