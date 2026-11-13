<table>
    <thead>
        <tr>
            <th>Employee</th>
            <th>Date</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Late</th>
            <th>Undertime</th>
            <th>Overtime</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @php
            $formatDuration = function ($minutes) {
                $minutes = (int) $minutes;
                if ($minutes <= 0) return '—';
                $hours = intdiv($minutes, 60);
                $remainingMinutes = $minutes % 60;
                $parts = [];
                if ($hours > 0) $parts[] = $hours . ' ' . ($hours === 1 ? 'hour' : 'hours');
                if ($remainingMinutes > 0) $parts[] = $remainingMinutes . ' ' . ($remainingMinutes === 1 ? 'minute' : 'minutes');
                return implode(' ', $parts);
            };
        @endphp

        @forelse ($attendances as $attendance)
            <tr>
                <td>{{ $attendance->user->name ?? 'Unknown Employee' }}</td>
                <td>{{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}</td>
                <td>
                    @if ($attendance->time_in)
                        {{ \Carbon\Carbon::parse($attendance->time_in)->format('h:i A') }}
                    @else
                        —
                    @endif
                </td>
                <td>
                    @if ($attendance->time_out)
                        {{ \Carbon\Carbon::parse($attendance->time_out)->format('h:i A') }}
                    @else
                        —
                    @endif
                </td>
                <td class="duration">
                    @if (($attendance->late_minutes ?? 0) > 0)
                        {{ $formatDuration($attendance->late_minutes) }} late
                    @else
                        —
                    @endif
                </td>
                <td class="duration">
                    @if (($attendance->undertime_minutes ?? 0) > 0)
                        {{ $formatDuration($attendance->undertime_minutes) }} undertime
                    @else
                        —
                    @endif
                </td>
                <td>
                    @if (($attendance->overtime_minutes ?? 0) > 0)
                        <div class="duration">
                            {{ $formatDuration($attendance->overtime_minutes) }}
                        </div>

                        @php
                            $overtimeStatus = $attendance->overtime_status ?? 'Not Requested';
                            $overtimeStatusClass = match ($overtimeStatus) {
                                'Approved' => 'approved',
                                'Rejected' => 'rejected',
                                default => '',
                            };
                        @endphp

                        <small class="overtime-status {{ $overtimeStatusClass }}">
                            {{ $overtimeStatus }}
                        </small>

                        @if ($overtimeStatus === 'Pending Approval')
                            <div class="overtime-actions">
                                <form method="POST" action="{{ route('admin.attendance.approve-overtime', $attendance->id) }}" onsubmit="return confirm('Approve this overtime record?')">
                                    @csrf
                                    <button type="submit" class="approve-button">Approve</button>
                                </form>
                                <form method="POST" action="{{ route('admin.attendance.reject-overtime', $attendance->id) }}" onsubmit="return confirm('Reject this overtime record?')">
                                    @csrf
                                    <button type="submit" class="reject-button">Reject</button>
                                </form>
                            </div>
                        @endif
                    @else
                        —
                    @endif
                </td>
                <td class="status {{ strtolower($attendance->status ?? '') === 'present' ? 'present' : 'absent' }}">
                    {{ $attendance->status ?? 'Unknown' }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="empty">No attendance records found.</td>
            </tr>
        @endforelse
    </tbody>
</table>