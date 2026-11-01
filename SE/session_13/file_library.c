/*
 * Session 13 - File Handling, library.txt, library_log.txt,
 *              Persistence, and Menu Operations
 * File: file_library.c
 * Compile: gcc -Wall -o file_library file_library.c
 */

#include <stdio.h>
#include <string.h>
#include <time.h>

#define MAX_BOOKS 10
#define TITLE_LEN 50
#define AUTHOR_LEN 30
#define NAME_LEN  30
#define LIBRARY_FILE "library.txt"
#define LOG_FILE     "library_log.txt"

typedef struct {
    int  book_id;
    char title[TITLE_LEN];
    char author[AUTHOR_LEN];
    int  is_issued;
    char issued_to[NAME_LEN];
    int  days_overdue;
} Book;

Book books[MAX_BOOKS];
int  book_count = 0;

/* Write log entry */
void write_log(const char *action, const char *book_title, const char *person) {
    FILE *fp = fopen(LOG_FILE, "a");
    if (!fp) { printf("Cannot open log file.\n"); return; }
    time_t t = time(NULL);
    struct tm *tm_info = localtime(&t);
    char timestamp[30];
    strftime(timestamp, sizeof(timestamp), "%Y-%m-%d %H:%M:%S", tm_info);
    fprintf(fp, "[%s] %s | Book: %s | Person: %s\n",
            timestamp, action, book_title, person);
    fclose(fp);
}

/* Save books to library.txt */
void save_library(void) {
    FILE *fp = fopen(LIBRARY_FILE, "w");
    if (!fp) { printf("Cannot open library file.\n"); return; }
    fprintf(fp, "%d\n", book_count);
    int i;
    for (i = 0; i < book_count; i++) {
        fprintf(fp, "%d|%s|%s|%d|%s|%d\n",
                books[i].book_id,
                books[i].title,
                books[i].author,
                books[i].is_issued,
                books[i].issued_to,
                books[i].days_overdue);
    }
    fclose(fp);
    printf("Library saved to %s.\n", LIBRARY_FILE);
}

/* Load books from library.txt */
void load_library(void) {
    FILE *fp = fopen(LIBRARY_FILE, "r");
    if (!fp) {
        printf("No existing library file. Starting fresh.\n");
        return;
    }
    fscanf(fp, "%d\n", &book_count);
    int i;
    for (i = 0; i < book_count; i++) {
        fscanf(fp, "%d|%49[^|]|%29[^|]|%d|%29[^|]|%d\n",
               &books[i].book_id,
               books[i].title,
               books[i].author,
               &books[i].is_issued,
               books[i].issued_to,
               &books[i].days_overdue);
    }
    fclose(fp);
    printf("Library loaded from %s (%d books).\n", LIBRARY_FILE, book_count);
}

void display_books(void) {
    int i;
    printf("\n--- Library Book Register ---\n");
    printf("%-5s %-35s %-20s %-10s %-15s %-8s\n",
           "ID", "Title", "Author", "Status", "Issued To", "Overdue");
    printf("------------------------------------------------------------------------\n");
    for (i = 0; i < book_count; i++) {
        printf("%-5d %-35s %-20s %-10s %-15s %-8d\n",
               books[i].book_id,
               books[i].title,
               books[i].author,
               books[i].is_issued ? "Issued" : "Available",
               books[i].is_issued ? books[i].issued_to : "-",
               books[i].days_overdue);
    }
    printf("\n");
}

int find_book(int id) {
    int i;
    for (i = 0; i < book_count; i++) {
        if (books[i].book_id == id) return i;
    }
    return -1;
}

void issue_book_menu(void) {
    int id;
    char student[NAME_LEN];
    printf("Enter Book ID to issue: ");
    scanf("%d", &id);
    getchar();
    int idx = find_book(id);
    if (idx == -1) { printf("Book not found.\n"); return; }
    if (books[idx].is_issued) { printf("Already issued.\n"); return; }
    printf("Enter student name: ");
    fgets(student, NAME_LEN, stdin);
    student[strcspn(student, "\n")] = '\0';
    books[idx].is_issued = 1;
    strncpy(books[idx].issued_to, student, NAME_LEN - 1);
    books[idx].issued_to[NAME_LEN - 1] = '\0';
    books[idx].days_overdue = 0;
    printf("Book '%s' issued to %s.\n", books[idx].title, student);
    write_log("ISSUE", books[idx].title, student);
    save_library();
}

void return_book_menu(void) {
    int id;
    printf("Enter Book ID to return: ");
    scanf("%d", &id);
    getchar();
    int idx = find_book(id);
    if (idx == -1) { printf("Book not found.\n"); return; }
    if (!books[idx].is_issued) { printf("Not issued.\n"); return; }
    printf("Book '%s' returned by %s.\n", books[idx].title, books[idx].issued_to);
    write_log("RETURN", books[idx].title, books[idx].issued_to);
    books[idx].is_issued = 0;
    books[idx].issued_to[0] = '\0';
    books[idx].days_overdue = 0;
    save_library();
}

int main() {
    /* Seed initial data if no file */
    load_library();
    if (book_count == 0) {
        books[0] = (Book){101, "C Programming Language",  "Kernighan and Ritchie", 0, "", 0};
        books[1] = (Book){102, "Data Structures",          "Lipschutz",             0, "", 0};
        books[2] = (Book){103, "Operating Systems",        "Tanenbaum",             0, "", 0};
        books[3] = (Book){104, "Database Management",      "Navathe",               0, "", 0};
        books[4] = (Book){105, "Computer Networks",        "Forouzan",              0, "", 0};
        book_count = 5;
        save_library();
    }

    int choice;
    do {
        printf("\n--- File Library Menu ---\n");
        printf("1. Display Books\n");
        printf("2. Issue Book\n");
        printf("3. Return Book\n");
        printf("4. Save Library\n");
        printf("5. Exit\n");
        printf("Enter choice: ");
        scanf("%d", &choice);
        getchar();

        switch (choice) {
            case 1: display_books();     break;
            case 2: issue_book_menu();   break;
            case 3: return_book_menu();  break;
            case 4: save_library();      break;
            case 5: printf("Goodbye!\n"); break;
            default: printf("Invalid choice.\n");
        }
    } while (choice != 5);

    return 0;
}
