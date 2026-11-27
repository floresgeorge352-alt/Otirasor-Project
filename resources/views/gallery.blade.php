<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - Otirasor Beach Resort</title>
    
    {{-- Load Vite and Echo for Real-Time --}}
    @vite(['resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #f5f8fc; color: #243b4a; min-height: 100vh; }
        h1 { font-family: 'Montserrat', sans-serif; color: #023e8a; text-align: center; margin: 40px 0 15px; font-size: 36px; font-weight: 800; }

        /* NAVIGATION (Updated) */
        nav { 
            background: #023e8a; 
            padding: 15px 6%; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.15); 
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .brand { display: flex; align-items: center; gap: 12px; color: white; font-size: 18px; font-weight: bold; font-family: 'Montserrat', sans-serif; }
        .brand img { width: 45px; height: 45px; object-fit: contain; background: white; border-radius: 50%; padding: 2px; }
        
        .nav-links { display: flex; gap: 20px; align-items: center; }
        nav a { color: rgba(255,255,255,0.8); text-decoration: none; font-size: 14px; font-weight: 500; transition: 0.3s; }
        nav a:hover, nav a.active { color: #fbbf24; }

        /* AUTH BUTTONS */
        .btn-nav {
            background: #fbbf24;
            color: #111827;
            padding: 10px 24px;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.3s;
            font-family: 'Montserrat', sans-serif;
            font-size: 14px;
            border: none;
            cursor: pointer;
        }
        .btn-nav:hover { background: #f59e0b; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(251, 191, 36, 0.4); }
        
        .btn-logout {
            background: transparent;
            color: white;
            padding: 10px 24px;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.3s;
            font-family: 'Montserrat', sans-serif;
            font-size: 14px;
            border: 1px solid rgba(255,255,255,0.3);
            cursor: pointer;
        }
        .btn-logout:hover { background: rgba(255,255,255,0.1); }

        .container { width: 1100px; max-width: 92%; margin: 0 auto 60px; }

        /* CATEGORY FILTER BUTTONS */
        .filter-buttons { display: flex; justify-content: center; flex-wrap: wrap; gap: 10px; margin-bottom: 40px; }
        .filter-buttons a {
            background: white; color: #023e8a; padding: 10px 20px; border-radius: 30px; text-decoration: none;
            font-weight: 600; font-size: 14px; border: 1px solid #cbd5e1; transition: 0.3s;
        }
        .filter-buttons a:hover, .filter-buttons a.active {
            background: #0077b6; color: white; border-color: #0077b6;
        }

        /* GALLERY GRID */
        .gallery-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        
        .gallery-item {
            background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            position: relative; height: 280px; transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }
        .gallery-item:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(0,0,0,0.15); }
        .gallery-item img { width: 100%; height: 100%; object-fit: cover; object-position: top; transition: transform 0.5s ease; }
        .gallery-item:hover img { transform: scale(1.08); }
        
        .gallery-info {
            position: absolute; bottom: 0; left: 0; right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.4) 50%, transparent 100%);
            padding: 30px 20px 20px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }
        
        .gallery-title { font-size: 18px; font-weight: 700; margin: 0; font-family: 'Montserrat', sans-serif; text-shadow: 0 2px 5px rgba(0,0,0,0.5); line-height: 1.2; }
        .gallery-category-badge { 
            display: inline-block; background: #0077b6; color: white; font-size: 10px; 
            padding: 4px 10px; border-radius: 20px; margin-bottom: 8px; 
            text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700;
            align-self: flex-start;
            box-shadow: 0 3px 10px rgba(0, 119, 182, 0.4);
        }

        @media (max-width: 768px) {
            nav { flex-direction: column; gap: 10px; padding: 15px 20px; }
            .nav-links { flex-wrap: wrap; justify-content: center; }
            .gallery-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 500px) {
            .gallery-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<nav>
    <div class="brand">
        <img src="{{ asset('images/otirasor-logo.png') }}" alt="Logo">
        Otirasor Beach Resort
    </div>
    <div class="nav-links">
        <a href="/">Home</a>
        <a href="/about">About</a>
        <a href="/gallery" class="active">Gallery</a>
        <a href="/reviews">Reviews</a>
        <a href="/contact">Contact</a>

        {{-- AUTH LOGIC --}}
        @auth
            <a href="/dashboard">Dashboard</a>
            <form method="POST" action="/logout" style="display:inline; margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        @else
            <a href="/login">Login</a>
            <a href="/register" class="btn-nav">Book Now</a>
        @endauth
    </div>
</nav>

<div class="container">
    <h1>Resort Gallery</h1>

    <!-- CATEGORY FILTER -->
    <div class="filter-buttons">
        <a href="/gallery" class="{{ !request('category') ? 'active' : '' }}">All Photos</a>
        @foreach($categories as $category)
            <a href="/gallery?category={{ $category }}" class="{{ request('category') == $category ? 'active' : '' }}">
                {{ $category }}
            </a>
        @endforeach
    </div>

    <!-- GALLERY GRID -->
    <div class="gallery-grid">
        @forelse($galleries as $gallery)
            <div class="gallery-item">
                <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}">
                <div class="gallery-info">
                    <span class="gallery-category-badge">{{ $gallery->category ?? 'Resort' }}</span>
                    <p class="gallery-title">{{ $gallery->title ?? 'Otirasor Beach' }}</p>
                </div>
            </div>
        @empty
            <div class="empty" style="grid-column: 1 / -1; text-align: center; padding: 50px; color: #6b7280;">
                No photos available at the moment.
            </div>
        @endforelse
    </div>
</div>

{{-- REAL-TIME GALLERY LISTENER --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (!window.Echo) return;

        window.Echo.channel('public.gallery')
            .listen('GalleryImageAdded', (e) => {
                console.log('New Image Added:', e);
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            });
    });
</script>

</body>
</html>