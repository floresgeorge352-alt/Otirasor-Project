<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Gallery - Otirasor Beach</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Poppins',sans-serif;background:#f3f7fc;color:#243b4a;min-height:100vh}
h1,h2,h3{font-family:'Montserrat',sans-serif;font-weight:800}

/* NAVIGATION */
nav{background:#023e8a;padding:15px 6%;display:flex;justify-content:space-between;align-items:center;box-shadow:0 4px 15px rgba(0,0,0,.12)}
.brand{display:flex;align-items:center;gap:12px;color:white;font-size:18px;font-weight:bold}
.brand img{width:40px;height:40px;object-fit:contain;background:white;border-radius:50%;padding:2px}
.nav-links{display:flex;align-items:center;gap:22px}
nav a{color:white;text-decoration:none;font-size:14px;font-weight:500}
nav a:hover{color:#caf0f8}

/* MAIN CONTAINER */
.container{width:1100px;max-width:92%;margin:40px auto 60px}
.page-header{margin-bottom:28px}
h1{color:#023e8a;font-size:30px;margin-bottom:7px}
.page-description{color:#64748b;font-size:14px}

/* MESSAGES */
.message{padding:14px 18px;border-radius:10px;margin-bottom:18px;font-size:13px;font-weight:600}
.success{background:#ecfdf5;color:#166534;border:1px solid #bbf7d0}
.error,.validation-errors{background:#fff1f2;color:#991b1b;border:1px solid #fecaca}
.validation-errors{padding:14px 20px;border-radius:10px;margin-bottom:20px;font-size:13px}
.validation-errors ul{padding-left:20px;margin-top:5px}

/* UPLOAD CARD */
.upload-card{background:white;border-radius:16px;padding:28px;box-shadow:0 5px 20px rgba(15,50,90,.05);border:1px solid #e5edf7;margin-bottom:35px}
.upload-card h2{color:#023e8a;font-size:20px;margin-bottom:7px}
.upload-description{color:#64748b;font-size:13px;margin-bottom:24px}
.form-group{margin-bottom:19px}
.form-group>label{display:block;font-weight:600;margin-bottom:8px;color:#334155;font-size:13px}
.form-group input[type="text"],.form-group select{width:100%;padding:12px 14px;border:1px solid #dbe3ed;border-radius:9px;font-family:'Poppins',sans-serif;background:white;font-size:13px;outline:none;transition:.2s}
.form-group input[type="text"]:focus,.form-group select:focus{border-color:#0077b6;box-shadow:0 0 0 3px rgba(0,119,182,.1)}

/* IMAGE UPLOAD AREA */
.upload-area{border:2px dashed #9bbbdc;background:#f5faff;border-radius:12px;padding:25px;text-align:center;transition:.2s}
.upload-area:hover{border-color:#0077b6;background:#eff8ff}
.upload-icon{font-size:35px;margin-bottom:8px}
.upload-area p{font-size:13px;color:#475569;margin-bottom:5px}
.upload-area small{color:#94a3b8;font-size:11px}
.file-input{display:none}
.btn-choose{display:inline-block;background:#0077b6;color:white!important;padding:10px 20px;border-radius:8px;font-size:12px!important;font-weight:700!important;cursor:pointer;margin-top:12px;transition:.2s}
.btn-choose:hover{background:#005f8f}

/* IMAGE PREVIEW */
.preview-container{display:none;margin-top:20px;padding:15px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px}
.preview-container.show{display:block}
.preview-label{font-size:12px;color:#334155;font-weight:700;margin-bottom:10px}
.preview-image{width:100%;max-width:300px;height:190px;object-fit:cover;border-radius:9px;display:block;margin-bottom:10px;border:1px solid #dbe3ed}
.file-details{font-size:11px;color:#64748b;margin-bottom:12px;overflow-wrap:anywhere}
.preview-actions{display:flex;gap:10px;flex-wrap:wrap}
.btn-change,.btn-remove{padding:9px 15px;border-radius:7px;font-size:11px;font-weight:700;cursor:pointer;transition:.2s;font-family:'Poppins',sans-serif}
.btn-change{background:#e0f2fe;color:#0369a1;border:none}
.btn-change:hover{background:#bae6fd}
.btn-remove{background:#fee2e2;color:#b91c1c;border:1px solid #fecaca}
.btn-remove:hover{background:#fecaca}

/* UPLOAD BUTTON */
.btn-upload{background:#0077b6;color:white;padding:12px 25px;border:none;border-radius:8px;font-weight:700;cursor:pointer;font-family:'Montserrat',sans-serif;font-size:13px;transition:.2s}
.btn-upload:hover{background:#005f8f;transform:translateY(-1px)}

/* GALLERY HEADER */
.gallery-heading{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px}
.gallery-heading h2{color:#023e8a;font-size:21px}
.gallery-count{background:#e0f2fe;color:#0369a1;padding:6px 12px;border-radius:20px;font-size:11px;font-weight:700}

/* SEARCH AND FILTER */
.gallery-tools{display:flex;gap:12px;margin-bottom:20px;flex-wrap:wrap}
.gallery-search,.gallery-filter{padding:12px 14px;border:1px solid #dbe3ed;border-radius:9px;background:white;font-family:'Poppins',sans-serif;font-size:13px;outline:none}
.gallery-search{flex:1;min-width:220px}
.gallery-filter{min-width:200px;cursor:pointer}
.gallery-search:focus,.gallery-filter:focus{border-color:#0077b6;box-shadow:0 0 0 3px rgba(0,119,182,.1)}

/* GALLERY GRID */
.gallery-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;transition:opacity .2s}
.gallery-item{background:white;border-radius:14px;overflow:hidden;box-shadow:0 5px 18px rgba(15,50,90,.06);border:1px solid #e5edf7;position:relative;height:250px;transition:.25s}
.gallery-item:hover{transform:translateY(-4px);box-shadow:0 10px 25px rgba(15,50,90,.12)}
.gallery-item img{width:100%;height:100%;object-fit:cover;display:block}
.gallery-info{position:absolute;bottom:0;left:0;right:0;background:linear-gradient(transparent,rgba(2,32,70,.92));padding:22px 16px 15px;color:white;display:flex;justify-content:space-between;align-items:flex-end;gap:10px}
.gallery-text{display:flex;flex-direction:column;gap:5px;min-width:0}
.gallery-title{font-size:13px;font-weight:600;overflow-wrap:anywhere}
.gallery-category{font-size:10px;color:#bfdbfe;text-transform:uppercase;letter-spacing:.5px}
.btn-delete{background:#ef4444;color:white;padding:7px 12px;border:none;border-radius:6px;font-size:11px;font-weight:700;cursor:pointer;transition:.2s;flex-shrink:0}
.btn-delete:hover{background:#dc2626}

/* EMPTY STATES */
.empty{grid-column:1/-1;text-align:center;padding:55px 20px;background:white;border:1px dashed #cbd5e1;border-radius:14px;color:#64748b}
.empty-icon{font-size:38px;margin-bottom:10px}
.empty p{font-size:14px;font-weight:600;color:#334155;margin-bottom:5px}
.empty small{font-size:12px}

/* GALLERY PAGINATION */
.pagination-wrapper{display:flex;justify-content:center;margin-top:28px}
.pagination-wrapper nav{background:transparent;padding:0;box-shadow:none}
.pagination-wrapper nav a,.pagination-wrapper nav span{font-size:13px}

/* RESPONSIVE */
@media(max-width:768px){
nav{flex-direction:column;gap:12px}
.nav-links{flex-wrap:wrap;justify-content:center;gap:14px}
.gallery-grid{grid-template-columns:repeat(2,1fr)}
.upload-card{padding:22px}
}
@media(max-width:500px){
.gallery-grid{grid-template-columns:1fr}
.gallery-item{height:260px}
h1{font-size:25px}
.gallery-heading{align-items:flex-start;gap:10px;flex-direction:column}
.gallery-search,.gallery-filter{width:100%}
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
<a href="/logout" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
<form id="logout-form" action="/logout" method="POST" style="display:none;">@csrf</form>
</div>
</nav>

<div class="container">

<div class="page-header">
<h1>Manage Gallery</h1>
<p class="page-description">Upload, organize, and manage your resort photos.</p>
</div>

@if(session('success'))
<div class="message success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="message error">{{ session('error') }}</div>
@endif

@if($errors->any())
<div class="validation-errors">
<strong>Please check the following:</strong>
<ul>
@foreach($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<!-- UPLOAD FORM -->
<div class="upload-card">
<h2>Upload New Image</h2>
<p class="upload-description">Add photos to showcase the beauty and facilities of Otirasor Beach and Resort.</p>

<form id="galleryUploadForm" action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="form-group">
<label for="title">Image Title (Optional)</label>
<input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="e.g., Beach Front, Pool View, etc.">
</div>

<div class="form-group">
<label for="category">Category</label>
<select name="category" id="category" required>
<option value="" disabled {{ old('category') ? '' : 'selected' }}>Select a category...</option>
<option value="Beach" {{ old('category') == 'Beach' ? 'selected' : '' }}>Beach</option>
<option value="Pools" {{ old('category') == 'Pools' ? 'selected' : '' }}>Pools</option>
<option value="Rooms" {{ old('category') == 'Rooms' ? 'selected' : '' }}>Rooms</option>
<option value="Function Halls" {{ old('category') == 'Function Halls' ? 'selected' : '' }}>Function Halls</option>
<option value="Billiard Halls" {{ old('category') == 'Billiard Halls' ? 'selected' : '' }}>Billiard Halls</option>
<option value="Resort Views" {{ old('category') == 'Resort Views' ? 'selected' : '' }}>Resort Views</option>
</select>
</div>

<div class="form-group">
<label>Select Image</label>
<div class="upload-area">
<div class="upload-icon">📷</div>
<p><strong>Choose an image to upload</strong></p>
<small>Supported formats: JPG, JPEG, PNG, WEBP</small><br>
<small>Maximum file size: 5 MB</small><br>
<label for="imageInput" class="btn-choose">Choose Image</label>
<input type="file" id="imageInput" name="image" class="file-input" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" required>
</div>

<div class="preview-container" id="previewContainer">
<p class="preview-label">Image Preview</p>
<img src="" alt="Selected image preview" id="imagePreview" class="preview-image">
<p class="file-details" id="fileDetails"></p>
<div class="preview-actions">
<label for="imageInput" class="btn-change">Change Image</label>
<button type="button" class="btn-remove" id="removeImageButton">✕ Remove Image</button>
</div>
</div>
</div>

<button type="submit" class="btn-upload">Upload Image</button>
</form>
</div>

<!-- GALLERY HEADER -->
<div class="gallery-heading">
<h2>Uploaded Images</h2>
<span class="gallery-count" id="galleryCount">
{{ $galleries->total() }} Images
</span>
</div>

<!-- SEARCH AND CATEGORY FILTER -->
<div class="gallery-tools">
<input type="search" id="gallerySearch" class="gallery-search" placeholder="Search images by title or category..." autocomplete="off">

<select id="galleryFilter" class="gallery-filter">
<option value="all">All Categories</option>
<option value="beach">Beach</option>
<option value="pools">Pools</option>
<option value="rooms">Rooms</option>
<option value="function halls">Function Halls</option>
<option value="billiard halls">Billiard Halls</option>
<option value="resort views">Resort Views</option>
<option value="uncategorized">Uncategorized</option>
</select>
</div>

<!-- GALLERY RESULTS -->
<div id="galleryResults">

    <div class="gallery-grid" id="galleryGrid">
        @include('admin.gallery._grid', ['galleries' => $galleries])
    </div>

    <div class="pagination-wrapper" id="galleryPagination">
        @if($galleries->hasPages())
            {{ $galleries->links() }}
        @endif
    </div>

</div>

</div>

<!-- IMAGE PREVIEW AND VALIDATION -->
<script>
const imageInput=document.getElementById('imageInput');
const imagePreview=document.getElementById('imagePreview');
const previewContainer=document.getElementById('previewContainer');
const fileDetails=document.getElementById('fileDetails');
const removeImageButton=document.getElementById('removeImageButton');
const uploadForm=document.getElementById('galleryUploadForm');
const maxFileSize=5*1024*1024;
const allowedTypes=['image/jpeg','image/png','image/webp'];
let previewUrl=null;

function clearImagePreview(){
    imageInput.value='';
    if(previewUrl){
        URL.revokeObjectURL(previewUrl);
        previewUrl=null;
    }
    imagePreview.removeAttribute('src');
    fileDetails.textContent='';
    previewContainer.classList.remove('show');
}

imageInput.addEventListener('change',function(){
    const file=this.files[0];
    if(!file)return;

    if(!allowedTypes.includes(file.type)){
        alert('Invalid image format. Please select JPG, JPEG, PNG, or WEBP.');
        clearImagePreview();
        return;
    }

    if(file.size>maxFileSize){
        alert('Image is too large. Maximum allowed size is 5 MB.');
        clearImagePreview();
        return;
    }

    if(previewUrl)URL.revokeObjectURL(previewUrl);

    previewUrl=URL.createObjectURL(file);
    imagePreview.src=previewUrl;
    fileDetails.textContent=file.name+' • '+(file.size/(1024*1024)).toFixed(2)+' MB';
    previewContainer.classList.add('show');
});

removeImageButton.addEventListener('click',function(){
    clearImagePreview();
});

uploadForm.addEventListener('submit',function(event){
    const file=imageInput.files[0];

    if(!file){
        event.preventDefault();
        alert('Please select an image before uploading.');
        return;
    }

    if(!allowedTypes.includes(file.type)||file.size>maxFileSize){
        event.preventDefault();
        alert('Please select a valid image with a maximum size of 5 MB.');
    }
});

window.addEventListener('beforeunload',function(){
    if(previewUrl)URL.revokeObjectURL(previewUrl);
});
</script>

<!-- AJAX LIVE SEARCH, CATEGORY FILTER AND PAGINATION -->
<script>
const gallerySearch=document.getElementById('gallerySearch');
const galleryFilter=document.getElementById('galleryFilter');
const galleryGrid=document.getElementById('galleryGrid');
const galleryPagination=document.getElementById('galleryPagination');
const galleryCount=document.getElementById('galleryCount');

let searchTimer=null;
let currentRequest=null;

function loadGallery(pageUrl=null){

    const params=new URLSearchParams();

    params.set('search',gallerySearch.value.trim());
    params.set('category',galleryFilter.value);

    const url=pageUrl ||
        `{{ route('admin.gallery.index') }}?${params.toString()}`;

    if(currentRequest){
        currentRequest.abort();
    }

    currentRequest=new AbortController();

    galleryGrid.style.opacity='0.5';

    fetch(url,{
        method:'GET',
        headers:{
            'X-Requested-With':'XMLHttpRequest',
            'Accept':'application/json'
        },
        signal:currentRequest.signal
    })
    .then(response=>{
        if(!response.ok){
            throw new Error('Unable to load gallery images.');
        }

        return response.json();
    })
    .then(data=>{

        galleryGrid.innerHTML=data.html;
        galleryPagination.innerHTML=data.pagination;
        galleryCount.textContent=data.count+' Images';

        galleryGrid.style.opacity='1';

        window.history.replaceState({},'',url);
    })
    .catch(error=>{

        if(error.name==='AbortError'){
            return;
        }

        console.error('Gallery Error:',error);

        galleryGrid.style.opacity='1';

        alert('Unable to load gallery images. Please refresh the page.');
    });
}

// LIVE SEARCH
gallerySearch.addEventListener('input',function(){

    clearTimeout(searchTimer);

    searchTimer=setTimeout(function(){
        loadGallery();
    },350);

});

// CATEGORY FILTER
galleryFilter.addEventListener('change',function(){
    loadGallery();
});

// AJAX PAGINATION
galleryPagination.addEventListener('click',function(event){

    const link=event.target.closest('a');

    if(!link)return;

    event.preventDefault();

    loadGallery(link.href);

});
</script>

</body>
</html>