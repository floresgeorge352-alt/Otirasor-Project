<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotions - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: #f4f7fb; padding: 30px; }
        .container { max-width: 900px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .header h1 { color: #023e8a; font-size: 28px; }
        .back-btn { background: #6c757d; color: white; text-decoration: none; padding: 10px 18px; border-radius: 6px; font-weight: bold; }
        
        .card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.05); margin-bottom: 25px; }
        .card h2 { color: #023e8a; margin-bottom: 15px; font-size: 20px; }
        
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .form-group { display: flex; flex-direction: column; }
        .form-group.full { grid-column: 1 / -1; }
        .form-group label { font-weight: 600; font-size: 14px; margin-bottom: 5px; }
        .form-group input { padding: 10px; border: 1px solid #ccc; border-radius: 6px; outline: none; }
        .form-group input:focus { border-color: #0077b6; }
        
        .btn-submit { grid-column: 1 / -1; padding: 12px; background: #10b981; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; margin-top: 10px; }
        .btn-submit:hover { background: #059669; }

        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; font-size: 14px; }
        th { background: #f8fcfd; color: #023e8a; }
        
        .badge { padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .badge-active { background: #e6f7ef; color: #168a4a; }
        .badge-inactive { background: #ffe8ec; color: #b52d43; }
        
        .action-btn { padding: 6px 12px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 12px; color: white; margin-right: 5px; text-decoration: none; display: inline-block; }
        .btn-toggle { background: #f59e0b; }
        .btn-delete { background: #ef4444; }
        
        .success { background: #d1e7dd; color: #0f5132; padding: 12px; border-radius: 6px; margin-bottom: 15px; font-weight: bold; }
        .error { background: #f8d7da; color: #842029; padding: 12px; border-radius: 6px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎟️ Promotions & Discounts</h1>
            <a href="/admin/dashboard" class="back-btn">← Back to Dashboard</a>
        </div>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="card">
            <h2>Create New Promotion</h2>
            <form method="POST" action="/admin/promotions">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label>Promo Code (e.g., SUMMER10)</label>
                        <input type="text" name="code" required placeholder="SUMMER10" style="text-transform: uppercase;">
                    </div>
                    <div class="form-group">
                        <label>Discount Percentage (%)</label>
                        <input type="number" name="discount_percentage" min="1" max="100" step="0.01" required placeholder="10">
                    </div>
                    <div class="form-group">
                        <label>Valid Until</label>
                        <input type="date" name="valid_until" required>
                    </div>
                    <div class="form-group">
                        <label>Description (Optional)</label>
                        <input type="text" name="description" placeholder="Summer promo discount">
                    </div>
                    <button type="submit" class="btn-submit">Create Promotion</button>
                </div>
            </form>
        </div>

        <div class="card">
            <h2>Active & Inactive Promotions</h2>
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Discount</th>
                        <th>Valid Until</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($promotions as $promo)
                        <tr>
                            <td><strong>{{ $promo->code }}</strong><br><small style="color:#666;">{{ $promo->description }}</small></td>
                            <td>{{ $promo->discount_percentage }}%</td>
                            <td>{{ $promo->valid_until->format('M d, Y') }}</td>
                            <td>
                                @if($promo->is_active && $promo->valid_until->isFuture())
                                    <span class="badge badge-active">Active</span>
                                @else
                                    <span class="badge badge-inactive">Inactive/Expired</span>
                                @endif
                            </td>
                            <td>
                                <form action="/admin/promotions/{{ $promo->id }}/toggle" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="action-btn btn-toggle">
                                        {{ $promo->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                                <form action="/admin/promotions/{{ $promo->id }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this promo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; padding: 20px;">No promotions created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>