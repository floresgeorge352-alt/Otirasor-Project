<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Records - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: #f4f6f8; color: #1f2937; padding: 30px; }
        .container { max-width: 1200px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .header h1 { color: #023e8a; font-size: 24px; }
        .back-btn { background: #6c757d; color: white; text-decoration: none; padding: 10px 16px; border-radius: 8px; font-weight: 600; font-size: 14px; }
        .back-btn:hover { background: #5a6268; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 25px; }
        .stat-card { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #e5e7eb; }
        .stat-title { font-size: 13px; color: #64748b; font-weight: 600; text-transform: uppercase; margin-bottom: 5px; }
        .stat-value { font-size: 24px; font-weight: 800; color: #1e293b; }
        
        .filter-form { display: flex; gap: 10px; margin-bottom: 20px; align-items: center; flex-wrap: wrap; }
        .filter-form select, .filter-form input[type="text"] { padding: 10px; border-radius: 8px; border: 1px solid #ccc; font-family: 'Poppins', sans-serif; outline: none; }
        .btn-export { background: #10b981; color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; }
        .btn-export:hover { background: #059669; }
        .btn-export-pdf { background: #dc2626; color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; }
        .btn-export-pdf:hover { background: #b91c1c; }

        .table-container { background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #e5e7eb; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th, td { padding: 15px; border-bottom: 1px solid #e5e7eb; font-size: 14px; }
        th { background: #f8fafc; color: #023e8a; font-weight: 700; }
        
        .badge { padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: 700; }
        .badge-refund { background: #f8d7da; color: #721c24; }
        .badge-paid { background: #d4edda; color: #155724; }
        .badge-pending { background: #fff3cd; color: #856404; }

        /* Pagination Styles */
        .pagination-area { margin-top: 20px; display: flex; justify-content: center; gap: 8px; flex-wrap: wrap; }
        .pagination-link { display: inline-flex; align-items: center; justify-content: center; min-width: 40px; height: 40px; padding: 0 15px; border-radius: 8px; background: white; color: #023e8a; text-decoration: none; font-weight: 700; border: 1px solid #dce8ed; transition: 0.2s; font-size: 14px; }
        .pagination-link:hover { background: #eaf8fc; border-color: #0077b6; }
        .pagination-link.active { background: #0077b6; color: white; border-color: #0077b6; }
        .pagination-link.disabled { color: #adb5bd; background: #f8f9fa; cursor: not-allowed; border-color: #e9ecef; }
        
        @media (max-width: 768px) {
            .stats-grid { grid-template-columns: 1fr; }
            .filter-form { flex-direction: column; align-items: stretch; }
            .btn-export, .btn-export-pdf { text-align: center; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💸 Transaction Records 
                @if($date)
                    — {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}
                @else
                    — {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}
                @endif
            </h1>
            <a href="/admin/dashboard" class="back-btn">← Back to Dashboard</a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-title">Total Booked Revenue</div>
                <div class="stat-value" style="color: #3b82f6;">₱{{ number_format($totalRevenue, 2) }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Total Refunded</div>
                <div class="stat-value" style="color: #ef4444;">- ₱{{ number_format($totalRefunds, 2) }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Net Income</div>
                <div class="stat-value" style="color: #10b981;">₱{{ number_format($netIncome, 2) }}</div>
            </div>
        </div>

        <form method="GET" action="/admin/transactions" class="filter-form">
            <!-- MONTH DROPDOWN -->
            <select name="month" onchange="this.form.submit()">
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                @endfor
            </select>

            <!-- DAY DROPDOWN -->
            <select name="day" onchange="this.form.submit()" style="min-width: 80px;">
                <option value="">Day</option>
                @for($d = 1; $d <= 31; $d++)
                    @php
                        $isValidDay = checkdate($month, $d, $year);
                    @endphp
                    @if($isValidDay)
                        <option value="{{ $d }}" {{ request('day') == $d ? 'selected' : '' }}>
                            {{ $d }}
                        </option>
                    @endif
                @endfor
            </select>

            <!-- YEAR DROPDOWN -->
            <select name="year" onchange="this.form.submit()">
                @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>

            <!-- SEARCH BAR WITH INSTANT SEARCH -->
            <div style="position: relative; flex: 1; min-width: 200px; margin-left: 10px;">
                <input type="text" name="search" id="searchInput" value="{{ $search ?? '' }}" placeholder="Search by Guest, Booking ID..." style="width: 100%; padding: 10px 40px 10px 10px; border-radius: 8px; border: 1px solid #ccc; font-family: 'Poppins', sans-serif; outline: none;">
                <button type="button" id="clearSearch" style="display: {{ $search ? 'block' : 'none' }}; position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; font-size: 16px; color: #9ca3af;">✖</button>
            </div>
            
            <a href="{{ route('admin.transactions.export', ['month' => $month, 'year' => $year, 'day' => request('day'), 'search' => $search]) }}" class="btn-export">📥 Export to CSV</a>
            <a href="{{ route('admin.transactions.export-pdf', ['month' => $month, 'year' => $year, 'day' => request('day'), 'search' => $search]) }}" class="btn-export-pdf">📄 Export to PDF</a>
        </form>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Booking ID</th>
                        <th>Guest Name</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Subtotal</th>
                        <th>Discount</th>
                        <th>Total Paid</th>
                        <th>Refund</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $t)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($t->check_in)->format('M d, Y') }}</td>
                            <td><strong>#{{ $t->id }}</strong></td>
                            <td>{{ $t->guest_name }}</td>
                            <td>{{ $t->payment_method }}</td>
                            <td>{{ $t->status }}</td>
                            <td>₱{{ number_format(($t->accommodation_total ?? 0) + ($t->facility_total ?? 0), 2) }}</td>
                            <td style="color: #dc2626;">- ₱{{ number_format($t->discount_amount ?? 0, 2) }}</td>
                            <td><strong>₱{{ number_format(($t->accommodation_total ?? 0) + ($t->facility_total ?? 0) - ($t->discount_amount ?? 0), 2) }}</strong></td>
                            <td>
                                @if($t->refund_status === 'Refunded')
                                    <span class="badge badge-refund">Refunded</span>
                                @elseif($t->refund_status === 'Pending')
                                    <span class="badge badge-pending">Pending</span>
                                @else
                                    <span class="badge badge-paid">No Refund</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 30px;">No transactions found matching your search.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="pagination-area">
            @if ($transactions->onFirstPage())
                <span class="pagination-link disabled">← Previous</span>
            @else
                <a href="{{ $transactions->previousPageUrl() }}" class="pagination-link">← Previous</a>
            @endif

            @foreach ($transactions->getUrlRange(max(1, $transactions->currentPage() - 2), min($transactions->lastPage(), $transactions->currentPage() + 2)) as $page => $url)
                @if ($page == $transactions->currentPage())
                    <span class="pagination-link active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
                @endif
            @endforeach

            @if ($transactions->hasMorePages())
                <a href="{{ $transactions->nextPageUrl() }}" class="pagination-link">Next →</a>
            @else
                <span class="pagination-link disabled">Next →</span>
            @endif
        </div>
        <!-- END PAGINATION -->

    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const clearBtn = document.getElementById('clearSearch');
        let typingTimer;
        const doneTypingInterval = 500;

        searchInput.addEventListener('input', function() {
            clearTimeout(typingTimer);
            clearBtn.style.display = this.value ? 'block' : 'none';
            
            typingTimer = setTimeout(function() {
                searchInput.form.submit();
            }, doneTypingInterval);
        });

        clearBtn.addEventListener('click', function() {
            searchInput.value = '';
            clearBtn.style.display = 'none';
            searchInput.form.submit();
        });
    </script>

</body>
</html>