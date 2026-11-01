/*
 * Session 12 - Structures, Nested Structures, Book Register,
 *              Issuing, Returning, and print_book
 * File: structures.c
 * Compile: gcc -Wall -o structures structures.c
 */

#include <stdio.h>
#include <string.h>

#define MAX_BOOKS 10
#define TITLE_LEN 50
#define AUTHOR_LEN 30
#define NAME_LEN  30

/* Nested structure: date */
typedef struct {
    int day;
    int month;
    int year;
} Date;

/* Book structure with nested Date */
typedef struct {
    int  book_id;
    char title[TITLE_LEN];
    char author[AUTHOR_LEN];
    int  is_issued;
    char issued_to[NAME_LEN];
    Date issue_date;
    int  days_overdue;
} Book;

Book register_books[MAX_BOOKS];
int book_count = 0;

/* Function prototypes */
void add_book(int id, const char *title, const char *author);
void print_book(const Book *b);
void display_register(void);
int  find_book(int id);
void issue_book(int id, const char *student, Date d);
void return_book(int id);

void add_book(int id, const char *title, const char *author) {
    if (book_count >= MAX_BOOKS) { printf("Register full.\n"); return; }
    register_books[book_count].book_id = id;
    strncpy(register_books[book_count].title,  title,  TITLE_LEN  - 1);
    strncpy(register_books[book_count].author, author, AUTHOR_LEN - 1);
    register_books[book_count].title[TITLE_LEN - 1]   = '\0';
    register_books[book_count].author[AUTHOR_LEN - 1] = '\0';
    register_books[book_count].is_issued    = 0;
    register_books[book_count].issued_to[0] = '\0';
    register_books[book_count].days_overdue = 0;
    book_count++;
}

void print_book(const Book *b) {
    printf("ID: %d | Title: %-35s | Author: %-20s | Status: %s",
           b->book_id, b->title, b->author,
           b->is_issued ? "Issued" : "Available");
    if (b->is_issued) {
        printf(" | Issued To: %s | Date: %02d/%02d/%04d | Overdue: %d days",
               b->issued_to,
               b->issue_date.day, b->issue_date.month, b->issue_date.year,
               b->days_overdue);
    }
    printf("\n");
}

void display_register(void) {
    int i;
    printf("\n--- Library Book Register ---\n");
    for (i = 0; i < book_count; i++) {
        print_book(&register_books[i]);
    }
    printf("\n");
}

int find_book(int id) {
    int i;
    for (i = 0; i < book_count; i++) {
        if (register_books[i].book_id == id) return i;
    }
    return -1;
}

void issue_book(int id, const char *student, Date d) {
    int idx = find_book(id);
    if (idx == -1) { printf("Book ID %d not found.\n", id); return; }
    if (register_books[idx].is_issued) {
        printf("Book '%s' already issued.\n", register_books[idx].title);
        return;
    }
    register_books[idx].is_issued = 1;
    strncpy(register_books[idx].issued_to, student, NAME_LEN - 1);
    register_books[idx].issued_to[NAME_LEN - 1] = '\0';
    register_books[idx].issue_date = d;
    printf("Book '%s' issued to %s on %02d/%02d/%04d.\n",
           register_books[idx].title, student, d.day, d.month, d.year);
}

void return_book(int id) {
    int idx = find_book(id);
    if (idx == -1) { printf("Book ID %d not found.\n", id); return; }
    if (!register_books[idx].is_issued) {
        printf("Book '%s' was not issued.\n", register_books[idx].title);
        return;
    }
    printf("Book '%s' returned by %s.\n",
           register_books[idx].title, register_books[idx].issued_to);
    register_books[idx].is_issued    = 0;
    register_books[idx].issued_to[0] = '\0';
    register_books[idx].days_overdue = 0;
}

int main() {
    /* Populate register */
    add_book(101, "C Programming Language",  "Kernighan and Ritchie");
    add_book(102, "Data Structures",          "Lipschutz");
    add_book(103, "Operating Systems",        "Tanenbaum");
    add_book(104, "Database Management",      "Navathe");
    add_book(105, "Computer Networks",        "Forouzan");

    display_register();

    /* Issue books */
    Date d1 = {1, 10, 2026};
    issue_book(101, "Rahul Sharma", d1);
    Date d2 = {5, 10, 2026};
    issue_book(103, "Priya Mehta",  d2);

    /* Set overdue days */
    int idx = find_book(102);
    if (idx != -1) register_books[idx].days_overdue = 5;
    idx = find_book(103);
    if (idx != -1) register_books[idx].days_overdue = 12;

    display_register();

    /* Return a book */
    return_book(101);

    display_register();

    return 0;
}
