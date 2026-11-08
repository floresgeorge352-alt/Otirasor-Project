<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics - Otirasor Beach and Resort</title>

    @vite(['resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f8fc; color: #263746; min-height: 100vh; }
        a { text-decoration: none; }

        nav { background: #023e8a; min-height: 76px; padding: 0 5%; display: flex; justify-content: space-between; align-items: center; color: white; box-shadow: 0 3px 12px rgba(0, 0, 0, 0.12); position: sticky; top: 0; z-index: 100; }
        .brand { display: flex; align-items: center; gap: 12px; }
        .brand-logo { width: 58px; height: 58px; display: flex; align-items: center; justify-content: center; }
        .brand-logo img { width: 100%; height: 100%; object-fit: contain; }
        .brand-title { font-size: 18px; font-weight: 700; }
        .brand-subtitle { font-size: 11px; opacity: 0.8; margin-top: 4px; }
        .nav-links { display: flex; align-items: center; gap: 15px; }
        .nav-links a { color: white; padding: 10px 12px; border-radius: 8px; font-size: 14px; font-weight: 600; transition: 0.2s; }
        .nav-links a:hover { background: rgba(255, 255, 255, 0.13); }

        .container { max-width: 1180px; margin: 34px auto; padding: 0 22px 45px; }

        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px; }
        
        .btn-back { background: white; color: #023e8a; padding: 10px 18px; border-radius: 8px; font-weight: bold; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #dce8ed; }
        .btn-back:hover { background: #e3eaf1; }

        .year-form select { padding: 9px 15px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: Arial; font-size: 14px; font-weight: bold; color: #023e8a; background: white; cursor: pointer; outline: none; }

        .section-title { color: #023e8a; font-size: 24px; font-weight: 700; margin-bottom: 5px; }
        .section-description { color: #7a8793; font-size: 14px; margin-bottom: 25px; }

        .chart-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; }
        .chart-grid.full { grid-template-columns: 1fr; }
        .recent-card { background: white; border: 1px solid #e1e9f0; border-radius: 14px; padding: 22px; box-shadow: 0 3px 12px rgba(0, 0, 0, 0.045); }
        .chart-title { color: #023e8a; margin-bottom: 15px; font-size: 18px; font-weight: bold; }

        @media (max-width: 850px) {
            .chart-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>

<nav>
    <div class="brand">
        <div class="brand-logo">
            <img src="{{ asset('images/otirasor-logo.png') }}" alt="Logo">
        </div>
        <div class="brand-text">
            <div class="brand-title">Otirasor Beach and Resort</div>
            <div class="brand-subtitle">Administration Portal</div>
        </div>
    </div>

    <div class="nav-links">
        <a href="/admin/notifications" style="position: relative;">
            🔔 Notifications
            @if (($unreadNotificationsCount ?? 0) > 0)
                <span style="position: absolute; top: 0; right: 0; background: #e63946; color: white; border-radius: 50%; padding: 2px 6px; font-size: 10px;">
                    {{ $unreadNotificationsCount }}
                </span>
            @endif
        </a>
        <form method="POST" action="/logout" style="display:inline;">
            @csrf
            <button type="submit" style="background: none; border: none; color: white; font-weight: bold; cursor: pointer; font-size: 14px; font-family: Arial;">🚪 Logout</button>
        </form>
    </div>
</nav>

<div class="container">

    <div class="header-flex">
        <a href="{{ route('admin.dashboard') }}" class="btn-back">
            ← Back to Dashboard
        </a>

        <form method="GET" action="{{ route('admin.analytics') }}" class="year-form">
            <select name="year" onchange="this.form.submit()">
                {{-- Pinalitan ang loop para mag-umpisa sa 2026 --}}
                @for ($y = date('Y') + 1; $y >= 2026; $y--)
                    <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>
                        Year {{ $y }}
                    </option>
                @endfor
            </select>
        </form>
    </div>

    <h1 class="section-title">Resort Analytics — {{ $selectedYear }}</h1>
    <p class="section-description">Visual summary of bookings, revenue, occupancy, and payments for the selected year.</p>

    <div class="chart-grid">
        <div class="recent-card">
            <h3 class="chart-title">Monthly Bookings ({{ $selectedYear }})</h3>
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

        <div class="recent-card">
            <h3 class="chart-title">Booking Status</h3>
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <div class="chart-grid">
        <div class="recent-card">
            <h3 class="chart-title">Payment Method (Cash vs GCash)</h3>
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="paymentChart"></canvas>
            </div>
        </div>

        <div class="recent-card">
            <h3 class="chart-title">Monthly Occupancy % ({{ $selectedYear }})</h3>
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="occupancyChart"></canvas>
            </div>
        </div>
    </div>

    <div class="chart-grid full">
        <div class="recent-card">
            <h3 class="chart-title">Monthly Revenue — Booked vs Realized ({{ $selectedYear }})</h3>
            <div style="position: relative; height: 350px; width: 100%;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        // --- Monthly Bookings ---
        const ctxMonthly = document.getElementById('monthlyChart').getContext('2d');
        new Chart(ctxMonthly, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartMonths) !!},
                datasets: [{
                    label: 'Total Bookings',
                    data: {!! json_encode($chartCounts) !!},
                    backgroundColor: 'rgba(0, 119, 182, 0.7)',
                    borderColor: 'rgba(0, 119, 182, 1)',
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });

        // --- Status Distribution ---
        const ctxStatus = document.getElementById('statusChart').getContext('2d');
        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_keys($statusData)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($statusData)) !!},
                    backgroundColor: ['#fbbf24', '#10b981', '#ef4444', '#6b7280'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });

        // --- Payment Method ---
        const ctxPayment = document.getElementById('paymentChart').getContext('2d');
        new Chart(ctxPayment, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_keys($paymentMethodData)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($paymentMethodData)) !!},
                    backgroundColor: ['#10b981', '#0077b6'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });

        // --- Occupancy % ---
        const ctxOccupancy = document.getElementById('occupancyChart').getContext('2d');
        new Chart(ctxOccupancy, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartMonths) !!},
                datasets: [{
                    label: 'Occupancy %',
                    data: {!! json_encode($chartOccupancy) !!},
                    backgroundColor: 'rgba(139, 92, 246, 0.2)',
                    borderColor: 'rgba(139, 92, 246, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true, max: 100, ticks: { callback: v => v + '%' } } }
            }
        });

        // --- Revenue ---
        const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctxRevenue, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartMonths) !!},
                datasets: [
                    {
                        label: 'Booked Revenue (₱)',
                        data: {!! json_encode($chartBookedRevenue) !!},
                        backgroundColor: 'rgba(59, 130, 246, 0.7)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1,
                        borderRadius: 5
                    },
                    {
                        label: 'Realized Revenue (₱)',
                        data: {!! json_encode($chartRealizedRevenue) !!},
                        backgroundColor: 'rgba(16, 185, 129, 0.7)',
                        borderColor: 'rgba(16, 185, 129, 1)',
                        borderWidth: 1,
                        borderRadius: 5
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { callback: v => '₱' + Number(v).toLocaleString() }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: ctx => ctx.dataset.label + ': ₱' + Number(ctx.parsed.y).toLocaleString(undefined, { minimumFractionDigits: 2 })
                        }
                    }
                }
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (!window.Echo) return;

        window.Echo.private('admin.dashboard')
            .listen('DashboardStatsUpdated', (e) => {
                console.log('Analytics Data Updated:', e);
                setTimeout(() => window.location.reload(), 1000);
            });
    });
</script>

</body>
</html>