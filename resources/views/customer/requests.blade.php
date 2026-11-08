<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Requests - Otirasor Beach</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #f5f8fc; color: #243b4a; }
        h1, h2, h3 { font-family: 'Montserrat', sans-serif; }
        
        nav { background: rgba(0, 119, 182, 0.95); backdrop-filter: blur(10px); padding: 15px 50px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); position: sticky; top: 0; z-index: 100; border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        .nav-brand { display: flex; align-items: center; gap: 12px; color: white; font-size: 18px; font-weight: 800; font-family: 'Montserrat', sans-serif; }
        .nav-brand img { width: 45px; height: 45px; object-fit: contain; border-radius: 50%; background: white; padding: 2px; }
        nav .nav-links { display: flex; align-items: center; gap: 20px; }
        nav a { color: white; text-decoration: none; font-size: 14px; font-weight: 500; transition: 0.3s; }
        nav a:hover { color: #dff8ff; transform: translateY(-2px); }
        .logout-btn { background: none; border: none; color: white; font-size: 14px; font-weight: 500; cursor: pointer; font-family: 'Poppins', sans-serif; transition: 0.3s; }
        .logout-btn:hover { color: #dff8ff; }

        .container { width: 1000px; max-width: 92%; margin: 40px auto 60px; }
        h1 { color: #023e8a; text-align: center; margin-bottom: 35px; font-size: 32px; font-weight: 800; }

        .request-card { background: white; padding: 25px; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 20px; border-left: 6px solid #ccc; }
        
        .request-card.refund { border-left-color: #ef4444; }
        .request-card.cancellation { border-left-color: #f59e0b; }

        .request-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; }
        .request-header h3 { color: #023e8a; font-size: 20px; }
        .request-date { font-size: 12px; color: #6b7280; margin-top: 5px; }
        
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: uppercase; }
        .badge-pending { background: #fff3cd; color: #856404; }
        .badge-approved { background: #d4edda; color: #155724; }
        .badge-rejected { background: #f8d7da; color: #721c24; }
        .badge-refunded { background: #d1e7dd; color: #0f5132; }

        .request-body { background: #f8fafc; padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0; }
        .request-body p { margin: 5px 0; font-size: 14px; color: #4b5563; }
        .request-body strong { color: #1e293b; }

        .admin-message { margin-top: 15px; padding: 15px; background: #ecfdf3; border: 1px solid #bbf7d0; border-radius: 10px; color: #166534; font-size: 14px; }
        
        .empty { text-align: center; padding: 50px; background: white; border-radius: 16px; color: #6b7280; }
        .back-btn { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #0077b6; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; }

        /* Pagination Styles */
        .pagination-area { margin-top: 30px; display: flex; justify-content: center; gap: 8px; flex-wrap: wrap; }
        .pagination-link { display: inline-flex; align-items: center; justify-content: center; min-width: 40px; height: 40px; padding: 0 15px; border-radius: 8px; background: white; color: #023e8a; text-decoration: none; font-weight: 700; border: 1px solid #dce8ed; transition: 0.2s; font-size: 14px; }
        .pagination-link:hover { background: #eaf8fc; border-color: #0077b6; }
        .pagination-link.active { background: #0077b6; color: white; border-color: #0077b6; }
        .pagination-link.disabled { color: #adb5bd; background: #f8f9fa; cursor: not-allowed; border-color: #e9ecef; }
    </style>
</head>
<body>

<nav>
    <div class="nav-brand">
        <img src="{{ asset('images/otirasor-logo.png') }}" alt="Logo">
        Otirasor Beach and Resort
    </div>
    <div class="nav-links">
        <a href="/dashboard">Dashboard</a>
        <a href="/accommodations">Book Now</a>
        <a href="/my-bookings">My Bookings</a>
        <a href="/my-requests" style="font-weight: 700; border-bottom: 2px solid white;">My Requests</a>
        
        <a href="{{ route('customer.notifications') }}" style="position: relative; display: inline-flex; align-items: center;">
            🔔 Notifications
            @if(auth()->user()->unreadNotifications->count() > 0)
                <span style="position: absolute; top: -8px; right: -10px; background: #e63946; color: white; border-radius: 50%; padding: 2px 6px; font-size: 10px; font-weight: bold;">
                    {{ auth()->user()->unreadNotifications->count() }}
                </span>
            @endif
        </a>

        <form method="POST" action="/logout" style="display:inline;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</nav>

<div class="container">
    <h1>My Refunds & Cancellation Requests</h1>

    <!-- SEARCH BAR WITH INSTANT SEARCH & CLEAR -->
    <form method="GET" action="/my-requests" style="margin-bottom: 25px; display: flex; gap: 10px; position: relative;">
        <input type="text" name="search" id="searchInput" value="{{ $search ?? '' }}" placeholder="Search by Booking ID or Reason..." style="flex: 1; padding: 12px 20px; border: 1px solid #dce8ed; border-radius: 30px; outline: none; font-family: 'Poppins', sans-serif; font-size: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
        
        <!-- Clear Button (X) -->
        <button type="button" id="clearSearch" style="display: {{ $search ? 'block' : 'none' }}; position: absolute; right: 120px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; font-size: 16px; color: #9ca3af;">✖</button>

        <button type="submit" style="padding: 12px 25px; background: #0077b6; color: white; border: none; border-radius: 30px; font-weight: 700; cursor: pointer; font-family: 'Poppins', sans-serif; box-shadow: 0 4px 10px rgba(0,119,182,0.2);">Search</button>
    </form>
    <!-- END SEARCH BAR -->

    @if($requests->count() > 0)
        @foreach($requests as $req)
            
            <!-- REFUND CARD -->
            @if($req->refund_status)
                <div class="request-card refund">
                    <div class="request-header">
                        <div>
                            <h3>💸 Refund Request: Booking #{{ $req->id }}</h3>
                            <div class="request-date">Requested on {{ $req->updated_at->format('M d, Y h:i A') }}</div>
                        </div>
                        @if($req->refund_status === 'Pending')
                            <span class="badge badge-pending">Pending</span>
                        @elseif($req->refund_status === 'Approved')
                            <span class="badge badge-approved">Approved</span>
                        @elseif($req->refund_status === 'Refunded')
                            <span class="badge badge-refunded">Refunded</span>
                        @elseif($req->refund_status === 'Rejected')
                            <span class="badge badge-rejected">Rejected</span>
                        @endif
                    </div>
                    <div class="request-body">
                        <p><strong>Your Reason:</strong> {{ $req->refund_request_reason }}</p>
                        
                        @if($req->refund_status === 'Refunded')
                            <div class="admin-message">
                                <strong>✅ Refund Processed</strong><br>
                                <strong>GCash Ref No:</strong> {{ $req->refund_reference }}<br>
                                @if($req->refund_message)
                                    <strong>Message from Admin:</strong> "{{ $req->refund_message }}"
                                @endif
                            </div>
                        @elseif($req->refund_status === 'Rejected')
                            <div class="admin-message" style="background: #fef2f2; border-color: #fecaca; color: #991b1b;">
                                <strong>❌ Refund Rejected</strong><br>
                                <strong>Reason:</strong> {{ $req->refund_notes }}
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- CANCELLATION CARD -->
            @if($req->cancellation_status)
                <div class="request-card cancellation">
                    <div class="request-header">
                        <div>
                            <h3>🚫 Cancellation Request: Booking #{{ $req->id }}</h3>
                            <div class="request-date">Requested on {{ $req->updated_at->format('M d, Y h:i A') }}</div>
                        </div>
                        @if($req->cancellation_status === 'Pending')
                            <span class="badge badge-pending">Pending</span>
                        @elseif($req->cancellation_status === 'Approved')
                            <span class="badge badge-approved">Approved</span>
                        @elseif($req->cancellation_status === 'Rejected')
                            <span class="badge badge-rejected">Rejected</span>
                        @endif
                    </div>
                    <div class="request-body">
                        <p><strong>Your Reason:</strong> {{ $req->cancellation_reason }}</p>
                    </div>
                </div>
            @endif

        @endforeach

        <!-- PAGINATION -->
        <div class="pagination-area">
            @if ($requests->onFirstPage())
                <span class="pagination-link disabled">← Previous</span>
            @else
                <a href="{{ $requests->previousPageUrl() }}" class="pagination-link">← Previous</a>
            @endif

            @foreach ($requests->getUrlRange(max(1, $requests->currentPage() - 2), min($requests->lastPage(), $requests->currentPage() + 2)) as $page => $url)
                @if ($page == $requests->currentPage())
                    <span class="pagination-link active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
                @endif
            @endforeach

            @if ($requests->hasMorePages())
                <a href="{{ $requests->nextPageUrl() }}" class="pagination-link">Next →</a>
            @else
                <span class="pagination-link disabled">Next →</span>
            @endif
        </div>
        <!-- END PAGINATION -->

    @else
        <div class="empty">
            <h3>No requests found.</h3>
            <p>You haven't made any refund or cancellation requests yet.</p>
            <a href="/my-bookings" class="back-btn">← Back to My Bookings</a>
        </div>
    @endif
</div>

<script>
    const searchInput = document.getElementById('searchInput');
    const clearBtn = document.getElementById('clearSearch');
    let typingTimer;
    const doneTypingInterval = 500; // 0.5 seconds delay bago mag-search

    // Kapag nagta-type, mag-search pagkatapos ng 0.5s
    searchInput.addEventListener('input', function() {
        clearTimeout(typingTimer);
        clearBtn.style.display = this.value ? 'block' : 'none';
        
        typingTimer = setTimeout(function() {
            searchInput.form.submit();
        }, doneTypingInterval);
    });

    // Kapag pinindot ang X, i-clear at i-submit
    clearBtn.addEventListener('click', function() {
        searchInput.value = '';
        clearBtn.style.display = 'none';
        searchInput.form.submit();
    });
</script>

</body>
</html>