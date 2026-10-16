<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Electronic Receipt</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px 15px;
            background: #f4f7f9;
            font-family: Arial, Helvetica, sans-serif;
            color: #1f2937;
        }

        .receipt-container {
            width: 100%;
            max-width: 750px;
            margin: auto;
        }

        .receipt {
            background: white;
            border-radius: 16px;
            padding: 35px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 25px;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
            font-size: 30px;
            color: #0f766e;
        }

        .header p {
            margin: 8px 0 0;
            color: #6b7280;
        }

        .receipt-number {
            margin-top: 15px;
            font-weight: bold;
            color: #374151;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 15px;
            color: #111827;
        }

        .info-box {
            background: #f9fafb;
            border-radius: 10px;
            padding: 15px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .row:last-child {
            border-bottom: none;
        }

        .label {
            color: #6b7280;
        }

        .value {
            font-weight: 600;
            text-align: right;
        }

        .total-section {
            margin-top: 25px;
            border-top: 2px solid #e5e7eb;
            padding-top: 15px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 9px 0;
        }

        .total-label {
            color: #4b5563;
        }

        .total-value {
            font-weight: bold;
        }

        .grand-total {
            margin-top: 15px;
            padding: 18px;
            border-radius: 12px;
            background: #ecfdf5;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .grand-total-label {
            font-size: 20px;
            font-weight: bold;
            color: #065f46;
        }

        .grand-total-value {
            font-size: 24px;
            font-weight: bold;
            color: #047857;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            background: #dcfce7;
            color: #166534;
            font-weight: bold;
        }

        .buttons {
            display: flex;
            gap: 12px;
            margin-top: 30px;
        }

        .buttons a,
        .buttons button {
            flex: 1;
            border: none;
            border-radius: 10px;
            padding: 13px;
            text-align: center;
            text-decoration: none;
            font-size: 15px;
            cursor: pointer;
        }

        .back-btn {
            background: #e5e7eb;
            color: #111827;
        }

        .print-btn {
            background: #0f766e;
            color: white;
        }

        @media (max-width: 600px) {
            body {
                padding: 15px 10px;
            }

            .receipt {
                padding: 22px 18px;
            }

            .row,
            .grand-total {
                flex-direction: column;
                gap: 5px;
            }

            .value,
            .grand-total-value {
                text-align: left;
            }

            .buttons {
                flex-direction: column;
            }
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .receipt {
                box-shadow: none;
                border-radius: 0;
            }

            .buttons {
                display: none;
            }
        }
    </style>
</head>

<body>

<div class="receipt-container">

    <div class="receipt">

        {{-- HEADER --}}
        <div class="header">

            <h1>Otirasor Beach and Resort</h1>

            <p>Electronic Receipt</p>

            <div class="receipt-number">
                Receipt No:
                {{ $booking->receipt_number ?? 'N/A' }}
            </div>

        </div>


        {{-- GUEST INFORMATION --}}
        <div class="section-title">
            Guest Information
        </div>

        <div class="info-box">

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
                    Number of Guests
                </span>

                <span class="value">
                    {{ $booking->number_of_guests }}
                </span>
            </div>

        </div>


        {{-- BOOKING INFORMATION --}}
        <div class="section-title">
            Booking Information
        </div>

        <div class="info-box">

            <div class="row">
                <span class="label">
                    Check-in
                </span>

                <span class="value">
                    {{ \Carbon\Carbon::parse($booking->check_in)->format('F d, Y') }}
                </span>
            </div>


            <div class="row">
                <span class="label">
                    Check-out
                </span>

                <span class="value">
                    {{ \Carbon\Carbon::parse($booking->check_out)->format('F d, Y') }}
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


        {{-- ACCOMMODATION --}}
        <div class="section-title">
            Accommodation
        </div>

        <div class="info-box">

            <div class="row">
                <span class="label">
                    Selected Accommodation
                </span>

                <span class="value">
                    {{ $booking->accommodations ?? 'None' }}
                </span>
            </div>

        </div>


        {{-- PAYMENT --}}
        <div class="section-title">
            Payment Information
        </div>

        <div class="info-box">

            <div class="row">
                <span class="label">
                    Payment Method
                </span>

                <span class="value">
                    {{ $booking->payment_method }}
                </span>
            </div>


            @if($booking->gcash_reference)
                <div class="row">
                    <span class="label">
                        GCash Reference
                    </span>

                    <span class="value">
                        {{ $booking->gcash_reference }}
                    </span>
                </div>
            @endif

        </div>


        {{-- TOTALS --}}
        <div class="total-section">

            <div class="total-row">

                <span class="total-label">
                    Accommodation Total
                </span>

                <span class="total-value">
                    ₱{{ number_format($booking->accommodation_total ?? 0, 2) }}
                </span>

            </div>


            @if(($booking->facility_total ?? 0) > 0)

                <div class="total-row">

                    <span class="total-label">
                        Beach / Swimming Pool
                    </span>

                    <span class="total-value">
                        Included
                    </span>

                </div>


                <div class="total-row">

                    <span class="total-label">
                        Facility Total
                    </span>

                    <span class="total-value">
                        ₱{{ number_format($booking->facility_total, 2) }}
                    </span>

                </div>

            @endif


            <div class="grand-total">

                <span class="grand-total-label">
                    Grand Total
                </span>

                <span class="grand-total-value">
                    ₱{{
                        number_format(
                            ($booking->accommodation_total ?? 0) +
                            ($booking->facility_total ?? 0),
                            2
                        )
                    }}
                </span>

            </div>

        </div>


        {{-- GENERATED DATE --}}
        <div class="section-title">
            Receipt Information
        </div>

        <div class="info-box">

            <div class="row">

                <span class="label">
                    Receipt Generated
                </span>

                <span class="value">
                    {{
                        $booking->receipt_generated_at
                            ? $booking->receipt_generated_at->format('F d, Y h:i A')
                            : 'N/A'
                    }}
                </span>

            </div>

        </div>


        {{-- BUTTONS --}}
        <div class="buttons">

            <a
                href="{{ url('/my-bookings') }}"
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

</div>

</body>
</html>