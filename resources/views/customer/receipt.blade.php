<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Electronic Receipt - Otirasor Beach
    </title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 40px 20px;
        }

        .receipt {
            width: 700px;
            max-width: 100%;
            margin: auto;
            background: white;
            padding: 40px;
            box-sizing: border-box;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.12);
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #0077b6;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }

        .header h1 {
            color: #0077b6;
            margin: 0;
        }

        .header p {
            margin: 6px 0;
            color: #555;
        }

        .receipt-title {
            text-align: center;
            color: #023e8a;
            margin-bottom: 25px;
        }

        .receipt-number {
            text-align: center;
            font-weight: bold;
            color: #0077b6;
            margin-bottom: 25px;
        }

        .section {
            margin-bottom: 25px;
        }

        .section h3 {
            color: #023e8a;
            border-bottom: 1px solid #ddd;
            padding-bottom: 8px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 8px 0;
        }

        .label {
            font-weight: bold;
        }

        .value {
            text-align: right;
        }

        .sub-total-row {
            padding: 6px 0;
        }

        .sub-total-label {
            font-weight: bold;
            color: #444;
        }

        .sub-total-value {
            font-weight: bold;
            color: #444;
        }

        .total-row {
            margin-top: 10px;
            padding: 14px 0;
            border-top: 2px solid #0077b6;
            border-bottom: 2px solid #0077b6;
        }

        .total-label {
            font-weight: bold;
            color: #023e8a;
            font-size: 18px;
        }

        .total-value {
            font-weight: bold;
            color: #0077b6;
            font-size: 22px;
        }

        .grand-total-row {
            margin-top: 15px;
            padding: 18px 0;
            border-top: 3px solid #023e8a;
            border-bottom: 3px solid #023e8a;
        }

        .grand-total-label {
            font-weight: bold;
            color: #023e8a;
            font-size: 20px;
        }

        .grand-total-value {
            font-weight: bold;
            color: #0077b6;
            font-size: 26px;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            background: #d4edda;
            color: #155724;
            font-weight: bold;
        }

        .footer {
            border-top: 1px solid #ddd;
            margin-top: 30px;
            padding-top: 20px;
            text-align: center;
            color: #666;
        }

        .back-btn {
            display: inline-block;
            margin-top: 25px;
            padding: 10px 18px;
            background: #0077b6;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .back-btn:hover {
            background: #005f8f;
        }

        .print-btn {
            display: inline-block;
            margin-top: 25px;
            margin-left: 10px;
            padding: 10px 18px;
            background: #555;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .print-btn:hover {
            background: #333;
        }

        @media print {

            body {
                background: white;
                padding: 0;
            }

            .receipt {
                width: 100%;
                max-width: 100%;
                box-shadow: none;
                border-radius: 0;
            }

            .back-btn,
            .print-btn {
                display: none;
            }
        }

    </style>
</head>

<body>

<div class="receipt">

    <div class="header">

        <h1>
            Otirasor Beach and Resort
        </h1>

        <p>
            Electronic Receipt
        </p>

    </div>


    <h2 class="receipt-title">
        PAYMENT RECEIPT
    </h2>


    <div class="receipt-number">

        Receipt No.:
        {{ $booking->receipt_number }}

    </div>


    <!-- ==========================================
         GUEST INFORMATION
    =========================================== -->

    <div class="section">

        <h3>
            Guest Information
        </h3>

        <div class="row">

            <span class="label">
                Guest Name
            </span>

            <span class="value">
                {{ $booking->guest_name }}
            </span>

        </div>


        <div class="row">

            <span class="label">
                Contact Number
            </span>

            <span class="value">
                {{ $booking->contact_number }}
            </span>

        </div>


        <div class="row">

            <span class="label">
                Adults
            </span>

            <span class="value">
                {{ $booking->number_of_adults }}
            </span>

        </div>


        <div class="row">

            <span class="label">
                Kids
            </span>

            <span class="value">
                {{ $booking->number_of_kids }}
            </span>

        </div>


        <div class="row">

            <span class="label">
                Total Guests
            </span>

            <span class="value">
                {{ $booking->number_of_guests }}
            </span>

        </div>

    </div>


    <!-- ==========================================
         RESERVATION DETAILS
    =========================================== -->

    <div class="section">

        <h3>
            Reservation Details
        </h3>

        <div class="row">

            <span class="label">
                Accommodation
            </span>

            <span class="value">
                {{ $booking->accommodations }}
            </span>

        </div>


        <!-- ACCOMMODATION TOTAL -->

        <div class="row">

            <span class="label">
                Accommodation Total
            </span>

            <span class="value">
                ₱{{ number_format(
                    (float) $booking->accommodation_total,
                    2
                ) }}
            </span>

        </div>


        <!-- ==========================================
             BEACH ENTRANCE
        =========================================== -->

        <div class="row sub-total-row">

            <span class="sub-total-label">
                Beach Entrance - Adults
            </span>

            <span class="sub-total-value">

                {{ (int) ($booking->number_of_adults ?? 0) }}
                × ₱20 =
                ₱{{ number_format(
                    ((int) ($booking->number_of_adults ?? 0)) * 20,
                    2
                ) }}

            </span>

        </div>


        <div class="row sub-total-row">

            <span class="sub-total-label">
                Beach Entrance - Kids
            </span>

            <span class="sub-total-value">

                {{ (int) ($booking->number_of_kids ?? 0) }}
                × ₱10 =
                ₱{{ number_format(
                    ((int) ($booking->number_of_kids ?? 0)) * 10,
                    2
                ) }}

            </span>

        </div>


        @php

            $entranceTotal =
                ((int) ($booking->number_of_adults ?? 0) * 20) +
                ((int) ($booking->number_of_kids ?? 0) * 10);

            $poolAdults =
                (int) ($booking->pool_adults ?? 0);

            $poolKids =
                (int) ($booking->pool_kids ?? 0);

            $poolTotal =
                ($poolAdults * 70) +
                ($poolKids * 50);

        @endphp


        <div class="row sub-total-row">

            <span class="sub-total-label">
                Entrance Total
            </span>

            <span class="sub-total-value">
                ₱{{ number_format(
                    $entranceTotal,
                    2
                ) }}
            </span>

        </div>


        <!-- ==========================================
             SWIMMING POOL
        =========================================== -->

        <div class="row sub-total-row">

            <span class="sub-total-label">
                Swimming Pool - Adults
            </span>

            <span class="sub-total-value">

                {{ $poolAdults }}
                × ₱70 =
                ₱{{ number_format(
                    $poolAdults * 70,
                    2
                ) }}

            </span>

        </div>


        <div class="row sub-total-row">

            <span class="sub-total-label">
                Swimming Pool - Kids
            </span>

            <span class="sub-total-value">

                {{ $poolKids }}
                × ₱50 =
                ₱{{ number_format(
                    $poolKids * 50,
                    2
                ) }}

            </span>

        </div>


        <div class="row total-row">

            <span class="total-label">
                Swimming Pool Total
            </span>

            <span class="total-value">
                ₱{{ number_format(
                    $poolTotal,
                    2
                ) }}
            </span>

        </div>


        <!-- FACILITY TOTAL -->

        <div class="row total-row">

            <span class="total-label">
                Facility Total
            </span>

            <span class="total-value">
                ₱{{ number_format(
                    (float) $booking->facility_total,
                    2
                ) }}
            </span>

        </div>


        <!-- GRAND TOTAL -->

        <div class="row grand-total-row">

            <span class="grand-total-label">
                GRAND TOTAL
            </span>

            <span class="grand-total-value">
                ₱{{ number_format(
                    (float) $booking->accommodation_total +
                    (float) $booking->facility_total,
                    2
                ) }}
            </span>

        </div>


        <div class="row">

            <span class="label">
                Check-in
            </span>

            <span class="value">
                {{ $booking->check_in }}
            </span>

        </div>


        <div class="row">

            <span class="label">
                Check-out
            </span>

            <span class="value">
                {{ $booking->check_out }}
            </span>

        </div>

    </div>


    <!-- ==========================================
         PAYMENT INFORMATION
    =========================================== -->

    <div class="section">

        <h3>
            Payment Information
        </h3>

        <div class="row">

            <span class="label">
                Payment Method
            </span>

            <span class="value">
                {{ $booking->payment_method }}
            </span>

        </div>


        @if($booking->payment_method === 'GCash')

            <div class="row">

                <span class="label">
                    GCash Reference
                </span>

                <span class="value">
                    {{ $booking->gcash_reference }}
                </span>

            </div>

        @endif


        <div class="row">

            <span class="label">
                Payment Status
            </span>

            <span class="value">
                {{ $booking->payment_status }}
            </span>

        </div>


        <div class="row">

            <span class="label">
                Booking Status
            </span>

            <span class="value">

                <span class="status">
                    {{ $booking->status }}
                </span>

            </span>

        </div>

    </div>


    <!-- ==========================================
         RECEIPT INFORMATION
    =========================================== -->

    <div class="section">

        <h3>
            Receipt Information
        </h3>

        <div class="row">

            <span class="label">
                Receipt Number
            </span>

            <span class="value">
                {{ $booking->receipt_number }}
            </span>

        </div>


        <div class="row">

            <span class="label">
                Generated At
            </span>

            <span class="value">
                {{ $booking->receipt_generated_at }}
            </span>

        </div>

    </div>


    <!-- ==========================================
         FOOTER
    =========================================== -->

    <div class="footer">

        <p>
            Thank you for choosing
            Otirasor Beach and Resort.
        </p>

        <p>
            This is an electronic receipt generated
            by the Otirasor Beach reservation system.
        </p>


        <a
            href="/my-bookings"
            class="back-btn"
        >
            Back to My Bookings
        </a>


        <button
            type="button"
            class="print-btn"
            onclick="window.print()"
        >
            Print / Save as PDF
        </button>

    </div>

</div>

</body>
</html>