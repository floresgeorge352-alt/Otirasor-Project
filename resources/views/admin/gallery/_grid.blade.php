@forelse($galleries as $gallery)
    <div class="gallery-item">

        <img
            src="{{ asset('storage/' . $gallery->image_path) }}"
            alt="{{ $gallery->title ?? 'Resort Gallery Image' }}"
            loading="lazy"
        >

        <div class="gallery-info">
            <h3>{{ $gallery->title ?: 'Untitled Image' }}</h3>

            <span class="category">
                {{ $gallery->category ?: 'Uncategorized' }}
            </span>

            <form
                action="{{ route('admin.gallery.destroy', $gallery->id) }}"
                method="POST"
                onsubmit="return confirm('Are you sure you want to delete this image?');"
            >
                @csrf
                @method('DELETE')

                <button type="submit" class="delete-btn">
                    Delete
                </button>
            </form>
        </div>

    </div>
@empty
    <div class="empty" style="grid-column: 1 / -1; text-align: center; padding: 40px 20px;">
        <h3>No Gallery Images Found</h3>
        <p>Try another search term or category.</p>
    </div>
@endforelse