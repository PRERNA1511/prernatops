/*
 * Session 9 - One-Dimensional and Two-Dimensional Arrays,
 *             Electricity Readings, Monthly Totals, and Society Usage
 * File: electricity.c
 * Compile: gcc -Wall -o electricity electricity.c
 */

#include <stdio.h>

#define MONTHS 12
#define FLATS  5

int main() {
    int i, j;

    /* ---- 1D Array: Monthly electricity readings for one house ---- */
    /* Units consumed each month */
    float monthly_units[MONTHS] = {
        210, 185, 200, 175, 195, 220,
        250, 240, 195, 180, 165, 190
    };

    char *month_names[MONTHS] = {
        "Jan","Feb","Mar","Apr","May","Jun",
        "Jul","Aug","Sep","Oct","Nov","Dec"
    };

    float yearly_total = 0.0f;
    float highest = monthly_units[0];
    float lowest  = monthly_units[0];
    int   high_month = 0, low_month = 0;

    for (i = 0; i < MONTHS; i++) {
        yearly_total += monthly_units[i];
        if (monthly_units[i] > highest) { highest = monthly_units[i]; high_month = i; }
        if (monthly_units[i] < lowest)  { lowest  = monthly_units[i]; low_month  = i; }
    }
    float yearly_avg = yearly_total / MONTHS;

    printf("=== Electricity Readings (Single House) ===\n");
    printf("Month\t\tUnits\n");
    printf("------\t\t-----\n");
    for (i = 0; i < MONTHS; i++) {
        printf("%s\t\t%.0f\n", month_names[i], monthly_units[i]);
    }
    printf("------------------------------------------\n");
    printf("Yearly Total    : %.0f units\n", yearly_total);
    printf("Yearly Average  : %.2f units/month\n", yearly_avg);
    printf("Highest Month   : %s (%.0f units)\n", month_names[high_month], highest);
    printf("Lowest Month    : %s (%.0f units)\n\n", month_names[low_month], lowest);

    /* ---- 2D Array: Monthly units for 5 flats in a society ---- */
    float society[FLATS][MONTHS] = {
        {120, 110, 130, 105, 125, 140, 160, 155, 130, 115, 100, 120},
        {200, 185, 195, 175, 190, 210, 240, 230, 195, 180, 165, 190},
        { 90,  85,  95,  80,  88,  95, 110, 105,  90,  82,  78,  88},
        {150, 140, 145, 135, 148, 162, 180, 175, 150, 138, 128, 145},
        {175, 160, 170, 155, 168, 185, 200, 195, 168, 152, 142, 165}
    };

    printf("=== Society Electricity Usage (5 Flats x 12 Months) ===\n");
    printf("Flat\t");
    for (j = 0; j < MONTHS; j++) {
        printf("%s\t", month_names[j]);
    }
    printf("Total\n");

    for (i = 0; i < FLATS; i++) {
        float flat_total = 0.0f;
        printf("Flat%d\t", i + 1);
        for (j = 0; j < MONTHS; j++) {
            printf("%.0f\t", society[i][j]);
            flat_total += society[i][j];
        }
        printf("%.0f\n", flat_total);
    }

    /* Monthly totals across all flats */
    printf("\nMonthly Society Totals:\n");
    for (j = 0; j < MONTHS; j++) {
        float month_total = 0.0f;
        for (i = 0; i < FLATS; i++) {
            month_total += society[i][j];
        }
        printf("%s: %.0f units\n", month_names[j], month_total);
    }

    return 0;
}
