@extends('admin.layout')
@section('title', 'Gallery')
@section('subtitle', 'Photos shown on the website gallery page')
@section('breadcrumb', 'Gallery')
@section('actions')
    <a href="{{ route('gallery') }}" target="_blank" class="btn btn-light btn-sm"><i class="fa-solid fa-eye me-1"></i> View page</a>
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header"><h5 class="mb-0 fw-semibold"><i class="fa-solid fa-cloud-arrow-up me-1 text-primary"></i> Upload photos</h5></div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data" id="uploadForm">
            @csrf
            <div class="row g-3 align-items-end">
                <div class="col-lg-6">
                    <label class="vv-dropzone d-block w-100 mb-0" id="dropzone">
                        <i class="fa-solid fa-images fa-2x text-primary mb-2"></i>
                        <div class="fw-semibold">Click or drop photos here</div>
                        <small class="text-muted" id="dzInfo">You can select many photos at once (JPG, PNG, WEBP · max 5 MB each)</small>
                        <input type="file" name="images[]" id="images" accept="image/*" multiple hidden required>
                    </label>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold">Category *</label>
                    <input type="text" name="category" class="form-control" list="catList" value="Facilities" required>
                    <datalist id="catList">@foreach($categories->merge(['Facilities','Campus','Therapy','Events','Yoga'])->unique() as $c)<option value="{{ $c }}">@endforeach</datalist>
                    <label class="form-label fw-semibold mt-2">Title <span class="text-muted fw-normal">(optional)</span></label>
                    <input type="text" name="title" class="form-control" placeholder="Taken from file name">
                </div>
                <div class="col-lg-3 col-md-6">
                    <button class="btn btn-primary w-100 py-2"><i class="fa-solid fa-upload me-1"></i> Upload</button>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-2 mt-3" id="previewWrap"></div>
        </form>
    </div>
</div>

<div class="d-flex flex-wrap gap-2 mb-3">
    <a href="{{ route('admin.gallery.index') }}" class="btn btn-sm {{ request('category') ? 'btn-light' : 'btn-primary' }}">All ({{ \App\Models\GalleryItem::count() }})</a>
    @foreach($categories as $c)
        <a href="{{ route('admin.gallery.index', ['category' => $c]) }}" class="btn btn-sm {{ request('category') === $c ? 'btn-primary' : 'btn-light' }}">{{ $c }}</a>
    @endforeach
</div>

<div class="row g-3">
    @forelse($items as $item)
        <div class="col-xxl-2 col-xl-3 col-md-4 col-6">
            <div class="vv-g-card {{ $item->is_active ? '' : 'is-hidden' }}">
                <span class="badge bg-dark bg-opacity-75 vv-g-tag">{{ $item->category }}</span>
                <a href="{{ $item->imageUrl() }}" target="_blank"><img src="{{ $item->imageUrl() }}" alt="{{ $item->alt_text }}" loading="lazy"></a>
                <div class="p-2">
                    <div class="small fw-semibold text-truncate" title="{{ $item->title }}">{{ $item->title ?: 'Untitled' }}</div>
                    <div class="d-flex justify-content-between align-items-center mt-1">
                        <div class="form-check form-switch m-0" title="Show on website">
                            <input class="form-check-input js-toggle" type="checkbox" data-url="{{ route('admin.gallery.toggle', $item) }}" @checked($item->is_active)>
                        </div>
                        <div class="text-nowrap">
                            <button class="btn btn-sm btn-light js-edit" data-bs-toggle="modal" data-bs-target="#editModal"
                                data-url="{{ route('admin.gallery.update', $item) }}" data-title="{{ $item->title }}" data-category="{{ $item->category }}"
                                data-alt="{{ $item->alt_text }}" data-order="{{ $item->sort_order }}" data-active="{{ $item->is_active ? 1 : 0 }}" data-img="{{ $item->imageUrl() }}"><i class="fa-solid fa-pen"></i></button>
                            <form action="{{ route('admin.gallery.destroy', $item) }}" method="POST" class="d-inline js-confirm-delete" data-title="Delete this photo?">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-light text-danger"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12"><div class="card"><div class="card-body text-center text-muted py-5">No photos yet. Upload some above.</div></div></div>
    @endforelse
</div>

<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content border-0 rounded-4" method="POST" enctype="multipart/form-data" id="editForm">
            @csrf @method('PUT')
            <div class="modal-header"><h5 class="fw-bold mb-0">Edit photo</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <img id="eImg" class="img-fluid rounded-3 mb-3 w-100" style="max-height:220px;object-fit:cover" alt="">
                <div class="mb-2"><label class="form-label fw-semibold">Title</label><input type="text" name="title" id="eTitle" class="form-control"></div>
                <div class="row g-2 mb-2">
                    <div class="col-8"><label class="form-label fw-semibold">Category</label><input type="text" name="category" id="eCat" class="form-control" list="catList" required></div>
                    <div class="col-4"><label class="form-label fw-semibold">Order</label><input type="number" name="sort_order" id="eOrder" min="0" class="form-control"></div>
                </div>
                <div class="mb-2"><label class="form-label fw-semibold">Alt text <span class="text-muted fw-normal">(SEO)</span></label><input type="text" name="alt_text" id="eAlt" class="form-control"></div>
                <div class="mb-2"><label class="form-label fw-semibold">Replace image</label><input type="file" name="image_file" accept="image/*" class="form-control"></div>
                <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="eActive"><label class="form-check-label" for="eActive">Show on website</label></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button class="btn btn-primary">Save</button></div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
const dz = document.getElementById('dropzone'), input = document.getElementById('images');
function showFiles(files) {
    const wrap = $('#previewWrap').empty();
    [...files].forEach(f => wrap.append($('<img class="vv-thumb">').attr('src', URL.createObjectURL(f))));
    $('#dzInfo').text(files.length + ' photo(s) selected');
}
input.addEventListener('change', () => showFiles(input.files));
['dragenter', 'dragover'].forEach(ev => dz.addEventListener(ev, e => { e.preventDefault(); dz.classList.add('drag'); }));
['dragleave', 'drop'].forEach(ev => dz.addEventListener(ev, e => { e.preventDefault(); dz.classList.remove('drag'); }));
dz.addEventListener('drop', e => { input.files = e.dataTransfer.files; showFiles(input.files); });

$(document).on('click', '.js-edit', function () {
    const d = $(this).data();
    $('#editForm').attr('action', d.url);
    $('#eImg').attr('src', d.img); $('#eTitle').val(d.title); $('#eCat').val(d.category);
    $('#eAlt').val(d.alt); $('#eOrder').val(d.order); $('#eActive').prop('checked', d.active == 1);
});
$(document).on('change', '.js-toggle', function () {
    const card = $(this).closest('.vv-g-card');
    $.post($(this).data('url')).done(r => { card.toggleClass('is-hidden', !r.active); vvToast.fire({ icon: 'success', title: r.active ? 'Shown on website' : 'Hidden from website' }); });
});
</script>
@endpush
