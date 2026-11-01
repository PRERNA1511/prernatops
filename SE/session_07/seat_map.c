/*
 * Session 7 - Nested Loops: Seat Map, Booked Seats,
 *             Fare Triangle, and Hollow Ticket Border
 * File: seat_map.c
 * Compile: gcc -Wall -o seat_map seat_map.c
 */

#include <stdio.h>

#define ROWS 5
#define COLS 6

int main() {
    int i, j;

    /* ---- Seat Map ---- */
    /* 0 = available, 1 = booked */
    int seats[ROWS][COLS] = {
        {0, 1, 0, 0, 1, 0},
        {1, 0, 0, 1, 0, 0},
        {0, 0, 1, 0, 0, 1},
        {1, 1, 0, 0, 0, 0},
        {0, 0, 0, 1, 1, 0}
    };

    printf("**** BUS SEAT MAP ****\n");
    printf("    ");
    for (j = 1; j <= COLS; j++) {
        printf("C%d ", j);
    }
    printf("\n");

    int booked_count = 0;
    for (i = 0; i < ROWS; i++) {
        printf("R%d  ", i + 1);
        for (j = 0; j < COLS; j++) {
            if (seats[i][j] == 1) {
                printf("[X] ");
                booked_count++;
            } else {
                printf("[ ] ");
            }
        }
        printf("\n");
    }
    printf("Booked seats: %d\n", booked_count);
    printf("Available seats: %d\n\n", (ROWS * COLS) - booked_count);

    /* ---- Fare Triangle ---- */
    /* Fare increases by Rs.10 per row */
    printf("**** FARE TRIANGLE ****\n");
    for (i = 1; i <= 5; i++) {
        int fare = i * 10;
        for (j = 1; j <= i; j++) {
            printf("%4d", fare);
        }
        printf("\n");
    }
    printf("\n");

    /* ---- Hollow Ticket Border ---- */
    printf("**** TICKET BORDER ****\n");
    int width = 30, height = 6;
    for (i = 1; i <= height; i++) {
        for (j = 1; j <= width; j++) {
            if (i == 1 || i == height || j == 1 || j == width) {
                printf("*");
            } else {
                printf(" ");
            }
        }
        printf("\n");
    }

    return 0;
}
