/*
 * Session 11 - Pointers, Pointer Arithmetic, Pointer-Based Updates,
 *              Swapping, and Most-Overdue Book
 * File: pointers.c
 * Compile: gcc -Wall -o pointers pointers.c
 */

#include <stdio.h>
#include <string.h>

#define MAX_BOOKS 5
#define TITLE_LEN 50

/* Book data */
char titles[MAX_BOOKS][TITLE_LEN] = {
    "C Programming Language",
    "Data Structures",
    "Operating Systems",
    "Database Management",
    "Computer Networks"
};
int days_overdue[MAX_BOOKS] = {0, 5, 12, 0, 3};
float fine_per_day = 2.0f;

/* Pointer-based fine update */
void update_fine(float *fine, int overdue_days, float rate) {
    *fine = (float)overdue_days * rate;
}

/* Swap two integers using pointers */
void swap_int(int *a, int *b) {
    int temp = *a;
    *a = *b;
    *b = temp;
}

int main() {
    int i;
    float fines[MAX_BOOKS];
    float *p;

    /* Calculate fines using pointer arithmetic */
    p = fines;
    for (i = 0; i < MAX_BOOKS; i++) {
        update_fine(p + i, days_overdue[i], fine_per_day);
    }

    printf("=== Book Overdue & Fine Report ===\n");
    printf("%-4s %-35s %-12s %-10s\n", "No.", "Title", "Overdue Days", "Fine (Rs.)");
    printf("-------------------------------------------------------------\n");

    int max_overdue = days_overdue[0];
    int max_idx = 0;
    for (i = 0; i < MAX_BOOKS; i++) {
        printf("%-4d %-35s %-12d Rs. %.2f\n",
               i + 1, titles[i], days_overdue[i], *(fines + i));
        if (days_overdue[i] > max_overdue) {
            max_overdue = days_overdue[i];
            max_idx = i;
        }
    }

    printf("\nMost Overdue Book: '%s' (%d days, Fine: Rs. %.2f)\n",
           titles[max_idx], max_overdue, fines[max_idx]);

    /* Pointer arithmetic demonstration */
    printf("\n=== Pointer Arithmetic Demo ===\n");
    int arr[5] = {10, 20, 30, 40, 50};
    int *ip = arr;
    printf("Array elements using pointer arithmetic:\n");
    for (i = 0; i < 5; i++) {
        printf("arr[%d] = %d  (address: %p)\n", i, *(ip + i), (void *)(ip + i));
    }

    /* Swap demonstration */
    printf("\n=== Swap Demo (pass-by-pointer) ===\n");
    int x = 100, y = 200;
    printf("Before swap: x = %d, y = %d\n", x, y);
    swap_int(&x, &y);
    printf("After swap : x = %d, y = %d\n", x, y);

    return 0;
}
