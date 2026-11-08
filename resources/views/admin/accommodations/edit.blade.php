<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Accommodation - Otirasor Beach</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; color: #333; }
        nav { background: #0077b6; padding: 18px 50px; display: flex; justify-content: space-between; align-items: center; }
        .logo { color: white; font-size: 24px; font-weight: bold; }
        nav a { color: white; text-decoration: none; margin-left: 25px; }
        nav a:hover { text-decoration: underline; }
        .logout-btn { background: none; border: none; color: white; margin-left: 25px; font-size: 16px; cursor: pointer; font-family: Arial, sans-serif; }
        .container { max-width: 700px; margin: 40px auto; padding: 20px; }
        .back-btn { display: inline-block; background: #6c757d; color: white; text-decoration: none; padding: 10px 18px; border-radius: 6px; margin-bottom: 25px; }
        .back-btn:hover { background: #545b62; }
        .form-box { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.08); }
        h1 { color: #023e8a; margin-bottom: 25px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-weight: bold; margin-bottom: 8px; }
        input, select, textarea { width: 100%; padding: 11px; border: 1px solid #ccc; border-radius: 6px; font-size: 15px; font-family: Arial, sans-serif; }
        textarea { min-height: 120px; resize: vertical; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #0077b6; }
        .error { background: #fdecec; border: 1px solid #dc3545; color: #842029; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .error ul { margin-left: 20px; }
        .submit-btn { width: 100%; padding: 13px; background: #0077b6; color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; }
        .submit-btn:hover { background: #005f8f; }
        .cancel-btn { display: block; width: 100%; text-align: center; margin-top: 12px; padding: 11px; background: #6c757d; color: white; text-decoration: none; border-radius: 6px; }
        .cancel-btn:hover { background: #545b62; }
        .image-help { display: block; margin-top: 6px; color: #666; font-size: 13px; }
        .current-image { margin-bottom: 12px; }
        .current-image img { display: block; width: 250px; height: 170px; object-fit: cover; border-radius: 8px; border: 1px solid #ccc; }
        .no-image { color: #777; font-size: 14px; margin-bottom: 10px; }
        .remove-photo { display: flex; align-items: center; gap: 8px; margin-top: 12px; padding: 10px; background: #fff3f3; border: 1px solid #f5c2c7; border-radius: 6px; color: #842029; cursor: pointer; }
        .remove-photo input { width: auto; margin: 0; cursor: pointer; }
        .remove-photo label { margin: 0; font-weight: bold; cursor: pointer; }
        .remove-warning { display: block; margin-top: 6px; color: #842029; font-size: 13px; }
    </style>
</head>
<body>

<nav>
    <div class="logo">Otirasor Beach Admin</div>
    <div>
        <a href="/admin/dashboard">Dashboard</a>
        <a href="/admin/bookings">Bookings</a>
        <a href="/admin/reports">Reports</a>
        <form method="POST" action="/logout" style="display:inline;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</nav>

<div class="container">
    <a href="/admin/accommodations" class="back-btn">← Back to Accommodations</a>

    <div class="form-box">
        <h1>Edit Accommodation</h1>

        @if($errors->any())
            <div class="error">
                <strong>Please fix the following errors:</strong>
                <ul style="margin-top:10px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/admin/accommodations/{{ $accommodation->id }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Accommodation Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $accommodation->name) }}" required>
            </div>

            <div class="form-group">
                <label for="type">Type</label>
                <select id="type" name="type" required>
                    <option value="">Select Type</option>
                    <option value="Room" @selected(old('type', $accommodation->type) === 'Room')>Room</option>
                    <option value="Cottage" @selected(old('type', $accommodation->type) === 'Cottage')>Cottage</option>
                    <option value="Function Hall" @selected(old('type', $accommodation->type) === 'Function Hall')>Function Hall</option>
                </select>
            </div>

            <div class="form-group" id="room_type_group" style="display: none;">
                <label for="room_type">Room Type</label>
                <select id="room_type" name="room_type">
                    <option value="">Select Room Type</option>
                    <option value="day_use" @selected(old('room_type', $accommodation->room_type) === 'day_use')>Day Use</option>
                    <option value="overnight" @selected(old('room_type', $accommodation->room_type) === 'overnight')>Overnight</option>
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Enter accommodation description...">{{ old('description', $accommodation->description) }}</textarea>
            </div>

            {{-- AMENITIES INPUT --}}
            <div class="form-group">
                <label for="amenities">Amenities (comma-separated)</label>
                <input type="text" id="amenities" name="amenities" value="{{ old('amenities', $accommodation->amenities ? implode(', ', $accommodation->amenities) : '') }}" placeholder="Example: Aircon, WiFi, TV, Hot Shower">
                <small class="image-help">Separate each amenity with a comma.</small>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" value="{{ old('price', $accommodation->price) }}" min="0" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="capacity">Capacity</label>
                <input type="number" id="capacity" name="capacity" value="{{ old('capacity', $accommodation->capacity) }}" min="1" required>
            </div>

            <div class="form-group">
                <label>Accommodation Photo</label>
                @if($accommodation->image)
                    <div class="current-image">
                        <img src="{{ asset('storage/' . $accommodation->image) }}" alt="{{ $accommodation->name }}">
                    </div>
                    <div class="remove-photo">
                        <input type="checkbox" id="remove_image" name="remove_image" value="1">
                        <label for="remove_image">Remove Photo</label>
                    </div>
                    <small class="remove-warning">Checking this will permanently remove the current photo.</small>
                @else
                    <div class="no-image">No photo uploaded yet.</div>
                @endif
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp">
                <small class="image-help">Choose a new photo only if you want to replace the current photo. JPG, JPEG, PNG, or WEBP. Maximum 10MB.</small>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="available" @selected(old('status', $accommodation->status) === 'available')>Available</option>
                    <option value="unavailable" @selected(old('status', $accommodation->status) === 'unavailable')>Unavailable</option>
                    <option value="maintenance" @selected(old('status', $accommodation->status) === 'maintenance')>Under Maintenance</option>
                </select>
            </div>

            <button type="submit" class="submit-btn">Update Accommodation</button>
            <a href="/admin/accommodations" class="cancel-btn">Cancel</a>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeField = document.getElementById('type');
        const roomTypeGroup = document.getElementById('room_type_group');
        const roomTypeField = document.getElementById('room_type');

        function toggleRoomType() {
            if (typeField.value === 'Room') {
                roomTypeGroup.style.display = 'block';
            } else {
                roomTypeGroup.style.display = 'none';
                roomTypeField.value = '';
            }
        }

        typeField.addEventListener('change', toggleRoomType);
        toggleRoomType(); // Para lumabas agad kung Room ang existing type
    });
</script>

</body>
</html>