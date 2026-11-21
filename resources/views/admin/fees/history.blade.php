<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee History - Otirasor Beach</title>

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f5f7fa; color: #1f2937; }

        .navbar {
            background: #ffffff; border-bottom: 1px solid #e5e7eb;
            padding: 15px 40px; display: flex; justify-content: space-between;
            align-items: center; gap: 20px;
        }
        .brand { display: flex; align-items: center; gap: 12px; }
        .brand img { width: 48px; height: 48px; object-fit: contain; }
        .brand-title { color: #023e8a; font-size: 18px; font-weight: bold; }
        .brand-subtitle { color: #6b7280; font-size: 12px; }

        .container { max-width: 1150px; margin: 35px auto; padding: 0 20px 45px; }

        .back-btn {
            display: inline-flex; align-items: center; gap: 7px;
            background: #ffffff; color: #0077b6; border: 1px solid #dbeafe;
            text-decoration: none; padding: 10px 16px; border-radius: 9px;
            font-size: 14px; font-weight: 600; margin-bottom: 22px;
        }
        .back-btn:hover { background: #eff6ff; }

        .page-title { color: #023e8a; font-size: 30px; margin-bottom: 7px; }
        .page-description { color: #6b7280; font-size: 14px; }

        /* SEARCH */
        .search-bar { display: flex; gap: 8px; margin: 18px 0; }
        .search-bar input {
            flex: 1; max-width: 300px; padding: 10px 14px; border: 1px solid #d1d5db;
            border-radius: 8px; font-size: 14px; outline: none;
        }
        .search-bar input:focus { border-color: #0077b6; }
        .search-bar button, .search-bar .clear {
            padding: 10px 18px; border-radius: 8px; font-size: 14px;
            font-weight: bold; cursor: pointer; text-decoration: none; border: none;
            display: inline-flex; align-items: center;
        }
        .search-bar button { background: #023e8a; color: #ffffff; }
        .search-bar button:hover { background: #0077b6; }
        .search-bar .clear { background: #e5e7eb; color: #374151; }
        .search-bar .clear:hover { background: #d1d5db; }

        /* CARD */
        .card {
            background: #ffffff; border: 1px solid #e5e7eb; border-radius: 14px;
            padding: 0; box-shadow: 0 2px 8px rgba(15, 23, 42, 0.05);
            overflow-x: auto; margin-bottom: 20px;
        }

        /* TABLE */
        table { width: 100%; border-collapse: collapse; min-width: 900px; }
        thead { background: #f3f4f6; }
        th {
            text-align: left; padding: 12px; font-size: 13px; color: #374151;
            text-transform: uppercase; letter-spacing: 0.04em;
        }
        td { padding: 12px; border-top: 1px solid #e5e7eb; font-size: 14px; }
        tbody tr:hover { background: #f9fafb; }

        .badge {
            display: inline-block; padding: 4px 10px; border-radius: 999px;
            font-size: 12px; font-weight: bold; text-transform: capitalize;
        }
        .badge-created { background: #dcfce7; color: #166534; }
        .badge-updated { background: #dbeafe; color: #1e40af; }
        .badge-toggled { background: #fef3c7; color: #92400e; }
        .badge-deleted { background: #fee2e2; color: #991b1b; }

        .empty-state { padding: 30px; text-align: center; color: #6b7280; font-size: 14px; }

        /* PAGINATION */
        .pagination-wrap { margin-top: 18px; }
        .pagination-wrap nav { display: flex; justify-content: center; }

        @media (max-width: 700px) {
            .navbar { padding: 14px 20px; }
            .page-title { font-size: 24px; }
            .container { padding: 0 15px 30px; }
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="brand">
            <img src="{{ asset('images/otirasor-logo.png') }}?v={{ filemtime(public_path('images/otirasor-logo.png')) }}" alt="Logo">
            <div class="brand-text">
                <div class="brand-title">Otirasor Beach and Resort</div>
                <div class="brand-subtitle">Administration Portal</div>
            </div>
        </div>
    </nav>

    <div class="container">

        <a href="{{ route('admin.fees.index') }}" class="back-btn">← Back to Fees</a>

        <h1 class="page-title">Fee Change History</h1>
        <p class="page-description">Audit trail of all entrance and swimming fee changes.</p>

        <!-- SEARCH -->
        <form method="GET" class="search-bar">
            <input name="search" value="{{ $search }}" placeholder="Search fee name...">
            <button type="submit">Search</button>
            @if($search !== '')
                <a href="{{ route('admin.fees.history') }}" class="clear">Clear</a>
            @endif
        </form>

        <!-- TABLE -->
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Fee</th>
                        <th>Action</th>
                        <th style="text-align: right;">Old Amount</th>
                        <th style="text-align: right;">New Amount</th>
                        <th>By</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($histories as $h)
                    <tr>
                        <td style="white-space: nowrap;">{{ $h->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $h->fee?->name ?? '(deleted)' }}</td>
                        <td>
                            <span class="badge badge-{{ $h->action }}">{{ $h->action }}</span>
                        </td>
                        <td style="text-align: right;">
                            {{ $h->old_amount !== null ? number_format($h->old_amount, 2) : '—' }}
                        </td>
                        <td style="text-align: right; font-weight: bold;">
                            {{ $h->new_amount !== null ? number_format($h->new_amount, 2) : '—' }}
                        </td>
                        <td>{{ $h->user?->name ?? 'system' }}</td>
                        <td style="font-size: 12px; color: #6b7280;">{{ $h->ip_address }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="empty-state">No history yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="pagination-wrap">
            {{ $histories->links() }}
        </div>

    </div>

</body>
</html>