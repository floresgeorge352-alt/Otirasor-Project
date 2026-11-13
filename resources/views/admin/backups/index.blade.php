<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Database Backups</title>

    @vite(['resources/js/app.js'])

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            color: #1f2937;
        }

        nav {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .nav-brand { display: flex; align-items: center; gap: 12px; }
        .nav-brand img { width: 48px; height: 48px; object-fit: contain; }
        .nav-title { display: flex; flex-direction: column; gap: 3px; }
        .nav-title strong { color: #023e8a; font-size: 18px; }
        .nav-title span { color: #6b7280; font-size: 12px; }
        .nav-links { display: flex; align-items: center; gap: 8px; }
        nav a {
            color: #374151;
            text-decoration: none;
            padding: 9px 13px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
        }
        nav a:hover { background: #eff6ff; color: #0077b6; }
        .logout-btn {
            background: none; border: none; color: #374151;
            padding: 9px 13px; border-radius: 8px;
            font-size: 14px; font-weight: 600; cursor: pointer;
            font-family: Arial, sans-serif;
        }
        .logout-btn:hover { background: #fff1f2; color: #c62828; }

        .container { max-width: 1150px; margin: 35px auto; padding: 0 20px 40px; }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 20px;
            margin-bottom: 22px;
        }
        .page-header-left h1 { color: #023e8a; font-size: 30px; margin-bottom: 7px; }
        .page-header-left p { color: #6b7280; font-size: 14px; }
        .back-btn {
            display: inline-flex; align-items: center; gap: 7px;
            background: #ffffff; color: #0077b6;
            border: 1px solid #dbeafe; text-decoration: none;
            padding: 10px 16px; border-radius: 9px;
            font-weight: 600; font-size: 14px;
        }
        .back-btn:hover { background: #eff6ff; }

        .success {
            background: #ecfdf3; color: #166534;
            border: 1px solid #bbf7d0;
            padding: 13px 16px; border-radius: 9px;
            margin-bottom: 18px;
        }
        .error {
            background: #fff1f2; color: #991b1b;
            border: 1px solid #fecaca;
            padding: 13px 16px; border-radius: 9px;
            margin-bottom: 18px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 22px;
        }
        .stat-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 16px 18px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.05);
        }
        .stat-label {
            color: #9ca3af;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 6px;
        }
        .stat-value {
            color: #023e8a;
            font-size: 22px;
            font-weight: bold;
        }
        .stat-value.green { color: #2e7d32; }
        .stat-value.red   { color: #c62828; }

        .actions-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
            margin-bottom: 18px;
        }

        .btn-primary {
            background: #0077b6;
            color: #ffffff;
            border: none;
            padding: 11px 20px;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-primary:hover { background: #005f8f; }

        .search-box {
            display: flex;
            gap: 8px;
            flex: 1;
            min-width: 240px;
        }
        .search-box input {
            flex: 1;
            padding: 10px 14px;
            border: 1px solid #dbe5ef;
            border-radius: 9px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            outline: none;
        }
        .search-box input:focus { border-color: #0077b6; }
        .search-box button {
            background: #ffffff;
            color: #0077b6;
            border: 1px solid #dbeafe;
            padding: 10px 18px;
            border-radius: 9px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
        }
        .search-box button:hover { background: #eff6ff; }

        .table-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.05);
        }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #f8fafc; }
        th {
            text-align: left;
            padding: 13px 14px;
            font-size: 12px;
            text-transform: uppercase;
            color: #6b7280;
            font-weight: bold;
            border-bottom: 1px solid #e5e7eb;
        }
        td {
            padding: 13px 14px;
            font-size: 14px;
            color: #374151;
            border-bottom: 1px solid #f1f5f9;
        }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #fafcff; }

        .badge {
            display: inline-block;
            padding: 5px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-failed  { background: #f8d7da; color: #721c24; }
        .badge-progress{ background: #fff3cd; color: #856404; }
        .badge-auto    { background: #e0f2fe; color: #0369a1; }
        .badge-manual  { background: #ede9fe; color: #6d28d9; }

        .action-link {
            color: #0077b6;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            margin-right: 10px;
            cursor: pointer;
            background: none;
            border: none;
            font-family: Arial, sans-serif;
        }
        .action-link:hover { text-decoration: underline; }
        .action-link.danger { color: #c62828; }
        .action-link.warn   { color: #ea580c; }

        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: #9ca3af;
        }
        .empty-state strong {
            display: block;
            color: #374151;
            font-size: 18px;
            margin-bottom: 8px;
        }

        .pagination { margin-top: 20px; }

        @media (max-width: 800px) {
            nav { padding: 14px 20px; flex-direction: column; align-items: flex-start; }
            .nav-links { width: 100%; flex-wrap: wrap; }
            .container { margin: 25px auto; padding: 0 15px 30px; }
            .stats { grid-template-columns: repeat(2, 1fr); }
            .page-header { flex-direction: column; align-items: flex-start; }
            .table-card { overflow-x: auto; }
        }
    </style>
</head>
<body>

<nav>
    <div class="nav-brand">
        <img
            src="{{ asset('images/otirasor-logo.png') }}?v={{ filemtime(public_path('images/otirasor-logo.png')) }}"
            alt="Otirasor Beach and Resort Logo"
        >
        <div class="nav-title">
            <strong>Otirasor Beach and Resort</strong>
            <span>Administration Portal</span>
        </div>
    </div>

    <div class="nav-links">
        <a href="/admin/dashboard">🏠 Dashboard</a>
        <a href="/admin/bookings">📋 Bookings</a>
        <a href="/admin/notifications">🔔 Notifications</a>
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="logout-btn">🚪 Logout</button>
        </form>
    </div>
</nav>

<div class="container">

    <div class="page-header">
        <div class="page-header-left">
            <h1>🗄️ Database Backups</h1>
            <p>Manage automatic and manual database backups. Restore when needed.</p>
        </div>
        <a href="/admin/management" class="back-btn">← Back to Management</a>
    </div>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    {{-- STATS --}}
    <div class="stats">
        <div class="stat-card">
            <div class="stat-label">Total Backups</div>
            <div class="stat-value">{{ $stats['total'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Successful</div>
            <div class="stat-value green">{{ $stats['success'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Failed</div>
            <div class="stat-value red">{{ $stats['failed'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Last Backup</div>
            <div class="stat-value" style="font-size: 15px;">
                {{ $stats['last']?->created_at?->diffForHumans() ?? 'Never' }}
            </div>
        </div>
    </div>

    {{-- ACTION BAR --}}
    <div class="actions-bar">
        <form method="POST" action="{{ route('admin.backups.create') }}">
            @csrf
            <button type="submit" class="btn-primary">+ Create Manual Backup</button>
        </form>

        <form method="GET" class="search-box">
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Search filename..."
            >
            <button type="submit">Search</button>
        </form>
    </div>

    {{-- TABLE --}}
    <div class="table-card">
        @if($backups->isEmpty())
            <div class="empty-state">
                <strong>No backups yet.</strong>
                <p>Click "+ Create Manual Backup" above to make your first backup.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Filename</th>
                        <th>Type</th>
                        <th>Size</th>
                        <th>Status</th>
                        <th>By</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($backups as $b)
                    <tr>
                        <td>{{ $b->filename }}</td>
                        <td>
                            <span class="badge {{ $b->type === 'automatic' ? 'badge-auto' : 'badge-manual' }}">
                                {{ $b->type }}
                            </span>
                        </td>
                        <td>{{ $b->human_size }}</td>
                        <td>
                            @if($b->status === 'success')
                                <span class="badge badge-success">success</span>
                            @elseif($b->status === 'failed')
                                <span class="badge badge-failed">failed</span>
                            @else
                                <span class="badge badge-progress">in progress</span>
                            @endif
                        </td>
                        <td>{{ $b->creator?->name ?? 'System' }}</td>
                        <td>{{ $b->created_at->format('M d, Y H:i') }}</td>
                        <td>
                            @if($b->status === 'success' && $b->existsOnDisk())
                                <a href="{{ route('admin.backups.download', $b) }}" class="action-link">Download</a>

                                <form method="POST" action="{{ route('admin.backups.restore', $b) }}" style="display:inline;"
                                      onsubmit="return confirm('⚠️ RESTORE will overwrite ALL current data. Continue?');">
                                    @csrf
                                    <input type="hidden" name="confirm" value="RESTORE">
                                    <button type="submit" class="action-link warn">Restore</button>
                                </form>
                            @endif

                            <form method="POST" action="{{ route('admin.backups.destroy', $b) }}" style="display:inline;"
                                  onsubmit="return confirm('Delete this backup?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-link danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="pagination">
        {{ $backups->links() }}
    </div>

</div>

</body>
</html>