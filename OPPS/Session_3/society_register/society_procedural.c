/*
 * ============================================================
 * Session 3 | Task 3: society_procedural.c
 * Language  : C
 * Concepts  : Procedural approach reference (unchanged from Session 1)
 *             This file is kept in Session_3 for comparison with
 *             the OOP version that uses constructors and destructors.
 * File      : society_procedural.c
 * Folder    : Session_3/society_register/
 * ============================================================
 *
 * EXPLANATION:
 * This is the same procedural C program from Session 1.
 * In Session 3, we keep it for comparison with the OOP version
 * to show WHY constructors and destructors are important:
 *
 * Procedural C: No constructors – programmer must manually
 *               initialize all array slots. Easy to forget!
 *               No destructors – memory/resources not automatically freed.
 *
 * OOP C++:     Constructor called automatically when object is created.
 *              Destructor called automatically when object is destroyed.
 *              Lifecycle is managed by the language itself.
 */
#include <stdio.h>
#include <string.h>
#include <ctype.h>

#define MAX_MEMBERS 50

char   names[MAX_MEMBERS][50];
int    flatNumbers[MAX_MEMBERS];
long long ownerIds[MAX_MEMBERS];
int    totalMembers = 0;

void addMember(void);
void displayAll(void);
void clearInputBuffer(void);

int main(void) {
    int choice;
    printf("=================================================\n");
    printf("  SOCIETY REGISTRATION SYSTEM  (Procedural - C) \n");
    printf("=================================================\n");

    do {
        printf("\n--- MENU ---\n");
        printf("1. Add Member\n2. Display All\n3. Exit\nChoice: ");
        if (scanf("%d", &choice) != 1) { clearInputBuffer(); choice = -1; }
        clearInputBuffer();

        switch (choice) {
            case 1: addMember();  break;
            case 2: displayAll(); break;
            case 3: printf("Exiting...\n"); break;
            default: printf("Invalid!\n");
        }
    } while (choice != 3);
    return 0;
}

void addMember(void) {
    if (totalMembers >= MAX_MEMBERS) { printf("Full!\n"); return; }
    printf("Name: ");   fgets(names[totalMembers], 50, stdin);
    names[totalMembers][strcspn(names[totalMembers], "\n")] = '\0';
    printf("Flat No: "); scanf("%d",  &flatNumbers[totalMembers]);
    printf("ID: ");      scanf("%lld",&ownerIds[totalMembers]);
    clearInputBuffer();
    totalMembers++;
    printf("Added! Total: %d\n", totalMembers);
}

void displayAll(void) {
    int i;
    if (totalMembers == 0) { printf("No members.\n"); return; }
    printf("\n%-5s %-20s %-10s %-15s\n","S.No","Name","Flat","ID");
    for (i=0; i<totalMembers; i++)
        printf("%-5d %-20s %-10d %-15lld\n",i+1,names[i],flatNumbers[i],ownerIds[i]);
}

void clearInputBuffer(void) {
    int c; while ((c=getchar())!='\n' && c!=EOF);
}
