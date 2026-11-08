<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Transaction Report</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 10px; color: #1f2937; padding: 20px; }
        h1 { color: #023e8a; font-size: 18px; margin-bottom: 4px; }
        .subtitle { color: #64748b; font-size: 11px; margin-bottom: 20px; }
        .summary-box { display: flex; justify-content: space-between; gap: 12px; margin-bottom: 20px; }
        .summary-card { flex: 1; padding: 12px; border-radius: 6px; text-align: center; }
        .summary-card .label { font-size: 9px; text-transform: uppercase; font-weight: bold; margin-bottom: 4px; }
        .summary-card .value { font-size: 16px; font-weight: bold; }
        .revenue { background: #eff6ff; border: 1px solid #bfdbfe; }
        .revenue .label { color: #1e40af; }
        .revenue .value { color: #023e8a; }
        .refunds { background: #fef2f2; border: 1px solid #fecaca; }
        .refunds .label { color: #991b1b; }
        .refunds .value { color: #dc2626; }
        .net { background: #ecfdf5; border: 1px solid #bbf7d0; }
        .net .label { color: #166534; }
        .net .value { color: #059669; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        thead { background: #023e8a; color: #ffffff; }
        th { padding: 6px 8px; text-align: left; font-size: 9px; text-transform: uppercase; font-weight: bold; }
        td { padding: 6px 8px; border-bottom: 1px solid #e5e7eb; font-size: 9px; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 8px; font-size: 8px; font-weight: bold; }
        .badge-confirmed { background: #d4edda; color: #155724; }
        .badge-checked-in { background: #cfe2ff; color: #084298; }
        .badge-checked-out { background: #e0cffc; color: #432874; }
        .badge-completed { background: #d1e7dd; color: #0f5132; }
        .badge-cancelled { background: #e2e3e5; color: #383d41; }
        .footer { margin-top: 20px; text-align: center; color: #94a3b8; font-size: 8px; }
        .empty { text-align: center; padding: 40px; color: #94a3b8; font-style: italic; }
    </style>
</head>
<body>

    <h1>Transaction Report</h1>
    <div class="subtitle">
        {{ $monthName }} {{ $year }}
        @if($search !== '')
            &middot; Search: "{{ $search }}"
        @endif
        &middot; Generated: {{ now()->format('M d, Y g:i A') }}
    </div>

    <div class="summary-box">
        <div class="summary-card revenue">
            <div class="label">Total Revenue</div>
            <div class="value">₱{{ number_format($totalRevenue, 2) }}</div>
        </div>
        <div class="summary-card refunds">
            <div class="label">Total Refunds</div>
            <div class="value">₱{{ number_format($totalRefunds, 2) }}</div>
        </div>
        <div class="summary-card net">
            <div class="label">Net Income</div>
            <div class="value">₱{{ number_format($netIncome, 2) }}</div>
        </div>
    </div>

    @if($transactions->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Booking #</th>
                    <th>Guest Name</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th class="text-right">Subtotal</th>
                    <th class="text-right">Discount</th>
                    <th class="text-right">Total Paid</th>
                    <th class="text-center">Refund</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $t)
                    @php
                        $subtotal = (float) ($t->accommodation_total ?? 0) + (float) ($t->facility_total ?? 0);
                        $discount = (float) ($t->discount_amount ?? 0);
                        $total = $t->net_total;

                        $statusClass = match($t->status) {
                            'Confirmed' => 'badge-confirmed',
                            'Checked In' => 'badge-checked-in',
                            'Checked Out' => 'badge-checked-out',
                            'Completed' => 'badge-completed',
                            'Cancelled' => 'badge-cancelled',
                            default => '',
                        };
                    @endphp
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($t->check_in)->format('M d, Y') }}</td>
                        <td>#{{ $t->id }}</td>
                        <td>{{ $t->guest_name }}</td>
                        <td>{{ $t->payment_method }}</td>
                        <td>
                            <span class="badge {{ $statusClass }}">{{ $t->status }}</span>
                        </td>
                        <td class="text-right">₱{{ number_format($subtotal, 2) }}</td>
                        <td class="text-right">
                            @if($discount > 0)
                                - ₱{{ number_format($discount, 2) }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="text-right"><strong>₱{{ number_format($total, 2) }}</strong></td>
                        <td class="text-center">{{ $t->refund_status ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty">No transactions found for this period.</div>
    @endif

    <div class="footer">
        Otirasor Beach and Resort &middot; Transaction Report &middot; {{ $monthName }} {{ $year }}
    </div>

</body>
</html>