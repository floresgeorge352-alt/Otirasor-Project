<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Corrections - Otirasor</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f7fb; padding: 20px; margin: 0; }
        nav { background: #023e8a; color: white; padding: 18px 30px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        nav .logo { font-size: 21px; font-weight: bold; }
        nav a { color: white; text-decoration: none; margin-left: 20px; }
        nav a:hover { text-decoration: underline; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        h1 { color: #023e8a; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; }
        th { background: #f8fcfd; color: #023e8a; }
        .btn { padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; color: white; font-weight: bold; text-decoration: none; display: inline-block; margin-right: 5px; font-family: Arial; font-size: 13px; }
        .btn-approve { background: #10b981; }
        .btn-reject { background: #ef4444; }
        .status-pending { color: #856404; font-weight: bold; }
        .status-approved { color: #198754; font-weight: bold; }
        .status-rejected { color: #dc3545; font-weight: bold; }
    </style>
</head>
<body>

<nav>
    <div class="logo">Otirasor Beach and Resort</div>
    <div>
        <a href="/admin/attendance">Attendance</a>
        <a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        <form id="logout-form" action="/logout" method="POST" style="display: none;">@csrf</form>
    </div>
</nav>

<div class="container">
    <a href="/admin/attendance" style="color: #023e8a; text-decoration: none; font-weight: bold; margin-bottom: 20px; display: inline-block;">← Back to Attendance</a>
    
    <h1>Attendance Corrections</h1>

    @if(session('success'))
        <div style="background: #d1e7dd; color: #0f5132; padding: 12px; border-radius: 6px; margin-bottom: 15px; font-weight: bold;">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Employee</th>
                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $req)
                <tr>
                    <td><strong>{{ $req->user->name ?? 'Unknown' }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($req->date)->format('M d, Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($req->time_in)->format('h:i A') }}</td>
                    <td>{{ \Carbon\Carbon::parse($req->time_out)->format('h:i A') }}</td>
                    <td>{{ $req->reason }}</td>
                    <td>
                        @if($req->status === 'Pending') <span class="status-pending">Pending</span>
                        @elseif($req->status === 'Approved') <span class="status-approved">Approved</span>
                        @else <span class="status-rejected">Rejected</span>
                        @endif
                    </td>
                    <td>
                        @if($req->status === 'Pending')
                            <form method="POST" action="{{ route('admin.attendance.corrections.approve', $req->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-approve" onclick="return confirm('Approve this correction?')">Approve</button>
                            </form>
                            <form method="POST" action="{{ route('admin.attendance.corrections.reject', $req->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-reject" onclick="return confirm('Reject this correction?')">Reject</button>
                            </form>
                        @else
                            —
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center;">No correction requests found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>