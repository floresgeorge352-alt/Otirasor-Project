<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gallery - Otirasor Beach</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #f5f8fc; color: #243b4a; min-height: 100vh; }
        h1, h2, h3 { font-family: 'Montserrat', sans-serif; font-weight: 800; }

        nav { background: #023e8a; padding: 15px 6%; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 15px rgba(0,0,0,0.15); }
        .brand { display: flex; align-items: center; gap: 12px; color: white; font-size: 18px; font-weight: bold; }
        .brand img { width: 40px; height: 40px; object-fit: contain; background: white; border-radius: 50%; padding: 2px; }
        .nav-links { display: flex; gap: 20px; }
        nav a { color: white; text-decoration: none; font-size: 14px; font-weight: 500; }
        nav a:hover { text-decoration: underline; }

        .container { width: 1000px; max-width: 92%; margin: 40px auto 60px; }
        h1 { color: #023e8a; text-align: center; margin-bottom: 30px; font-size: 32px; }

        .message { padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; font-weight: 600; font-size: 14px; }
        .success { background: #ecfdf3; color: #166534; border: 1px solid #bbf7d0; }
        .error { background: #fff1f2; color: #991b1b; border: 1px solid #fecaca; }

        .upload-card { background: white; border-radius: 16px; padding: 30px; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.04); margin-bottom: 30px; }
        .upload-card h2 { color: #023e8a; margin-bottom: 20px; font-size: 20px; }
        
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 8px; color: #374151; font-size: 14px; }
        .form-group input[type="text"], 
        .form-group input[type="file"],
        .form-group select {
            width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; font-family: 'Poppins', sans-serif;
            background-color: white;
        }
        
        .btn-upload {
            background: #0077b6; color: white; padding: 12px 24px; border: none; border-radius: 8px;
            font-weight: 700; cursor: pointer; font-family: 'Montserrat', sans-serif; transition: 0.3s;
        }
        .btn-upload:hover { background: #005f8f; }

        .gallery-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .gallery-item {
            background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.04);
            position: relative; height: 250px;
        }
        .gallery-item img { width: 100%; height: 100%; object-fit: cover; }
        
        .gallery-info {
            position: absolute; bottom: 0; left: 0; right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.85));
            padding: 20px; color: white;
            display: flex; justify-content: space-between; align-items: flex-end;
        }
        .gallery-text { display: flex; flex-direction: column; gap: 4px; }
        .gallery-title { font-size: 14px; font-weight: 600; margin: 0; }
        .gallery-category { font-size: 11px; color: #cbd5e1; text-transform: uppercase; letter-spacing: 0.5px; }
        
        .btn-delete {
            background: #ef4444; color: white; padding: 6px 12px; border: none; border-radius: 6px;
            font-size: 12px; font-weight: 700; cursor: pointer; transition: 0.2s;
        }
        .btn-delete:hover { background: #dc2626; }

        @media (max-width: 768px) {
            nav { flex-direction: column; gap: 10px; }
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
        Otirasor Beach Admin
    </div>
    <div class="nav-links">
        <a href="/admin/dashboard">Dashboard</a>
        <a href="/admin/bookings">Bookings</a>
        <a href="/admin/reports">Reports</a>
        <a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        <form id="logout-form" action="/logout" method="POST" style="display: none;">@csrf</form>
    </div>
</nav>

<div class="container">
    <h1>Manage Gallery</h1>

    @if(session('success'))
        <div class="message success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="message error">{{ session('error') }}</div>
    @endif

    <!-- UPLOAD FORM -->
    <div class="upload-card">
        <h2>Upload New Image</h2>
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Image Title (Optional)</label>
                <input type="text" name="title" placeholder="e.g., Beach Front, Pool View, etc.">
            </div>

            <div class="form-group">
                <label>Category</label>
                <select name="category" required>
                    <option value="" disabled selected>Select a category...</option>
                    <option value="Beach">Beach</option>
                    <option value="Pools">Pools</option>
                    <option value="Rooms">Rooms</option>
                    <option value="Function Halls">Function Halls</option>
                    <option value="Billiard Halls">Billiard Halls</option>
                    <option value="Resort Views">Resort Views</option>
                </select>
            </div>

            <div class="form-group">
                <label>Select Image</label>
                <input type="file" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn-upload">Upload Image</button>
        </form>
    </div>

    <!-- GALLERY GRID -->
    <div class="gallery-grid">
        @forelse($galleries as $gallery)
            <div class="gallery-item">
                <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}">
                <div class="gallery-info">
                    <div class="gallery-text">
                        <p class="gallery-title">{{ $gallery->title ?? 'Untitled' }}</p>
                        <!-- Ipinapakita ang category sa ilalim ng title -->
                        <p class="gallery-category">{{ $gallery->category ?? 'Uncategorized' }}</p>
                    </div>
                    
                    <form action="{{ route('admin.gallery.destroy', $gallery) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this image?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty" style="grid-column: 1 / -1; text-align: center; padding: 50px; color: #6b7280;">
                No images uploaded yet.
            </div>
        @endforelse
    </div>
</div>

</body>
</html>