@extends('admin.layout')
@section('title', 'Enquiries')
@section('subtitle', 'Every enquiry from the contact page and the side enquiry panel')
@section('breadcrumb', 'Enquiries')
@section('actions')
    <a href="{{ route('admin.enquiries.export', request()->query()) }}" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-file-csv me-1"></i> Export CSV</a>
@endsection

@section('content')
<ul class="nav vv-status-pills mb-3 gap-1">
    <li class="nav-item"><a class="nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('admin.enquiries.index', request()->except('status')) }}">All <span class="badge bg-light text-dark ms-1">{{ $counts->sum() }}</span></a></li>
    @foreach(\App\Models\Enquiry::STATUSES as $key => $st)
        <li class="nav-item"><a class="nav-link {{ request('status') === $key ? 'active' : '' }}" href="{{ route('admin.enquiries.index', array_merge(request()->except('status'), ['status' => $key])) }}">{{ $st['label'] }} <span class="badge bg-{{ $st['color'] }} ms-1">{{ $counts[$key] ?? 0 }}</span></a></li>
    @endforeach
</ul>

<div class="card mb-3">
    <div class="card-body">
        <form class="row g-2 align-items-end" method="GET">
            @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
            <div class="col-md-3"><label class="form-label small">Search</label><input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Name, mobile, email, service"></div>
            <div class="col-md-2"><label class="form-label small">Form</label>
                <select name="source" class="form-select"><option value="">All forms</option>
                    @foreach(\App\Models\Enquiry::SOURCES as $k => $v)<option value="{{ $k }}" @selected(request('source') === $k)>{{ $v }}</option>@endforeach
                </select></div>
            <div class="col-md-2"><label class="form-label small">From</label><input type="date" name="from" value="{{ request('from') }}" class="form-control"></div>
            <div class="col-md-2"><label class="form-label small">To</label><input type="date" name="to" value="{{ request('to') }}" class="form-control"></div>
            <div class="col-md-3 d-flex gap-2"><button class="btn btn-primary flex-fill"><i class="fa-solid fa-filter me-1"></i> Filter</button>
                <a href="{{ route('admin.enquiries.index') }}" class="btn btn-light">Reset</a></div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body table-responsive">
        <table class="table align-middle js-datatable">
            <thead><tr><th>#</th><th>Date</th><th>Name</th><th>Mobile</th><th>Service</th><th>Form</th><th>Status</th><th>Handled by</th><th class="text-end">Action</th></tr></thead>
            <tbody>
            @foreach($enquiries as $e)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-nowrap" data-order="{{ $e->created_at->timestamp }}">{{ $e->created_at->format('d M Y') }}<br><small class="text-muted">{{ $e->created_at->format('h:i A') }}</small></td>
                    <td class="fw-semibold">{{ $e->name }}@if($e->email)<br><small class="text-muted">{{ $e->email }}</small>@endif</td>
                    <td class="text-nowrap"><a href="tel:{{ $e->mobile }}">{{ $e->mobile }}</a>
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', strlen(preg_replace('/\D/', '', $e->mobile)) === 10 ? '91'.$e->mobile : $e->mobile) }}" target="_blank" class="text-success ms-1" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a></td>
                    <td>{{ $e->service ?: '—' }}</td>
                    <td><span class="badge bg-light text-dark">{{ \App\Models\Enquiry::SOURCES[$e->source] ?? $e->source }}</span></td>
                    <td>
                        <select class="form-select form-select-sm js-status" data-url="{{ route('admin.enquiries.update', $e) }}" style="min-width:120px">
                            @foreach(\App\Models\Enquiry::STATUSES as $k => $st)<option value="{{ $k }}" @selected($e->status === $k)>{{ $st['label'] }}</option>@endforeach
                        </select>
                    </td>
                    <td>{{ optional($e->handler)->name ?: '—' }}</td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('admin.enquiries.show', $e) }}" class="btn btn-sm btn-light" title="View"><i class="fa-solid fa-eye"></i></a>
                        @if(auth()->user()->isAdmin())
                        <form action="{{ route('admin.enquiries.destroy', $e) }}" method="POST" class="d-inline js-confirm-delete" data-title="Delete this enquiry?">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-light text-danger" title="Delete"><i class="fa-solid fa-trash"></i></button>
                        </form>
                        @endif
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
$(document).on('change', '.js-status', function () {
    const sel = $(this);
    $.ajax({ url: sel.data('url'), method: 'POST', data: { _method: 'PUT', status: sel.val() } })
        .done(r => vvToast.fire({ icon: 'success', title: r.message }))
        .fail(() => vvToast.fire({ icon: 'error', title: 'Could not update the status' }));
});
</script>
@endpush
