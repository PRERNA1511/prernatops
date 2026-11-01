/*
 * Session 14 - Parking Fee Program (Corrected, Working Version)
 * File: parking_fee.c
 * Compile: gcc -Wall -o parking_fee parking_fee.c
 *
 * Test Cases:
 *   T, 1  -> Two-wheeler, 1 hour  -> Rs. 10
 *   F, 3  -> Four-wheeler, 3 hours -> Rs. 60
 *   F, 0  -> Four-wheeler, 0 hours -> Rs. 0 (no charge)
 */

#include <stdio.h>

/* Calculate parking fee */
float calculate_parking_fee(char vehicle_type, int hours) {
    float fee = 0.0f;
    if (hours <= 0) {
        return 0.0f;
    }
    if (vehicle_type == 'T' || vehicle_type == 't') {
        /* Two-wheeler: Rs.10 per hour */
        fee = hours * 10.0f;
    } else if (vehicle_type == 'F' || vehicle_type == 'f') {
        /* Four-wheeler: Rs.20 per hour */
        fee = hours * 20.0f;
    } else {
        printf("Unknown vehicle type '%c'.\n", vehicle_type);
        fee = 0.0f;
    }
    return fee;
}

int main() {
    char vtype;
    int hours;
    float fee;

    printf("=== Parking Fee Calculator ===\n");
    printf("Vehicle Type: T = Two-wheeler, F = Four-wheeler\n");
    printf("Enter vehicle type (T/F): ");
    scanf(" %c", &vtype);
    printf("Enter parking hours: ");
    scanf("%d", &hours);

    fee = calculate_parking_fee(vtype, hours);

    printf("------------------------------\n");
    printf("Vehicle Type : %c\n", vtype);
    printf("Hours Parked : %d\n", hours);
    printf("Parking Fee  : Rs. %.2f\n", fee);
    printf("==============================\n");

    return 0;
}
