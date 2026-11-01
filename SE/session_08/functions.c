/*
 * Session 8 - Functions, Prototypes, Separate Menu Functions,
 *             Pass-by-Value, and Highest-of-Three Calculation
 * File: functions.c
 * Compile: gcc -Wall -o functions functions.c
 */

#include <stdio.h>

/* Function prototypes */
void print_menu(void);
float calculate_fare(int stops);
float calculate_gst(float amount, float rate);
int highest_of_three(int a, int b, int c);
void print_bill(float subtotal, float discount, float gst, float total);

/* Fare calculation function */
float calculate_fare(int stops) {
    if (stops <= 0)  return 0.0f;
    if (stops <= 3)  return 10.0f;
    if (stops <= 6)  return 18.0f;
    if (stops <= 9)  return 26.0f;
    if (stops <= 12) return 36.0f;
    if (stops <= 15) return 52.0f;
    if (stops <= 18) return 68.0f;
    return 86.0f;
}

/* GST calculation function */
float calculate_gst(float amount, float rate) {
    return amount * rate / 100.0f;
}

/* Highest of three (pass-by-value) */
int highest_of_three(int a, int b, int c) {
    int max = a;
    if (b > max) max = b;
    if (c > max) max = c;
    return max;
}

/* Menu display function */
void print_menu(void) {
    printf("\n--- Main Menu ---\n");
    printf("1. Calculate Bus Fare\n");
    printf("2. Calculate GST on Amount\n");
    printf("3. Find Highest of Three Numbers\n");
    printf("4. Print Bill Summary\n");
    printf("5. Exit\n");
    printf("Enter choice: ");
}

/* Bill print function */
void print_bill(float subtotal, float discount, float gst, float total) {
    printf("\n--- Bill Summary ---\n");
    printf("Subtotal  : Rs. %.2f\n", subtotal);
    printf("Discount  : Rs. %.2f\n", discount);
    printf("GST       : Rs. %.2f\n", gst);
    printf("Total     : Rs. %.2f\n", total);
    printf("--------------------\n");
}

int main() {
    int choice;
    do {
        print_menu();
        scanf("%d", &choice);
        switch (choice) {
            case 1: {
                int stops;
                printf("Enter number of stops: ");
                scanf("%d", &stops);
                printf("Fare for %d stop(s): Rs. %.2f\n", stops, calculate_fare(stops));
                break;
            }
            case 2: {
                float amount, rate;
                printf("Enter amount: Rs. ");
                scanf("%f", &amount);
                printf("Enter GST rate (%%): ");
                scanf("%f", &rate);
                printf("GST Amount: Rs. %.2f\n", calculate_gst(amount, rate));
                break;
            }
            case 3: {
                int a, b, c;
                printf("Enter three integers: ");
                scanf("%d %d %d", &a, &b, &c);
                printf("Highest of %d, %d, %d = %d\n", a, b, c, highest_of_three(a, b, c));
                break;
            }
            case 4: {
                float sub, disc, gst_rate, gst_amt, total;
                printf("Enter subtotal: Rs. ");
                scanf("%f", &sub);
                printf("Enter discount: Rs. ");
                scanf("%f", &disc);
                printf("Enter GST rate (%%): ");
                scanf("%f", &gst_rate);
                float after_disc = sub - disc;
                gst_amt = calculate_gst(after_disc, gst_rate);
                total = after_disc + gst_amt;
                print_bill(sub, disc, gst_amt, total);
                break;
            }
            case 5:
                printf("Goodbye!\n");
                break;
            default:
                printf("Invalid choice.\n");
        }
    } while (choice != 5);

    return 0;
}
