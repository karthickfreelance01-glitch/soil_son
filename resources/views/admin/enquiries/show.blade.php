@extends('admin.layout')
@section('title', 'Enquiry #'.$enquiry->id)
@section('subtitle', 'Received '.$enquiry->created_at->format('d M Y, h:i A').' ('.$enquiry->created_at->diffForHumans().')')
@section('breadcrumb', 'Enquiry')
@section('actions')
    <a href="{{ route('admin.enquiries.index') }}" class="btn btn-light btn-sm"><i class="fa-solid fa-arrow-left me-1"></i> All enquiries</a>
@endsection

@section('content')
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">{{ $enquiry->name }}</h5>
                <span class="badge bg-{{ $enquiry->statusColor() }} fs-6">{{ $enquiry->statusLabel() }}</span>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-3">
                    <tr><th class="text-muted" style="width:150px">Mobile</th><td><a href="tel:{{ $enquiry->mobile }}" class="fw-semibold">{{ $enquiry->mobile }}</a></td></tr>
                    <tr><th class="text-muted">Email</th><td>@if($enquiry->email)<a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a>@else — @endif</td></tr>
                    <tr><th class="text-muted">Address</th><td>{{ $enquiry->address ?: '—' }}</td></tr>
                    <tr><th class="text-muted">Service</th><td>{{ $enquiry->service ?: '—' }}</td></tr>
                    <tr><th class="text-muted">Message</th><td>{!! $enquiry->message ? nl2br(e($enquiry->message)) : '—' !!}</td></tr>
                    <tr><th class="text-muted">Form</th><td>{{ \App\Models\Enquiry::SOURCES[$enquiry->source] ?? $enquiry->source }}</td></tr>
                    <tr><th class="text-muted">Sent from page</th><td class="text-break">{{ $enquiry->page_url ?: '—' }}</td></tr>
                    <tr><th class="text-muted">IP address</th><td>{{ $enquiry->ip ?: '—' }}</td></tr>
                </table>
                @php $digits = preg_replace('/\D/', '', $enquiry->mobile); $wa = strlen($digits) === 10 ? '91'.$digits : $digits; @endphp
                <div class="d-flex gap-2 flex-wrap">
                    <a href="tel:{{ $enquiry->mobile }}" class="btn btn-primary"><i class="fa-solid fa-phone me-1"></i> Call</a>
                    <a href="https://wa.me/{{ $wa }}?text={{ rawurlencode('Hello '.$enquiry->name.', this is Soil Sons Welfare Foundation regarding your enquiry.') }}" target="_blank" class="btn btn-success"><i class="fa-brands fa-whatsapp me-1"></i> WhatsApp</a>
                    @if($enquiry->email)<a href="mailto:{{ $enquiry->email }}" class="btn btn-outline-primary"><i class="fa-solid fa-envelope me-1"></i> Email</a>@endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header"><h5 class="mb-0 fw-semibold">Follow-up</h5></div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.enquiries.update', $enquiry) }}">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            @foreach(\App\Models\Enquiry::STATUSES as $k => $st)<option value="{{ $k }}" @selected($enquiry->status === $k)>{{ $st['label'] }}</option>@endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Notes</label>
                        <textarea name="notes" rows="7" class="form-control" placeholder="Call summary, next follow-up date, family details...">{{ old('notes', $enquiry->notes) }}</textarea>
                    </div>
                    <button class="btn btn-primary w-100"><i class="fa-solid fa-floppy-disk me-1"></i> Save</button>
                </form>
                @if($enquiry->handler)
                    <p class="text-muted small mt-3 mb-0">Last updated by <strong>{{ $enquiry->handler->name }}</strong> · {{ $enquiry->updated_at->diffForHumans() }}</p>
                @endif
                @if(auth()->user()->isAdmin())
                    <hr>
                    <form action="{{ route('admin.enquiries.destroy', $enquiry) }}" method="POST" class="js-confirm-delete" data-title="Delete this enquiry?">
                        @csrf @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm w-100"><i class="fa-solid fa-trash me-1"></i> Delete enquiry</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
