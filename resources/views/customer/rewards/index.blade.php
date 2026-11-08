<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Rewards</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: #f4f6f8; padding: 30px; }
        .container { max-width: 1000px; margin: 0 auto; }
        .header { margin-bottom: 25px; }
        .header h1 { color: #023e8a; font-size: 28px; margin-bottom: 5px; }
        .header p { color: #64748b; }

        .balance-card { background: linear-gradient(135deg, #023e8a, #0077b6); color: white; padding: 30px; border-radius: 16px; margin-bottom: 25px; text-align: center; box-shadow: 0 10px 30px rgba(2, 62, 138, 0.2); }
        .balance-card .label { font-size: 14px; opacity: 0.9; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 2px; }
        .balance-card .value { font-size: 56px; font-weight: 800; }
        .balance-card .sub { font-size: 13px; opacity: 0.8; margin-top: 5px; }

        .stats-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 25px; }
        .stat-card { background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb; text-align: center; }
        .stat-label { font-size: 12px; color: #64748b; text-transform: uppercase; margin-bottom: 5px; }
        .stat-value { font-size: 24px; font-weight: 700; }
        .stat-value.green { color: #10b981; }
        .stat-value.red { color: #ef4444; }

        .history-card { background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden; }
        .history-card h2 { padding: 20px; color: #023e8a; border-bottom: 1px solid #e5e7eb; }
        .history-table { width: 100%; border-collapse: collapse; }
        .history-table th { background: #f8fafc; padding: 12px 15px; text-align: left; font-size: 12px; text-transform: uppercase; color: #64748b; }
        .history-table td { padding: 15px; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
        .points-plus { color: #10b981; font-weight: 700; }
        .points-minus { color: #ef4444; font-weight: 700; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .badge-earned { background: #d1fae5; color: #065f46; }
        .badge-redeemed { background: #fee2e2; color: #991b1b; }
        .badge-bonus { background: #dbeafe; color: #1e40af; }

        .empty { text-align: center; padding: 40px; color: #94a3b8; }
        .back-btn { display: inline-block; margin-bottom: 15px; background: #6c757d; color: white; text-decoration: none; padding: 10px 16px; border-radius: 8px; font-weight: 600; }
        .back-btn:hover { background: #5a6268; }

        @media (max-width: 600px) {
            .stats-grid { grid-template-columns: 1fr; }
            .balance-card .value { font-size: 42px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="/dashboard" class="back-btn">← Back to Dashboard</a>

        <div class="header">
            <h1>🎁 My Rewards</h1>
            <p>Earn points by reviewing your stays. Redeem them for discounts on future bookings.</p>
        </div>

        <div class="balance-card">
            <div class="label">My Points Balance</div>
            <div class="value">{{ number_format($balance) }}</div>
            <div class="sub">100 points = ₱5 discount</div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Earned</div>
                <div class="stat-value green">+{{ number_format($totalEarned) }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Redeemed</div>
                <div class="stat-value red">{{ number_format($totalRedeemed) }}</div>
            </div>
        </div>

        <div class="history-card">
            <h2>📜 Points History</h2>
            @if($history->count() > 0)
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th style="text-align: right;">Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($history as $h)
                            <tr>
                                <td>{{ $h->created_at->format('M d, Y g:i A') }}</td>
                                <td>
                                    @if($h->type === 'earned_review')
                                        <span class="badge badge-earned">Review</span>
                                    @elseif($h->type === 'earned_booking')
                                        <span class="badge badge-earned">Booking</span>
                                    @elseif($h->type === 'redeemed_discount')
                                        <span class="badge badge-redeemed">Redeemed</span>
                                    @elseif(str_starts_with($h->type, 'admin_'))
                                        <span class="badge badge-bonus">Admin</span>
                                    @else
                                        <span class="badge">{{ $h->type }}</span>
                                    @endif
                                </td>
                                <td>{{ $h->description }}</td>
                                <td style="text-align: right;" class="{{ $h->points > 0 ? 'points-plus' : 'points-minus' }}">
                                    {{ $h->points > 0 ? '+' : '' }}{{ number_format($h->points) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="padding: 15px;">{{ $history->links() }}</div>
            @else
                <div class="empty">
                    <p>No points history yet.</p>
                    <p>Submit a review after your stay to earn 5 points!</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>