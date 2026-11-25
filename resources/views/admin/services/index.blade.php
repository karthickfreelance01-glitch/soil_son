@extends('admin.layout')
@section('title', 'Services')
@section('subtitle', 'Shown on the Services page, the menu dropdown and the enquiry forms')
@section('breadcrumb', 'Services')
@section('actions')
    <a href="{{ route('services') }}" target="_blank" class="btn btn-light btn-sm"><i class="fa-solid fa-eye me-1"></i> View page</a>
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus me-1"></i> Add Service</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body table-responsive">
        <table class="table align-middle js-datatable">
            <thead><tr><th>Order</th><th>Image</th><th>Service</th><th>Opens</th><th>SEO title</th><th>Visible</th><th class="text-end">Action</th></tr></thead>
            <tbody>
            @foreach($services as $s)
                <tr>
                    <td>{{ $s->sort_order }}</td>
                    <td>@if($s->image)<img src="{{ $s->imageUrl() }}" class="vv-thumb" alt="">@else<span class="vv-thumb d-inline-flex align-items-center justify-content-center bg-light"><i class="fa-solid {{ $s->icon ?: 'fa-hand-holding-heart' }} text-primary"></i></span>@endif</td>
                    <td><div class="fw-semibold"><i class="fa-solid {{ $s->icon }} text-primary me-1"></i> {{ $s->title }}</div><small class="text-muted">{{ \Illuminate\Support\Str::limit($s->short_description, 80) }}</small></td>
                    <td><a href="{{ $s->url() }}" target="_blank" class="small">{{ $s->link_url ?: '/services/'.$s->slug }}</a></td>
                    <td class="small">{{ \Illuminate\Support\Str::limit($s->meta_title, 45) ?: '—' }}</td>
                    <td><div class="form-check form-switch"><input class="form-check-input js-toggle" type="checkbox" data-url="{{ route('admin.services.toggle', $s) }}" @checked($s->is_active)></div></td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('admin.services.edit', $s) }}" class="btn btn-sm btn-light" title="Edit"><i class="fa-solid fa-pen"></i></a>
                        <form action="{{ route('admin.services.destroy', $s) }}" method="POST" class="d-inline js-confirm-delete" data-title="Delete {{ $s->title }}?">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-light text-danger" title="Delete"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).on('change', '.js-toggle', function () {
    $.post($(this).data('url')).done(r => vvToast.fire({ icon: 'success', title: r.active ? 'Now visible on the website' : 'Hidden from the website' }));
});
</script>
@endpush
