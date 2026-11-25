@extends('admin.layout')
@section('title', $service->exists ? 'Edit Service' : 'Add Service')
@section('breadcrumb', 'Services')
@section('actions')
    <a href="{{ route('admin.services.index') }}" class="btn btn-light btn-sm"><i class="fa-solid fa-arrow-left me-1"></i> Back</a>
@endsection

@section('content')
<form method="POST" enctype="multipart/form-data" action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}">
    @csrf
    @if($service->exists) @method('PUT') @endif
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0 fw-semibold">Service details</h5></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Title *</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $service->title) }}" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">URL slug</label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug', $service->slug) }}" class="form-control" placeholder="auto">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Short description <span class="text-muted fw-normal">(card text, max 300)</span></label>
                            <textarea name="short_description" rows="3" maxlength="300" class="form-control">{{ old('short_description', $service->short_description) }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Full content <span class="text-muted fw-normal">(for the service's own page; basic HTML allowed)</span></label>
                            <textarea name="content" rows="10" class="form-control" placeholder="<p>Describe the programme...</p>">{{ old('content', $service->content) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Link to an existing page <span class="text-muted fw-normal">(optional)</span></label>
                            <input type="text" name="link_url" value="{{ old('link_url', $service->link_url) }}" class="form-control" placeholder="/de-addiction">
                            <small class="text-muted">Leave empty to use the auto page <code>/services/{slug}</code>.</small>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Icon</label>
                            <div class="input-group">
                                <span class="input-group-text"><i id="iconPreview" class="fa-solid {{ old('icon', $service->icon) }}"></i></span>
                                <input type="text" name="icon" id="icon" value="{{ old('icon', $service->icon) }}" class="form-control" placeholder="fa-heart" list="iconList">
                            </div>
                            <datalist id="iconList">
                                @foreach(['fa-hand-holding-heart','fa-seedling','fa-comments','fa-brain','fa-people-roof','fa-user-doctor','fa-spa','fa-house-medical','fa-heart-pulse','fa-person-praying','fa-hands-holding-child','fa-wine-bottle','fa-smoking','fa-pills','fa-dumbbell','fa-bowl-food'] as $ic)<option value="{{ $ic }}">@endforeach
                            </datalist>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Display order</label>
                            <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $service->sort_order ?? 0) }}" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h5 class="mb-0 fw-semibold"><i class="fa-solid fa-magnifying-glass-chart me-1 text-primary"></i> SEO</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold d-flex justify-content-between">Meta title <span class="vv-count text-muted" data-for="meta_title" data-max="60"></span></label>
                        <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $service->meta_title) }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold d-flex justify-content-between">Meta description <span class="vv-count text-muted" data-for="meta_description" data-max="160"></span></label>
                        <textarea name="meta_description" id="meta_description" rows="3" maxlength="320" class="form-control">{{ old('meta_description', $service->meta_description) }}</textarea>
                    </div>
                    <div>
                        <label class="form-label fw-semibold">Meta keywords</label>
                        <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $service->meta_keywords) }}" class="form-control" placeholder="alcohol de-addiction madurai, rehab centre">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0 fw-semibold">Image</h5></div>
                <div class="card-body">
                    <img id="imgPreview" src="{{ $service->image ? $service->imageUrl() : '' }}" class="img-fluid rounded-3 mb-3 {{ $service->image ? '' : 'd-none' }}" alt="">
                    <input type="file" name="image_file" accept="image/*" class="form-control" onchange="const f=this.files[0];if(f){const i=document.getElementById('imgPreview');i.src=URL.createObjectURL(f);i.classList.remove('d-none')}">
                    <small class="text-muted">JPG, PNG or WEBP, up to 4 MB. Landscape works best.</small>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $service->is_active))>
                        <label class="form-check-label fw-semibold" for="is_active">Visible on website</label>
                    </div>
                    <button class="btn btn-primary w-100"><i class="fa-solid fa-floppy-disk me-1"></i> {{ $service->exists ? 'Update' : 'Save' }} Service</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
const slugify = s => s.toLowerCase().trim().replace(/[^a-z0-9\s-]/g, '').replace(/[\s-]+/g, '-').replace(/^-|-$/g, '');
let slugTouched = !!$('#slug').val();
$('#slug').on('input', () => slugTouched = true);
$('#title').on('input', function () { if (!slugTouched) $('#slug').val(slugify(this.value)); });
$('#icon').on('input', function () { $('#iconPreview').attr('class', 'fa-solid ' + this.value); });
$('.vv-count').each(function () {
    const c = $(this), f = $('#' + c.data('for')), max = c.data('max');
    const upd = () => { const n = f.val().length; c.text(n + ' / ' + max).toggleClass('text-danger', n > max); };
    f.on('input', upd); upd();
});
</script>
@endpush
