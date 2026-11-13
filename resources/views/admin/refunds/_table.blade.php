<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Date Processed</th>
                <th>Booking ID</th>
                <th>Guest Name</th>
                <th>Amount</th>
                @if($filter === 'rejected')
                    <th>Reason for Rejection</th>
                @else
                    <th>GCash Ref</th>
                    <th>Message to Customer</th>
                    <th>Proof of Refund</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($refunds as $refund)
                <tr>
                    <td>
                        @if($refund->refunded_at)
                            {{ \Carbon\Carbon::parse($refund->refunded_at)->format('M d, Y h:i A') }}
                        @else
                            {{ \Carbon\Carbon::parse($refund->updated_at)->format('M d, Y h:i A') }}
                        @endif
                    </td>
                    <td><strong>#{{ $refund->id }}</strong></td>
                    <td>{{ $refund->guest_name }}</td>
                    <td style="font-weight: 700; color: #059669;">
                        ₱{{ number_format($refund->net_total, 2) }}
                    </td>

                    @if($filter === 'rejected')
                        <td style="color: #dc2626;">{{ $refund->refund_notes ?? 'No reason provided.' }}</td>
                    @else
                        <td>{{ $refund->refund_reference ?? '—' }}</td>
                        <td>{{ $refund->refund_message ?? '—' }}</td>
                        <td>
                            @if($refund->refund_proof)
                                <a href="{{ asset('storage/' . $refund->refund_proof) }}" target="_blank" class="proof-btn">📄 View Proof</a>
                            @else
                                <span class="no-proof">No File</span>
                            @endif
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: #6b7280;">
                        <strong>No {{ $filter === 'rejected' ? 'rejected' : 'successful' }} refunds found.</strong><br>
                        @if($search ?? '')
                            No results match your search: "{{ $search }}"
                        @endif
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pagination-wrapper">
    {{ $refunds->links() }}
</div>