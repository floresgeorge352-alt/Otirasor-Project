<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            font-size: 14px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #0077b6;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #0077b6;
            margin: 0;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .details {
            width: 100%;
            margin-bottom: 20px;
        }
        .details td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        .details td:first-child {
            font-weight: bold;
            width: 40%;
        }
        .total {
            margin-top: 20px;
            font-size: 16px;
            font-weight: bold;
            text-align: right;
            border-top: 2px solid #0077b6;
            padding-top: 10px;
        }
        .discount-line {
            font-size: 13px;
            font-weight: normal;
            color: #666;
            margin-bottom: 4px;
        }
        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Otirasor Beach and Resort</h1>
        <p>Electronic Receipt</p>
        <p>Receipt No: {{ $booking->receipt_number }}</p>
    </div>

    <table class="details">
        <tr>
            <td>Guest Name</td>
            <td>{{ $booking->guest_name }}</td>
        </tr>
        <tr>
            <td>Contact Number</td>
            <td>{{ $booking->contact_number }}</td>
        </tr>
        <tr>
            <td>Check-in</td>
            <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}</td>
        </tr>
        <tr>
            <td>Check-out</td>
            <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}</td>
        </tr>
        <tr>
            <td>Accommodations</td>
            <td>
                @php
                    $accNames = $booking->accommodations()->get()->pluck('name')->join(', ');
                @endphp

                @if($accNames !== '')
                    {{ $accNames }}
                @else
                    N/A (Old Booking)
                @endif
            </td>
        </tr>
        <tr>
            <td>Accommodation Total</td>
            <td>PHP {{ number_format($booking->accommodation_total, 2) }}</td>
        </tr>
        <tr>
            <td>Facility Total</td>
            <td>PHP {{ number_format($booking->facility_total, 2) }}</td>
        </tr>
    </table>

    @php
        $subTotal = ($booking->accommodation_total ?? 0) + ($booking->facility_total ?? 0);
        $promoDiscount = $booking->discount_amount ?? 0;
        $rewardDiscount = $booking->reward_discount ?? 0;
        $grandTotal = $subTotal - $promoDiscount - $rewardDiscount;
    @endphp

    <div class="total">
        @if($promoDiscount > 0 || $rewardDiscount > 0)
            <div class="discount-line">Subtotal: PHP {{ number_format($subTotal, 2) }}</div>
        @endif

        @if($promoDiscount > 0)
            <div class="discount-line">
                Promo Discount @if($booking->promo_code)({{ $booking->promo_code }})@endif: -PHP {{ number_format($promoDiscount, 2) }}
            </div>
        @endif

        @if($rewardDiscount > 0)
            <div class="discount-line">Rewards Discount: -PHP {{ number_format($rewardDiscount, 2) }}</div>
        @endif

        Total Amount: PHP {{ number_format($grandTotal, 2) }}
    </div>

    <div class="footer">
        <p>Thank you for booking with us!</p>
        <p>Generated on {{ $booking->receipt_generated_at->format('M d, Y h:i A') }}</p>
    </div>

</body>
</html>