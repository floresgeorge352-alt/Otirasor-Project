<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $booking->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #023e8a; margin-bottom: 5px; }
        .header p { color: #666; }
        .details { width: 100%; margin-bottom: 20px; }
        .details td { padding: 5px; vertical-align: top; }
        .details strong { color: #333; }
        table.items { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.items th, table.items td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        table.items th { background: #f4f6f8; color: #023e8a; }
        .totals { width: 100%; text-align: right; }
        .totals td { padding: 5px; }
        .grand-total { font-size: 16px; font-weight: bold; color: #059669; }
        .footer { margin-top: 40px; text-align: center; font-size: 10px; color: #888; }
        .status-box { background: #fef3c7; color: #92400e; padding: 10px; text-align: center; border-radius: 5px; margin-bottom: 20px; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Otirasor Beach and Resort</h1>
        <p>Billing Statement / Invoice</p>
    </div>

    @if($booking->status !== 'Confirmed')
        <div class="status-box">
            STATUS: {{ strtoupper($booking->status) }} - NOT YET CONFIRMED
        </div>
    @endif

    <table class="details">
        <tr>
            <td>
                <strong>Invoice No:</strong> INV-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}<br>
                <strong>Date Issued:</strong> {{ now()->format('F j, Y') }}<br>
                <strong>Booking Ref:</strong> #{{ $booking->id }}
            </td>
            <td>
                <strong>Billed To:</strong><br>
                {{ $booking->guest_name }}<br>
                {{ $booking->contact_number }}
            </td>
            <td>
                <strong>Check-in:</strong> {{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}<br>
                <strong>Check-out:</strong> {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}<br>
                <strong>Guests:</strong> {{ $booking->number_of_guests }}
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @php
                $itemsFound = false;
            @endphp
            
            @if(is_object($booking->accommodations) && !$booking->accommodations->isEmpty())
                @foreach($booking->accommodations as $acc)
                    <tr>
                        <td>{{ $acc->name ?? 'Accommodation' }}</td>
                        <td>PHP {{ number_format($acc->pivot->price_at_booking ?? 0, 2) }}</td>
                    </tr>
                @endforeach
                @php $itemsFound = true; @endphp
            @elseif(is_string($booking->accommodations) && trim($booking->accommodations) !== '')
                <tr>
                    <td>{{ $booking->accommodations }}</td>
                    <td>PHP {{ number_format($booking->accommodation_total ?? 0, 2) }}</td>
                </tr>
                @php $itemsFound = true; @endphp
            @endif

            @if(!$itemsFound)
                <tr>
                    <td>Accommodation</td>
                    <td>PHP {{ number_format($booking->accommodation_total ?? 0, 2) }}</td>
                </tr>
            @endif

            @if(($booking->facility_total ?? 0) > 0)
                <tr>
                    <td>Beach Entrance & Swimming Pool Facilities</td>
                    <td>PHP {{ number_format($booking->facility_total, 2) }}</td>
                </tr>
            @endif
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td>Accommodation Total:</td>
            <td>PHP {{ number_format($booking->accommodation_total ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td>Facility Total:</td>
            <td>PHP {{ number_format($booking->facility_total ?? 0, 2) }}</td>
        </tr>
        <tr class="grand-total">
            <td>Grand Total:</td>
            <td>PHP {{ number_format(($booking->accommodation_total ?? 0) + ($booking->facility_total ?? 0), 2) }}</td>
        </tr>
    </table>

    <div class="footer">
        This is a system-generated invoice. Please settle payment via GCash to confirm your booking.<br>
        GCash: 09945598510 (Otirasor Beach)
    </div>

</body>
</html>