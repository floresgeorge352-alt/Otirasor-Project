<tbody id="employee-table-body">
    @forelse($employees as $employee)
        <tr>
            <td>
                <span class="number">
                    {{ $employees->firstItem() + $loop->index }}
                </span>
            </td>
            <td><span class="employee-name">{{ $employee->name }}</span></td>
            <td><span class="email">{{ $employee->email }}</span></td>
            <td><span class="role">👤 Employee</span></td>
            <td>
                @if($employee->status === 'Active')
                    <span class="status status-active">● Active</span>
                @else
                    <span class="status status-inactive">● Inactive</span>
                @endif
            </td>
            <td>
                <button
                    type="button"
                    class="qr-btn"
                    onclick="showQrCode(
                        {{ Js::from((string) $employee->id) }},
                        {{ Js::from($employee->name) }}
                    )"
                >
                    📱 QR Code
                </button>
            </td>
            <td>
                <div class="actions">
                    <a
                        href="{{ route('admin.employees.edit', $employee) }}"
                        class="edit-btn"
                    >
                        ✏️ Edit
                    </a>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" style="text-align: center; padding: 30px; color: #6b7280;">
                No employees match your search or filter.
            </td>
        </tr>
    @endforelse
</tbody>