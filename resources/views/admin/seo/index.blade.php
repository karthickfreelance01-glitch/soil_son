@extends('admin.layout')
@section('title', 'SEO')
@section('subtitle', 'Google title, description and share image for every page')
@section('breadcrumb', 'SEO')
@section('actions')
    <a href="{{ route('sitemap') }}" target="_blank" class="btn btn-light btn-sm"><i class="fa-solid fa-sitemap me-1"></i> sitemap.xml</a>
@endsection

@section('content')
<div class="alert alert-light border d-flex gap-2 align-items-start">
    <i class="fa-solid fa-lightbulb text-warning mt-1"></i>
    <div class="small">Keep titles under <b>60</b> characters and descriptions under <b>160</b>. Put the main search phrase first, for example <i>“De-Addiction Centre in Madurai”</i>. Each service also has its own SEO fields under <a href="{{ route('admin.services.index') }}">Services</a>. Submit <code>{{ rtrim(config('site.url'), '/') }}/sitemap.xml</code> in Google Search Console.</div>
</div>

<div class="accordion" id="seoAcc">
@foreach($pages as $p)
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center" role="button" data-bs-toggle="collapse" data-bs-target="#seo{{ $p->id }}">
            <div>
                <h6 class="mb-0 fw-semibold">{{ $p->page_name }} <small class="text-muted fw-normal ms-1">{{ $p->path }}</small></h6>
                <div class="vv-serp mt-2 d-none d-md-block">
                    <div class="t">{{ \Illuminate\Support\Str::limit($p->meta_title, 65) }}</div>
                    <div class="u">{{ rtrim(config('site.url'), '/') }}{{ $p->path === '/' ? '' : $p->path }}</div>
                    <div class="d">{{ \Illuminate\Support\Str::limit($p->meta_description, 160) }}</div>
                </div>
            </div>
            <div class="text-nowrap">
                @if($p->noindex)<span class="badge bg-warning text-dark me-2">noindex</span>@endif
                <i class="fa-solid fa-chevron-down text-muted"></i>
            </div>
        </div>
        <div id="seo{{ $p->id }}" class="collapse" data-bs-parent="#seoAcc">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.seo.update', $p) }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-lg-8">
                            <label class="form-label fw-semibold d-flex justify-content-between">Meta title * <span class="vv-count text-muted" data-max="60"></span></label>
                            <input type="text" name="meta_title" value="{{ $p->meta_title }}" class="form-control js-count" required>
                            <label class="form-label fw-semibold d-flex justify-content-between mt-3">Meta description * <span class="vv-count text-muted" data-max="160"></span></label>
                            <textarea name="meta_description" rows="3" maxlength="320" class="form-control js-count" required>{{ $p->meta_description }}</textarea>
                            <label class="form-label fw-semibold mt-3">Keywords</label>
                            <input type="text" name="meta_keywords" value="{{ $p->meta_keywords }}" class="form-control" placeholder="comma, separated, keywords">
                            <div class="form-check form-switch mt-3">
                                <input class="form-check-input" type="checkbox" name="noindex" value="1" id="ni{{ $p->id }}" @checked($p->noindex)>
                                <label class="form-check-label" for="ni{{ $p->id }}">Hide this page from Google (noindex)</label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label fw-semibold">Share image <span class="text-muted fw-normal">(WhatsApp / Facebook)</span></label>
                            <img src="{{ asset($p->og_image ?: 'assets/uploads/sswf/hero-1.jpg') }}" class="img-fluid rounded-3 mb-2 w-100" style="max-height:160px;object-fit:cover" alt="">
                            <input type="file" name="og_image_file" accept="image/*" class="form-control">
                            <small class="text-muted">1200 × 630 px recommended.</small>
                        </div>
                    </div>
                    <div class="text-end mt-3"><button class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i> Save {{ $p->page_name }}</button></div>
                </form>
            </div>
        </div>
    </div>
@endforeach
</div>
@endsection

@push('scripts')
<script>
$('.js-count').each(function () {
    const f = $(this), c = f.prev('label').find('.vv-count'), max = c.data('max');
    const upd = () => { const n = f.val().length; c.text(n + ' / ' + max).toggleClass('text-danger', n > max); };
    f.on('input', upd); upd();
});
</script>
@endpush
