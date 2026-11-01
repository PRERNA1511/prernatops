/*
 * Session 14 - Parking Fee with DELIBERATE COMPILE ERRORS
 * File: parking_errors.c
 * This file intentionally contains compile-time errors for debugging practice.
 * DO NOT compile this file directly - it is for error demonstration only.
 *
 * Errors introduced:
 *   1. Missing semicolon after variable declaration (line ~15)
 *   2. Undeclared variable used (line ~22)
 *   3. Wrong format specifier for float (line ~28)
 *   4. Missing closing brace for if block (line ~35)
 */

#include <stdio.h>

int main() {
    char vtype
    int hours;
    float fee = 0.0;

    printf("Enter vehicle type (T/F): ");
    scanf(" %c", &vtype);
    printf("Enter hours: ");
    scanf("%d", &houers);   /* undeclared variable 'houers' - typo */

    if (vtype == 'T') {
        fee = hours * 10;
    } else {
        fee = hours * 20;
    /* Missing closing brace for else */

    printf("Fee: %d\n", fee);   /* wrong format specifier: %d for float */
    return 0;
}
