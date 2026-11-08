<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rewards History - {{ $user->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: #f4f6f8; padding: 30px; }
        .container { max-width: 900px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .header h1 { color: #023e8a; font-size: 24px; }
        .back-btn { background: #6c757d; color: white; text-decoration: none; padding: 10px 16px; border-radius: 8px; font-weight: 600; }
        .back-btn:hover { background: #5a6268; }

        .card { background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f8fafc; padding: 12px 15px; text-align: left; font-size: 12px; text-transform: uppercase; color: #64748b; }
        td { padding: 15px; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
        .points-plus { color: #10b981; font-weight: 700; }
        .points-minus { color: #ef4444; font-weight: 700; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📜 {{ $user->name }}'s Points History</h1>
            <a href="/admin/rewards" class="back-btn">← Back</a>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th style="text-align: right;">Points</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history as $h)
                        <tr>
                            <td>{{ $h->created_at->format('M d, Y g:i A') }}</td>
                            <td>{{ $h->type }}</td>
                            <td>{{ $h->description }}</td>
                            <td style="text-align: right;" class="{{ $h->points > 0 ? 'points-plus' : 'points-minus' }}">
                                {{ $h->points > 0 ? '+' : '' }}{{ number_format($h->points) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 40px; color: #94a3b8;">No history yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div style="padding: 15px;">{{ $history->links() }}</div>
        </div>
    </div>
</body>
</html>