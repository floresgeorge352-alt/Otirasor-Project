<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bookings Report</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #1f2937; padding: 20px; }
        h1 { color: #023e8a; font-size: 20px; margin-bottom: 5px; }
        p { color: #6b7280; font-size: 11px; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #0077b6; color: white; padding: 8px; text-align: left; font-size: 10px; text-transform: uppercase; }
        td { padding: 8px; border-bottom: 1px solid #e5e7eb; font-size: 10px; }
        tr:nth-child(even) td { background: #f8fafc; }
        .status { padding: 3px 6px; border-radius: 8px; font-size: 9px; font-weight: bold; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #d4edda; color: #155724; }
        .status-cancelled { background: #e2e3e5; color: #383d41; }
        .status-rejected { background: #f8d7da; color: #721c24; }
        .status-other { background: #e0f2fe; color: #075985; }
    </style>
</head>
<body>
    <h1>Bookings Report</h1>
    <p>Generated on: {{ now()->format('F d, Y h:i A') }} | Total: {{ $bookings->count() }} bookings</p>

    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Guest Name</th>
                <th>Accommodation</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Guests</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $b)
                @php
                    $grandTotal = ($b->accommodation_total ?? 0) + ($b->facility_total ?? 0) - ($b->discount_amount ?? 0) - ($b->reward_discount ?? 0);
                    
                    $statusClass = match ($b->status) {
                        'Pending' => 'status-pending',
                        'Confirmed' => 'status-confirmed',
                        'Cancelled' => 'status-cancelled',
                        'Rejected' => 'status-rejected',
                        default => 'status-other',
                    };
                @endphp
                <tr>
                    <td>#{{ $b->id }}</td>
                    <td>{{ $b->guest_name }}</td>
                    <td>{{ $b->accommodations }}</td>
                    <td>{{ $b->check_in }}</td>
                    <td>{{ $b->check_out }}</td>
                    <td>{{ $b->number_of_guests }}</td>
                    <td>{{ $b->payment_method }}</td>
                    <td><span class="status {{ $statusClass }}">{{ $b->status }}</span></td>
                    <td>₱{{ number_format($grandTotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>