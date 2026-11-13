<div style="overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f5f8fc; border-bottom: 2px solid #e1e9f0;">
                <th style="padding: 12px; text-align: left; font-size: 13px; color: #023e8a;">Date & Time</th>
                <th style="padding: 12px; text-align: left; font-size: 13px; color: #023e8a;">Admin</th>
                <th style="padding: 12px; text-align: left; font-size: 13px; color: #023e8a;">Action</th>
                <th style="padding: 12px; text-align: left; font-size: 13px; color: #023e8a;">Target ID</th>
                <th style="padding: 12px; text-align: left; font-size: 13px; color: #023e8a;">IP Address</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
                <tr style="border-bottom: 1px solid #edf1f5;">
                    <td style="padding: 12px; font-size: 14px; color: #333; white-space: nowrap;">
                        {{ $log->created_at->format('M d, Y h:i A') }}
                    </td>
                    <td style="padding: 12px; font-size: 14px; font-weight: bold; color: #333;">
                        {{ $log->user ? $log->user->name : 'System/Unknown' }}
                    </td>
                    <td style="padding: 12px; font-size: 14px;">
                        <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;
                            @if(str_contains($log->action, 'approve') || str_contains($log->action, 'verify')) background-color: #d1fae5; color: #065f46;
                            @elseif(str_contains($log->action, 'reject') || str_contains($log->action, 'cancel')) background-color: #fee2e2; color: #991b1b;
                            @else background-color: #dbeafe; color: #1e40af; @endif">
                            {{ strtoupper(str_replace('_', ' ', $log->action)) }}
                        </span>
                    </td>
                    <td style="padding: 12px; font-size: 14px; color: #666;">
                        {{ class_basename($log->model_type) }} #{{ $log->model_id ?? 'N/A' }}
                    </td>
                    <td style="padding: 12px; font-size: 14px; color: #666;">
                        {{ $log->ip_address ?? 'N/A' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="padding: 20px; text-align: center; color: #777;">No audit logs found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div style="margin-top: 20px;">
    {{ $logs->links() }}
</div>