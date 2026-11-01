/*
 * Session 5 - If-else-if Ladder, Nested If, Switch-Case,
 *             Discounts, Membership, and Complete Billing
 * File: billing.c
 * Compile: gcc -Wall -o billing billing.c
 */

#include <stdio.h>

#define GST_RATE 18.0

int main() {
    float bill_total;
    int is_member;
    int item_code;
    float discount_percent = 0.0f;
    float member_discount = 0.0f;

    printf("*********************************************\n");
    printf("*        PRERNA KIRANA STORE                *\n");
    printf("*        Complete Billing System            *\n");
    printf("*********************************************\n");

    printf("Enter bill total (Rs.): ");
    scanf("%f", &bill_total);

    printf("Is customer a member? (1=Yes, 0=No): ");
    scanf("%d", &is_member);

    printf("Enter item code (1=Grocery, 2=Dairy, 3=Snacks, 4=Beverages): ");
    scanf("%d", &item_code);

    /* If-else-if ladder: discount based on bill amount */
    if (bill_total >= 1000.0f) {
        discount_percent = 10.0f;
        printf("Bill Discount: 10%% (Purchase >= Rs.1000)\n");
    } else if (bill_total >= 500.0f) {
        discount_percent = 5.0f;
        printf("Bill Discount: 5%% (Purchase >= Rs.500)\n");
    } else if (bill_total >= 200.0f) {
        discount_percent = 2.0f;
        printf("Bill Discount: 2%% (Purchase >= Rs.200)\n");
    } else {
        discount_percent = 0.0f;
        printf("No bill discount (Purchase < Rs.200)\n");
    }

    /* Nested if: additional member discount */
    if (is_member == 1) {
        if (bill_total >= 500.0f) {
            member_discount = 3.0f;
            printf("Member Bonus Discount: 3%% (Member + >= Rs.500)\n");
        } else {
            member_discount = 1.0f;
            printf("Member Bonus Discount: 1%%\n");
        }
    } else {
        printf("No member discount (not a member)\n");
    }

    /* Switch-case: item category label */
    printf("Item Category  : ");
    switch (item_code) {
        case 1: printf("Grocery\n");   break;
        case 2: printf("Dairy\n");     break;
        case 3: printf("Snacks\n");    break;
        case 4: printf("Beverages\n"); break;
        default: printf("General\n");  break;
    }

    /* Calculations */
    float total_discount_pct = discount_percent + member_discount;
    float discount_amount = bill_total * total_discount_pct / 100.0f;
    float after_discount   = bill_total - discount_amount;
    float gst_amount       = after_discount * (float)GST_RATE / 100.0f;
    float grand_total      = after_discount + gst_amount;

    printf("--------------------------------------------\n");
    printf("Bill Total          : Rs.%.2f\n", bill_total);
    printf("Total Discount (%.0f%%)  : Rs.%.2f\n", total_discount_pct, discount_amount);
    printf("After Discount      : Rs.%.2f\n", after_discount);
    printf("GST @ %.0f%%          : Rs.%.2f\n", (float)GST_RATE, gst_amount);
    printf("Grand Total         : Rs.%.2f\n", grand_total);
    printf("*********************************************\n");

    return 0;
}
