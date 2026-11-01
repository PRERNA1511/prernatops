/*
 * Session 3 - C Data Types, Variables, Float/Double Precision, Constants, Customer Details
 * File: data_types.c
 * Compile: gcc -Wall -o data_types data_types.c
 */

#include <stdio.h>

#define STORE_NAME "Prerna Kirana Store"
#define GST_RATE 18.0

int main() {
    /* Integer data type */
    int customer_id = 1001;
    int age = 35;

    /* Float data type */
    float item_price = 49.99f;
    float discount_rate = 5.5f;

    /* Double data type */
    double total_amount = 1249.995;
    double gst_amount = total_amount * GST_RATE / 100.0;

    /* Char data type */
    char gender = 'M';

    /* Unsigned int */
    unsigned int loyalty_points = 350;

    /* Short */
    short pin_code = 400001;

    /* Long */
    long phone_number = 9876543210L;

    printf("==============================\n");
    printf("  %s\n", STORE_NAME);
    printf("  GST Rate: %.1f%%\n", GST_RATE);
    printf("==============================\n");
    printf("Customer ID     : %d\n", customer_id);
    printf("Customer Age    : %d years\n", age);
    printf("Gender          : %c\n", gender);
    printf("Phone Number    : %ld\n", phone_number);
    printf("PIN Code        : %d\n", pin_code);
    printf("Loyalty Points  : %u\n", loyalty_points);
    printf("------------------------------\n");
    printf("Item Price      : Rs. %.2f\n", item_price);
    printf("Discount Rate   : %.1f%%\n", discount_rate);
    printf("Total Amount    : Rs. %.3lf\n", total_amount);
    printf("GST Amount      : Rs. %.2lf\n", gst_amount);
    printf("==============================\n");

    /* Demonstrating float vs double precision */
    float f_val  = 1.0f / 3.0f;
    double d_val = 1.0  / 3.0;
    printf("\nFloat  precision (1/3) : %.10f\n", f_val);
    printf("Double precision (1/3) : %.15lf\n", d_val);

    return 0;
}
