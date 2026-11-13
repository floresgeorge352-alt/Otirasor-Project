<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund History - Otirasor Beach</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/js/app.js'])
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', Arial, sans-serif; background: #f4f6f8; color: #1f2937; }
        
        /* Navbar */
        nav { background: #ffffff; border-bottom: 1px solid #e5e7eb; padding: 15px 40px; display: flex; justify-content: space-between; align-items: center; gap: 20px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03); position: sticky; top: 0; z-index: 100; }
        .nav-brand { display: flex; align-items: center; gap: 12px; }
        .nav-brand img { width: 48px; height: 48px; object-fit: contain; }
        .nav-title { display: flex; flex-direction: column; gap: 3px; }
        .nav-title strong { color: #023e8a; font-size: 18px; font-family: 'Montserrat', sans-serif; }
        .nav-title span { color: #6b7280; font-size: 12px; }
        .nav-links { display: flex; align-items: center; gap: 8px; }
        nav a { color: #374151; text-decoration: none; padding: 9px 13px; border-radius: 8px; font-size: 14px; font-weight: 600; transition: 0.2s; }
        nav a:hover { background: #eff6ff; color: #0077b6; }
        .logout-btn { background: none; border: none; color: #374151; padding: 9px 13px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; font-family: 'Poppins', sans-serif; transition: 0.2s; }
        .logout-btn:hover { background: #fff1f2; color: #c62828; }

        /* Container */
        .container { max-width: 1200px; margin: 35px auto; padding: 0 20px 40px; }
        
        /* Header */
        .page-header { display: flex; justify-content: space-between; align-items: flex-end; gap: 20px; margin-bottom: 25px; flex-wrap: wrap; }
        .page-header-left h1 { color: #023e8a; font-size: 30px; margin-bottom: 7px; font-family: 'Montserrat', sans-serif; }
        .page-header-left p { color: #6b7280; font-size: 14px; }
        
        /* Buttons */
        .btn-group { display: flex; gap: 10px; flex-wrap: wrap; }
        .back-btn { display: inline-flex; align-items: center; gap: 7px; background: #ffffff; color: #0077b6; border: 1px solid #dbeafe; text-decoration: none; padding: 10px 16px; border-radius: 9px; font-weight: 600; font-size: 14px; transition: 0.2s; box-shadow: 0 2px 5px rgba(0,0,0,0.02); }
        .back-btn:hover { background: #eff6ff; }
        .print-btn { display: inline-flex; align-items: center; gap: 7px; background: #10b981; color: white; border: none; text-decoration: none; padding: 10px 16px; border-radius: 9px; font-weight: 600; font-size: 14px; transition: 0.2s; cursor: pointer; box-shadow: 0 2px 5px rgba(16, 185, 129, 0.2); }
        .print-btn:hover { background: #059669; }

        /* Tabs */
        .tabs-container { display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px; }
        .tab-btn { padding: 10px 20px; background: transparent; border: none; font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 600; color: #6b7280; cursor: pointer; border-radius: 8px 8px 0 0; transition: 0.2s; position: relative; top: 2px; }
        .tab-btn:hover { color: #023e8a; background: #f1f5f9; }
        .tab-btn.active { color: #023e8a; border-bottom: 3px solid #023e8a; background: transparent; font-weight: 700; }
        
        .tab-btn.rejected-tab.active { color: #dc2626; border-bottom-color: #dc2626; }

        /* Search Bar */
        .search-form { display: flex; gap: 10px; margin-bottom: 20px; position: relative; }
        .search-input { flex: 1; padding: 12px 16px 12px 40px; border: 1px solid #cbd5e1; border-radius: 10px; font-family: 'Poppins', sans-serif; font-size: 14px; outline: none; transition: 0.2s; }
        .search-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
        .search-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 18px; }
        .search-btn { padding: 12px 20px; background: #3b82f6; color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; font-family: 'Poppins', sans-serif; transition: 0.2s; }
        .search-btn:hover { background: #2563eb; }
        .clear-btn { padding: 12px 20px; background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; border-radius: 10px; font-weight: 600; cursor: pointer; font-family: 'Poppins', sans-serif; text-decoration: none; display: inline-flex; align-items: center; transition: 0.2s; }
        .clear-btn:hover { background: #e2e8f0; }

        /* Table */
        .table-container { background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); border: 1px solid #e5e7eb; overflow-x: auto; transition: opacity 0.2s; }
        .table-container.loading { opacity: 0.5; pointer-events: none; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { background: #f8fafc; color: #023e8a; font-weight: 700; padding: 15px; font-size: 13px; text-transform: uppercase; border-bottom: 2px solid #e5e7eb; white-space: nowrap; }
        td { padding: 15px; border-bottom: 1px solid #f1f5f9; font-size: 14px; vertical-align: middle; }
        tr:hover { background: #f8fbff; }

        /* Proof Button */
        .proof-btn { display: inline-block; padding: 6px 12px; background: #3b82f6; color: white; text-decoration: none; border-radius: 6px; font-size: 12px; font-weight: 600; transition: 0.2s; }
        .proof-btn:hover { background: #2563eb; transform: translateY(-1px); }
        .no-proof { color: #9ca3af; font-style: italic; font-size: 13px; }

        /* Pagination */
        .pagination-wrapper { margin-top: 20px; display: flex; justify-content: center; }
        .pagination-wrapper svg { width: 20px; height: 20px; }

        /* PRINT MODE */
        @media print {
            nav, .page-header .btn-group, .search-form, .pagination-wrapper, .tabs-container { display: none !important; }
            body { background: white; padding: 0; }
            .container { margin: 0; padding: 0; max-width: 100%; }
            .page-header { margin-bottom: 10px; }
            .table-container { box-shadow: none; border: 1px solid #ccc; opacity: 1 !important; }
            th { background: #eee !important; color: black !important; }
            td { color: black !important; border-bottom: 1px solid #ccc; }
            a { text-decoration: none; color: black; }
            .proof-btn { display: none !important; }
        }
    </style>
</head>
<body>

<nav>
    <div class="nav-brand">
        <img src="{{ asset('images/otirasor-logo.png') }}" alt="Logo">
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
            <h1>💸 Refund History</h1>
            <p>List of all processed refunds (Audit Trail).</p>
        </div>
        <div class="btn-group">
            <button onclick="window.print()" class="print-btn">🖨️ Print Record</button>
            <a href="/admin/dashboard" class="back-btn">← Back to Dashboard</a>
        </div>
    </div>

    <!-- Tabs -->
    <div class="tabs-container">
        <button class="tab-btn {{ $filter === 'successful' ? 'active' : '' }}" onclick="switchTab('successful')">
            ✅ Successful Refunds
        </button>
        <button class="tab-btn rejected-tab {{ $filter === 'rejected' ? 'active' : '' }}" onclick="switchTab('rejected')">
            ❌ Rejected Refunds
        </button>
    </div>

    <!-- Search Bar -->
    <div class="search-form">
        <span class="search-icon">🔎</span>
        <input type="text" id="searchInput" value="{{ $search }}" placeholder="Search by Guest Name, Booking ID, or GCash Ref..." class="search-input" autocomplete="off">
        <button type="button" class="search-btn" onclick="performSearch()">Search</button>
        <button type="button" class="clear-btn" id="clearBtn" style="{{ $search ? '' : 'display: none;' }}" onclick="clearSearch()">Clear</button>
    </div>

    <!-- Results Container -->
    <div id="resultsContainer">
        @include('admin.refunds._table', ['refunds' => $refunds, 'filter' => $filter])
    </div>
</div>

<script>
    const searchInput = document.getElementById('searchInput');
    const resultsContainer = document.getElementById('resultsContainer');
    const clearBtn = document.getElementById('clearBtn');
    let typingTimer;
    const doneTypingInterval = 400; 
    let currentFilter = "{{ $filter }}";

    // Function para mag-load ng data (AJAX)
    function fetchResults(query, filter) {
        resultsContainer.style.opacity = '0.5';
        resultsContainer.style.pointerEvents = 'none';

        fetch(`{{ route('admin.refunds.history') }}?search=${encodeURIComponent(query)}&filter=${filter}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            resultsContainer.innerHTML = data.html;
            resultsContainer.style.opacity = '1';
            resultsContainer.style.pointerEvents = 'auto';
            
            // I-update ang URL
            const newUrl = new URL(window.location);
            if (query) newUrl.searchParams.set('search', query); else newUrl.searchParams.delete('search');
            newUrl.searchParams.set('filter', filter);
            window.history.pushState({}, '', newUrl);

            // I-update ang Tabs UI
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            if (filter === 'rejected') {
                document.querySelector('.rejected-tab').classList.add('active');
            } else {
                document.querySelector('.tab-btn:not(.rejected-tab)').classList.add('active');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            resultsContainer.style.opacity = '1';
            resultsContainer.style.pointerEvents = 'auto';
        });
    }

    function switchTab(filter) {
        currentFilter = filter;
        fetchResults(searchInput.value.trim(), filter);
    }

    searchInput.addEventListener('input', function() {
        clearTimeout(typingTimer);
        const query = this.value.trim();
        clearBtn.style.display = query ? 'block' : 'none';

        typingTimer = setTimeout(function() {
            fetchResults(query, currentFilter);
        }, doneTypingInterval);
    });

    function performSearch() {
        fetchResults(searchInput.value.trim(), currentFilter);
    }

    function clearSearch() {
        searchInput.value = '';
        clearBtn.style.display = 'none';
        fetchResults('', currentFilter);
    }

    searchInput.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            performSearch();
        }
    });
</script>

</body>
</html>