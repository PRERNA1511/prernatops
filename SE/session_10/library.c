/*
 * Session 10 - Strings, strlen, strcpy, strcmp,
 *              Book Search, Issuing, Returning, and Register Display
 * File: library.c
 * Compile: gcc -Wall -o library library.c
 */

#include <stdio.h>
#include <string.h>

#define MAX_BOOKS 10
#define TITLE_LEN 50
#define AUTHOR_LEN 30

/* Book register */
char titles[MAX_BOOKS][TITLE_LEN] = {
    "C Programming Language",
    "Data Structures",
    "Operating Systems",
    "Database Management",
    "Computer Networks",
    "", "", "", "", ""
};
char authors[MAX_BOOKS][AUTHOR_LEN] = {
    "Kernighan and Ritchie",
    "Lipschutz",
    "Tanenbaum",
    "Navathe",
    "Forouzan",
    "", "", "", "", ""
};
int issued[MAX_BOOKS] = {0, 0, 0, 0, 0, 0, 0, 0, 0, 0};
int book_count = 5;

void display_register(void) {
    int i;
    printf("\n--- Library Book Register ---\n");
    printf("%-4s %-40s %-25s %-8s\n", "No.", "Title", "Author", "Status");
    printf("----------------------------------------------------------------------\n");
    for (i = 0; i < book_count; i++) {
        printf("%-4d %-40s %-25s %-8s\n",
               i + 1,
               titles[i],
               authors[i],
               issued[i] ? "Issued" : "Available");
    }
    printf("\n");
}

int search_book(char *search_title) {
    int i;
    for (i = 0; i < book_count; i++) {
        if (strcmp(titles[i], search_title) == 0) {
            return i;
        }
    }
    return -1;
}

void issue_book(int idx) {
    if (issued[idx] == 1) {
        printf("Book '%s' is already issued.\n", titles[idx]);
    } else {
        issued[idx] = 1;
        printf("Book '%s' issued successfully.\n", titles[idx]);
    }
}

void return_book(int idx) {
    if (issued[idx] == 0) {
        printf("Book '%s' was not issued.\n", titles[idx]);
    } else {
        issued[idx] = 0;
        printf("Book '%s' returned successfully.\n", titles[idx]);
    }
}

int main() {
    int choice, idx;
    char input_title[TITLE_LEN];

    printf("Title length check: 'C Programming Language' has %lu characters.\n",
           (unsigned long)strlen("C Programming Language"));

    do {
        printf("\n--- Library Menu ---\n");
        printf("1. Display Book Register\n");
        printf("2. Search Book\n");
        printf("3. Issue Book\n");
        printf("4. Return Book\n");
        printf("5. Exit\n");
        printf("Enter choice: ");
        scanf("%d", &choice);
        getchar(); /* consume newline */

        switch (choice) {
            case 1:
                display_register();
                break;
            case 2:
                printf("Enter book title to search: ");
                fgets(input_title, TITLE_LEN, stdin);
                /* Remove trailing newline */
                input_title[strcspn(input_title, "\n")] = '\0';
                idx = search_book(input_title);
                if (idx == -1) {
                    printf("Book not found.\n");
                } else {
                    printf("Found: '%s' by %s - %s\n",
                           titles[idx], authors[idx],
                           issued[idx] ? "Issued" : "Available");
                }
                break;
            case 3:
                printf("Enter book title to issue: ");
                fgets(input_title, TITLE_LEN, stdin);
                input_title[strcspn(input_title, "\n")] = '\0';
                idx = search_book(input_title);
                if (idx == -1) {
                    printf("Book not found.\n");
                } else {
                    issue_book(idx);
                }
                break;
            case 4:
                printf("Enter book title to return: ");
                fgets(input_title, TITLE_LEN, stdin);
                input_title[strcspn(input_title, "\n")] = '\0';
                idx = search_book(input_title);
                if (idx == -1) {
                    printf("Book not found.\n");
                } else {
                    return_book(idx);
                }
                break;
            case 5:
                printf("Goodbye!\n");
                break;
            default:
                printf("Invalid choice.\n");
        }
    } while (choice != 5);

    return 0;
}
