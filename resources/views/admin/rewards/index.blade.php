<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Rewards Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: #f4f6f8; padding: 30px; }
        .container { max-width: 1100px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .header h1 { color: #023e8a; font-size: 26px; }
        .back-btn { background: #6c757d; color: white; text-decoration: none; padding: 10px 16px; border-radius: 8px; font-weight: 600; }
        .back-btn:hover { background: #5a6268; }

        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 25px; }
        .stat-card { background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb; text-align: center; }
        .stat-label { font-size: 12px; color: #64748b; text-transform: uppercase; margin-bottom: 5px; }
        .stat-value { font-size: 26px; font-weight: 700; color: #023e8a; }

        .filter-bar { background: white; padding: 15px; border-radius: 12px; margin-bottom: 20px; border: 1px solid #e5e7eb; display: flex; gap: 10px; }
        .filter-bar input { flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 8px; font-family: 'Poppins', sans-serif; }
        .filter-bar button { background: #023e8a; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; }

        .customers-card { background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden; }
        .customers-table { width: 100%; border-collapse: collapse; }
        .customers-table th { background: #f8fafc; padding: 12px 15px; text-align: left; font-size: 12px; text-transform: uppercase; color: #64748b; }
        .customers-table td { padding: 15px; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
        .points-value { font-weight: 700; color: #10b981; font-size: 18px; }

        .btn-sm { padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 600; border: none; cursor: pointer; }
        .btn-primary { background: #023e8a; color: white; }
        .btn-primary:hover { background: #0077b6; }
        .btn-secondary { background: #f1f5f9; color: #334155; }
        .btn-secondary:hover { background: #e2e8f0; }

        .alert { padding: 12px 18px; border-radius: 8px; margin-bottom: 15px; font-weight: 600; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; justify-content: center; align-items: center; }
        .modal.open { display: flex; }
        .modal-content { background: white; padding: 30px; border-radius: 12px; max-width: 450px; width: 90%; }
        .modal-content h2 { color: #023e8a; margin-bottom: 15px; }
        .modal-content input, .modal-content textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 8px; margin-bottom: 10px; font-family: 'Poppins', sans-serif; }
        .modal-content .modal-actions { display: flex; gap: 10px; margin-top: 10px; }

        @media (max-width: 768px) {
            .stats-grid { grid-template-columns: 1fr; }
            .filter-bar { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎁 Rewards Management</h1>
            <a href="/admin/dashboard" class="back-btn">← Back to Dashboard</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Points Issued</div>
                <div class="stat-value">{{ number_format($totalPointsIssued) }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Points Redeemed</div>
                <div class="stat-value">{{ number_format($totalPointsRedeemed) }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Active Customers</div>
                <div class="stat-value">{{ number_format($activeCustomers) }}</div>
            </div>
        </div>

        <form method="GET" action="/admin/rewards" class="filter-bar">
            <input type="text" name="search" value="{{ $search }}" placeholder="Search by customer name...">
            <button type="submit">Search</button>
        </form>

        <div class="customers-card">
            <table class="customers-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Email</th>
                        <th style="text-align: right;">Points Balance</th>
                        <th style="text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr>
                            <td><strong>{{ $customer->name }}</strong></td>
                            <td>{{ $customer->email }}</td>
                            <td style="text-align: right;" class="points-value">{{ number_format($customer->reward_points) }}</td>
                            <td style="text-align: center;">
                                <a href="/admin/rewards/{{ $customer->id }}/history" class="btn-sm btn-secondary">History</a>
                                <button class="btn-sm btn-primary" onclick="openAdjustModal({{ $customer->id }}, '{{ $customer->name }}')">Adjust</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 40px; color: #94a3b8;">
                                No customers with reward points yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div style="padding: 15px;">{{ $customers->links() }}</div>
        </div>
    </div>

    <!-- ADJUST MODAL -->
    <div class="modal" id="adjustModal">
        <div class="modal-content">
            <h2>Adjust Points: <span id="modalCustomerName"></span></h2>
            <form method="POST" id="adjustForm">
                @csrf
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Points (use negative for deduction)</label>
                <input type="number" name="points" required placeholder="e.g. 100 or -50">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Reason</label>
                <textarea name="reason" required rows="3" placeholder="e.g. Bonus for loyalty, correction..."></textarea>
                <div class="modal-actions">
                    <button type="submit" class="btn-sm btn-primary">Apply</button>
                    <button type="button" class="btn-sm btn-secondary" onclick="closeAdjustModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAdjustModal(userId, userName) {
            document.getElementById('modalCustomerName').textContent = userName;
            document.getElementById('adjustForm').action = '/admin/rewards/' + userId + '/adjust';
            document.getElementById('adjustModal').classList.add('open');
        }
        function closeAdjustModal() {
            document.getElementById('adjustModal').classList.remove('open');
        }
    </script>
</body>
</html>