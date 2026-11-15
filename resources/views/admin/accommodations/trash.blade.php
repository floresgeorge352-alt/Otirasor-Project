<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trash - Accommodations</title>
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
            <a href="/admin/accommodations">🏨 Accommodations</a>
        </div>
    </nav>

    <div class="container">
        <a href="/admin/accommodations" class="back-btn">← Back to Accommodations</a>
        <h1>🗑️ Trashed Accommodations</h1>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if($accommodations->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Deleted At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($accommodations as $acc)
                        <tr>
                            <td>{{ $acc->name }}</td>
                            <td>{{ $acc->type }}</td>
                            <td>₱{{ number_format($acc->price, 2) }}</td>
                            <td>{{ $acc->deleted_at->format('M d, Y h:i A') }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.accommodations.restore', $acc->id) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-restore">♻️ Restore</button>
                                </form>
                                <form method="POST" action="{{ route('admin.accommodations.force-delete', $acc->id) }}" style="display: inline;" onsubmit="return confirm('Permanently delete this item? This cannot be undone!');">
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
                <h2>🗑️ No trashed accommodations.</h2>
                <p>Deleted accommodations will appear here.</p>
            </div>
        @endif
    </div>
</body>
</html>