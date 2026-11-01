/*
 * Session 6 - Bus Fare Chart, Passenger Counting,
 *             Do-While Menu, and Daily Collection
 * File: bus_fare.c
 * Compile: gcc -Wall -o bus_fare bus_fare.c
 */

#include <stdio.h>

/* Fare table: fare for stops 1..20 */
float fare_for_stops(int stops) {
    if (stops <= 0)   return 0.0f;
    if (stops <= 3)   return 10.0f;
    if (stops <= 6)   return 18.0f;
    if (stops <= 9)   return 26.0f;
    if (stops <= 12)  return 36.0f;
    if (stops <= 15)  return 52.0f;
    if (stops <= 18)  return 68.0f;
    return 86.0f;   /* stops <= 20 */
}

int main() {
    int choice;
    int total_passengers = 0;
    float daily_collection = 0.0f;
    float highest_fare = 0.0f;
    int passenger_stops;
    float fare;

    printf("*********************************************\n");
    printf("*        BUS FARE COLLECTION SYSTEM         *\n");
    printf("*********************************************\n");

    /* Print fare chart */
    printf("\n--- Bus Fare Chart (up to 20 stops) ---\n");
    printf("Stops\t\tFare (Rs.)\n");
    printf("------\t\t----------\n");
    int s;
    for (s = 1; s <= 20; s++) {
        printf("%d\t\tRs. %.0f\n", s, fare_for_stops(s));
    }
    printf("\n");

    do {
        printf("--- Menu ---\n");
        printf("1. Add Passenger\n");
        printf("2. Show Daily Collection\n");
        printf("3. Exit\n");
        printf("Enter choice: ");
        scanf("%d", &choice);

        switch (choice) {
            case 1:
                printf("Enter number of stops for passenger: ");
                scanf("%d", &passenger_stops);
                fare = fare_for_stops(passenger_stops);
                printf("Fare for %d stop(s): Rs. %.0f\n", passenger_stops, fare);
                total_passengers++;
                daily_collection += fare;
                if (fare > highest_fare) {
                    highest_fare = fare;
                }
                break;
            case 2:
                printf("\n--- Daily Summary ---\n");
                printf("Total Passengers  : %d\n", total_passengers);
                printf("Daily Collection  : Rs. %.2f\n", daily_collection);
                printf("Highest Fare      : Rs. %.2f\n", highest_fare);
                printf("---------------------\n\n");
                break;
            case 3:
                printf("Exiting. Thank you!\n");
                break;
            default:
                printf("Invalid choice. Try again.\n");
        }
    } while (choice != 3);

    return 0;
}
