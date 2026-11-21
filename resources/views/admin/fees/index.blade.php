<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fees - Otirasor Beach</title>

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f5f7fa; color: #1f2937; }

        /* NAVBAR */
        .navbar {
            background: #ffffff; border-bottom: 1px solid #e5e7eb;
            padding: 15px 40px; display: flex; justify-content: space-between;
            align-items: center; gap: 20px;
        }
        .brand { display: flex; align-items: center; gap: 12px; }
        .brand img { width: 48px; height: 48px; object-fit: contain; }
        .brand-text { display: flex; flex-direction: column; gap: 3px; }
        .brand-title { color: #023e8a; font-size: 18px; font-weight: bold; }
        .brand-subtitle { color: #6b7280; font-size: 12px; }
        .navbar-right { display: flex; align-items: center; gap: 8px; }
        .navbar-right a {
            color: #374151; text-decoration: none; padding: 9px 13px;
            border-radius: 8px; font-size: 14px; font-weight: 600; transition: 0.2s ease;
        }
        .navbar-right a:hover { background: #eff6ff; color: #0077b6; }

        /* CONTAINER */
        .container { max-width: 1150px; margin: 35px auto; padding: 0 20px 45px; }

        /* BACK BTN */
        .back-btn {
            display: inline-flex; align-items: center; gap: 7px;
            background: #ffffff; color: #0077b6; border: 1px solid #dbeafe;
            text-decoration: none; padding: 10px 16px; border-radius: 9px;
            font-size: 14px; font-weight: 600; margin-bottom: 22px; transition: 0.2s ease;
        }
        .back-btn:hover { background: #eff6ff; border-color: #bfdbfe; }

        /* HEADER */
        .page-header { margin-bottom: 25px; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 12px; }
        .page-title { color: #023e8a; font-size: 30px; margin-bottom: 7px; }
        .page-description { color: #6b7280; font-size: 14px; line-height: 1.6; }

        .history-link {
            background: #ffffff; color: #0077b6; border: 1px solid #dbeafe;
            text-decoration: none; padding: 10px 16px; border-radius: 9px;
            font-size: 14px; font-weight: 600; transition: 0.2s ease;
        }
        .history-link:hover { background: #eff6ff; }

        /* ALERTS */
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 18px; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        /* FILTER TABS */
        .filter-tabs { display: flex; gap: 8px; margin-bottom: 18px; }
        .filter-tabs a {
            padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600;
            text-decoration: none; transition: 0.2s;
        }
        .filter-tabs a.active { background: #023e8a; color: #ffffff; }
        .filter-tabs a:not(.active) { background: #e5e7eb; color: #374151; }
        .filter-tabs a:not(.active):hover { background: #d1d5db; }

        /* CARD */
        .card {
            background: #ffffff; border: 1px solid #e5e7eb; border-radius: 14px;
            padding: 20px; box-shadow: 0 2px 8px rgba(15, 23, 42, 0.05);
            margin-bottom: 20px; overflow-x: auto;
        }

        /* FORM ADD */
        .add-form { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 10px; }
        .add-form input, .add-form select, .add-form button {
            border: 1px solid #d1d5db; border-radius: 8px; padding: 10px 12px;
            font-size: 14px; background: #ffffff; outline: none;
        }
        .add-form input:focus, .add-form select:focus { border-color: #0077b6; }
        .add-form button {
            background: #023e8a; color: #ffffff; font-weight: bold; cursor: pointer;
            border: none; transition: 0.2s;
        }
        .add-form button:hover { background: #0077b6; }

        /* TABLE */
        table { width: 100%; border-collapse: collapse; min-width: 900px; }
        thead { background: #f3f4f6; }
        th {
            text-align: left; padding: 12px; font-size: 13px; color: #374151;
            text-transform: uppercase; letter-spacing: 0.04em;
        }
        td { padding: 10px 12px; border-top: 1px solid #e5e7eb; vertical-align: middle; }
        tbody tr:hover { background: #f9fafb; }

        td input, td select {
            width: 100%; border: 1px solid #d1d5db; border-radius: 6px;
            padding: 7px 10px; font-size: 13px; background: #ffffff; outline: none;
        }
        td input:focus, td select:focus { border-color: #0077b6; }
        td input.amount { text-align: right; }

        .btn-save {
            background: #0077b6; color: #ffffff; border: none; padding: 8px 14px;
            border-radius: 6px; font-size: 13px; font-weight: bold; cursor: pointer;
            transition: 0.2s; margin-right: 6px;
        }
        .btn-save:hover { background: #023e8a; }

        .btn-delete {
            background: #dc2626; color: #ffffff; border: none; padding: 8px 14px;
            border-radius: 6px; font-size: 13px; font-weight: bold; cursor: pointer;
            transition: 0.2s;
        }
        .btn-delete:hover { background: #b91c1c; }

        .btn-toggle {
            border: none; padding: 6px 14px; border-radius: 999px;
            font-size: 12px; font-weight: bold; cursor: pointer; transition: 0.2s;
            white-space: nowrap;
        }
        .btn-toggle.on { background: #dcfce7; color: #166534; }
        .btn-toggle.on:hover { background: #bbf7d0; }
        .btn-toggle.off { background: #e5e7eb; color: #6b7280; }
        .btn-toggle.off:hover { background: #d1d5db; }

        .empty-state { padding: 30px; text-align: center; color: #6b7280; font-size: 14px; }

        /* RESPONSIVE */
        @media (max-width: 700px) {
            .add-form { grid-template-columns: 1fr; }
            .page-title { font-size: 24px; }
            .navbar { padding: 14px 20px; }
            .navbar-right { display: none; }
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
        <div class="navbar-right">
            <a href="/admin/dashboard">🏠 Dashboard</a>
            <a href="/admin/bookings">📋 Bookings</a>
            <a href="/admin/notifications">🔔 Notifications</a>
        </div>
    </nav>

    <!-- MAIN -->
    <div class="container">

        <a href="/admin/management" class="back-btn">← Back to Management</a>

        <!-- PAGE HEADER -->
        <div class="page-header">
            <div>
                <h1 class="page-title">Entrance & Swimming Fees</h1>
                <p class="page-description">Manage per-head entrance and swimming fees for customers.</p>
            </div>
            <a href="{{ route('admin.fees.history') }}" class="history-link">📜 View History</a>
        </div>

        <!-- ALERTS -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <ul style="list-style: disc; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FILTER TABS -->
        <div class="filter-tabs">
            @foreach(['all' => 'All', 'entrance' => 'Entrance', 'swimming' => 'Swimming'] as $key => $label)
                <a href="{{ route('admin.fees.index', ['type' => $key]) }}"
                   class="{{ $type === $key ? 'active' : '' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <!-- ADD FORM -->
        <div class="card">
            <form method="POST" action="{{ route('admin.fees.store') }}" class="add-form">
                @csrf
                <input name="name" placeholder="Name (e.g. Entrance Fee - Adult)" value="{{ old('name') }}" required>
                <select name="type" required>
                    <option value="entrance" @selected(old('type') === 'entrance')>Entrance</option>
                    <option value="swimming" @selected(old('type') === 'swimming')>Swimming</option>
                </select>
                <select name="applies_to" required>
                    <option value="adult" @selected(old('applies_to') === 'adult')>Adult</option>
                    <option value="child" @selected(old('applies_to') === 'child')>Child</option>
                    <option value="all" @selected(old('applies_to') === 'all')>All</option>
                </select>
                <input name="amount" type="number" step="0.01" min="0" placeholder="Amount (per head)" value="{{ old('amount') }}" required>
                <button type="submit">+ Add Fee</button>
            </form>
        </div>

        <!-- LIST TABLE -->
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th style="width: 30%;">Name</th>
                        <th style="width: 12%;">Type</th>
                        <th style="width: 12%;">Applies To</th>
                        <th style="width: 15%; text-align: right;">Amount</th>
                        <th style="width: 13%; text-align: center;">Status</th>
                        <th style="width: 18%; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($fees as $fee)
                    <tr>
                        <!-- UPDATE FORM (empty, just for linking via `form` attribute) -->
                        <form id="update-form-{{ $fee->id }}" method="POST" action="{{ route('admin.fees.update', $fee) }}" style="display: none;">
                            @csrf
                            @method('PUT')
                        </form>

                        <!-- 1. Name -->
                        <td>
                            <input form="update-form-{{ $fee->id }}" name="name" value="{{ $fee->name }}" required>
                        </td>

                        <!-- 2. Type -->
                        <td>
                            <select form="update-form-{{ $fee->id }}" name="type" required>
                                <option value="entrance" @selected($fee->type === 'entrance')>Entrance</option>
                                <option value="swimming" @selected($fee->type === 'swimming')>Swimming</option>
                            </select>
                        </td>

                        <!-- 3. Applies To -->
                        <td>
                            <select form="update-form-{{ $fee->id }}" name="applies_to" required>
                                @foreach(['adult' => 'Adult', 'child' => 'Child', 'all' => 'All'] as $v => $l)
                                    <option value="{{ $v }}" @selected($fee->applies_to === $v)>{{ $l }}</option>
                                @endforeach
                            </select>
                        </td>

                        <!-- 4. Amount -->
                        <td>
                            <input form="update-form-{{ $fee->id }}" name="amount" type="number" step="0.01" min="0" value="{{ $fee->amount }}" class="amount" required>
                        </td>

                        <!-- 5. Toggle Status -->
                        <td style="text-align: center;">
                            <form method="POST" action="{{ route('admin.fees.toggle', $fee) }}">
                                @csrf
                                <button type="submit" class="btn-toggle {{ $fee->is_active ? 'on' : 'off' }}">
                                    {{ $fee->is_active ? '● Active' : '○ Inactive' }}
                                </button>
                            </form>
                        </td>

                        <!-- 6. Actions -->
                        <td style="text-align: right; white-space: nowrap;">
                            <button type="submit" form="update-form-{{ $fee->id }}" class="btn-save">Save</button>
                            <form method="POST" action="{{ route('admin.fees.destroy', $fee) }}" style="display: inline;" onsubmit="return confirm('Delete this fee?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="empty-state">No fees yet. Add one above.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>