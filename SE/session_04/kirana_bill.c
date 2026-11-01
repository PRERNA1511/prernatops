/*
 * Session 4 - Arithmetic, GST, Totals, Change Calculation,
 *             Logical Expressions, Increment/Decrement
 * File: kirana_bill.c
 * Compile: gcc -Wall -o kirana_bill kirana_bill.c
 */

#include <stdio.h>

#define GST_RATE 18.0

int main() {
    /* Item details */
    float price1 = 50.00f;   /* Rice 1kg */
    float price2 = 30.00f;   /* Sugar 1kg */
    float price3 = 120.00f;  /* Oil 1L */
    int qty1 = 2, qty2 = 3, qty3 = 1;

    /* Calculations */
    float subtotal1 = price1 * qty1;
    float subtotal2 = price2 * qty2;
    float subtotal3 = price3 * qty3;

    float bill_total = subtotal1 + subtotal2 + subtotal3;
    float gst_amount = bill_total * GST_RATE / 100.0f;
    float grand_total = bill_total + gst_amount;

    float cash_given = 500.00f;
    float change = cash_given - grand_total;

    /* Logical expressions */
    int is_member = 1;        /* customer is a member */
    int purchase_above_200 = (bill_total > 200.0f);

    /* Increment / Decrement demonstration */
    int item_count = 3;
    printf("Item count before increment: %d\n", item_count);
    item_count++;
    printf("Item count after increment : %d\n", item_count);
    item_count--;
    printf("Item count after decrement : %d\n", item_count);

    printf("\n*********************************************\n");
    printf("*        PRERNA KIRANA STORE                *\n");
    printf("*        Kirana Bill                        *\n");
    printf("*********************************************\n");
    printf("Item            Qty   Rate    Amount\n");
    printf("--------------------------------------------\n");
    printf("Rice (1kg)      %d    Rs.%.2f  Rs.%.2f\n",  qty1, price1, subtotal1);
    printf("Sugar (1kg)     %d    Rs.%.2f  Rs.%.2f\n",  qty2, price2, subtotal2);
    printf("Oil (1L)        %d    Rs.%.2f Rs.%.2f\n",   qty3, price3, subtotal3);
    printf("--------------------------------------------\n");
    printf("Subtotal                      Rs.%.2f\n",   bill_total);
    printf("GST @ %.0f%%                    Rs.%.2f\n", GST_RATE, gst_amount);
    printf("--------------------------------------------\n");
    printf("Grand Total                   Rs.%.2f\n",   grand_total);
    printf("Cash Given                    Rs.%.2f\n",   cash_given);
    printf("Change Returned               Rs.%.2f\n",   change);
    printf("*********************************************\n");
    printf("\nIs Member           : %s\n", is_member ? "Yes" : "No");
    printf("Purchase > Rs.200  : %s\n", purchase_above_200 ? "Yes" : "No");
    printf("Eligible for extra discount: %s\n",
           (is_member && purchase_above_200) ? "Yes" : "No");

    return 0;
}
