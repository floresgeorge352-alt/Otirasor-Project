<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trash - Promotions</title>
    @vite(['resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f7fa; color: #1f2937; }
        nav { background: #ffffff; border-bottom: 1px solid #e5e7eb; padding: 15px 40px; display: flex; justify-content: space-between; align-items: center; }
        .nav-brand img { width: 48px; }
        .nav-links a { color: #374151; text-decoration: none; padding: 9px 13px; font-weight: 600; }
        .container { max-width: 1100px; margin: 35px auto; padding: 0 20px; }
        h1 { color: #023e8a; margin-bottom: 20px; }
        .back-btn { display: inline-block; background: #ffffff; color: #0077b6; border: 1px solid #dbeafe; padding: 10px 16px; border-radius: 8px; text-decoration: none; margin-bottom: 20px; font-weight: 600; }
        table { width: 100%; background: #ffffff; border-collapse: collapse; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        th { background: #f8fafc; color: #023e8a; padding: 14px; text-align: left; font-size: 13px; text-transform: uppercase; }
        td { padding: 14px; border-bottom: 1px solid #f1f5f9; }
        .btn-restore { background: #10b981; color: white; padding: 8px 14px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; }
        .btn-force { background: #ef4444; color: white; padding: 8px 14px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; }
        .success { background: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 15px; }
        .empty { background: #ffffff; padding: 50px; text-align: center; border-radius: 12px; }
    </style>
</head>
<body>
    <nav>
        <div class="nav-brand">
            <img src="{{ asset('images/otirasor-logo.png') }}" alt="Logo">
        </div>
        <div class="nav-links">
            <a href="/admin/dashboard">🏠 Dashboard</a>
            <a href="/admin/promotions">🎟️ Promotions</a>
        </div>
    </nav>

    <div class="container">
        <a href="/admin/promotions" class="back-btn">← Back to Promotions</a>
        <h1>🗑️ Trashed Promotions</h1>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if($promotions->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Discount</th>
                        <th>Valid Until</th>
                        <th>Deleted At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($promotions as $promo)
                        <tr>
                            <td><strong>{{ $promo->code }}</strong></td>
                            <td>{{ $promo->discount_percentage }}%</td>
                            <td>{{ $promo->valid_until->format('M d, Y') }}</td>
                            <td>{{ $promo->deleted_at->format('M d, Y h:i A') }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.promotions.restore', $promo->id) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-restore">♻️ Restore</button>
                                </form>
                                <form method="POST" action="{{ route('admin.promotions.force-delete', $promo->id) }}" style="display: inline;" onsubmit="return confirm('Permanently delete this promotion? This cannot be undone!');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-force">❌ Force Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty">
                <h2>🗑️ No trashed promotions.</h2>
                <p>Deleted promotions will appear here.</p>
            </div>
        @endif
    </div>
</body>
</html>