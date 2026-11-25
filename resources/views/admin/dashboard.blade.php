@extends('admin.layout')
@section('title', 'Dashboard')

@section('content')
<div class="card vv-welcome shadow-lg mb-4 border-0">
    <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 p-4 position-relative" style="z-index:1">
        <div>
            <h2 class="fw-bold mb-2 text-white">👋 Welcome back, {{ auth()->user()->name }}!</h2>
            <p class="mb-1 fs-6 fst-italic text-white">“Every enquiry is someone reaching out for a new beginning.” 🌟</p>
            <p class="text-white-50 mb-0">Here’s a quick overview of the website activity.</p>
        </div>
        <a href="{{ route('admin.enquiries.index', ['status' => 'new']) }}" class="btn btn-light fw-semibold px-4">
            <i class="fa-solid fa-bell me-1 text-danger"></i> {{ $stats['enquiries_new'] }} new enquiries
        </a>
    </div>
</div>

@php
    $widgets = [
        ['New Enquiries', $stats['enquiries_new'], 'fa-bell', '#ff6a00,#ee0979', route('admin.enquiries.index', ['status' => 'new'])],
        ['Today', $stats['enquiries_today'], 'fa-calendar-day', '#2f47e0,#2575fc', route('admin.enquiries.index', ['from' => today()->toDateString()])],
        ['This Month', $stats['enquiries_month'], 'fa-chart-line', '#1a28aa,#2f47e0', route('admin.enquiries.index', ['from' => now()->startOfMonth()->toDateString()])],
        ['Admitted', $stats['admitted'], 'fa-hospital-user', '#11998e,#38ef7d', route('admin.enquiries.index', ['status' => 'admitted'])],
    ];
    if (auth()->user()->isAdmin()) {
        $widgets[] = ['Total Enquiries', $stats['enquiries_total'], 'fa-envelope-open-text', '#36d1dc,#5b86e5', route('admin.enquiries.index')];
        $widgets[] = ['Services', $stats['services'], 'fa-hand-holding-heart', '#2f47e0,#2f47e0', route('admin.services.index')];
        $widgets[] = ['Gallery Photos', $stats['gallery'], 'fa-images', '#f7971e,#ffd200', route('admin.gallery.index')];
        $widgets[] = ['Admin & Staff', $stats['staff'], 'fa-users-gear', '#434343,#7a7a7a', route('admin.users.index')];
    } else {
        $widgets[] = ['Gallery Photos', $stats['gallery'], 'fa-images', '#f7971e,#ffd200', route('admin.gallery.index')];
    }
@endphp
<div class="row g-4 mb-4">
    @foreach($widgets as [$title, $num, $icon, $bg, $url])
        <div class="col-xl-3 col-md-6">
            <a href="{{ $url }}" class="card widget-card h-100" style="background:linear-gradient(135deg,{{ $bg }})">
                <div class="card-body d-flex align-items-center justify-content-between p-4">
                    <div>
                        <div class="vv-num text-white">{{ $num }}</div>
                        <div class="text-white fw-semibold mt-2">{{ $title }}</div>
                    </div>
                    <div class="vv-ico text-white"><i class="fa-solid {{ $icon }}"></i></div>
                </div>
            </a>
        </div>
    @endforeach
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <div class="card h-100">
            <div class="card-header"><h5 class="mb-0 fw-semibold">Enquiries — last 14 days</h5></div>
            <div class="card-body"><canvas id="enqChart" height="110"></canvas></div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card h-100">
            <div class="card-header"><h5 class="mb-0 fw-semibold">By service</h5></div>
            <div class="card-body">
                @forelse($byService as $row)
                    @php $pct = $stats['enquiries_total'] ? round($row->total / $stats['enquiries_total'] * 100) : 0; @endphp
                    <div class="mb-3">
                        <div class="d-flex justify-content-between small mb-1"><span class="fw-semibold">{{ $row->service }}</span><span class="text-muted">{{ $row->total }}</span></div>
                        <div class="progress" style="height:8px"><div class="progress-bar" style="width:{{ $pct }}%;background:linear-gradient(90deg,#1a28aa,#2f47e0)"></div></div>
                    </div>
                @empty
                    <p class="text-muted mb-0">No enquiries yet.</p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">Latest enquiries</h5>
                <a href="{{ route('admin.enquiries.index') }}" class="btn btn-sm btn-outline-primary">View all</a>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Date</th><th>Name</th><th>Mobile</th><th>Service</th><th>Form</th><th>Status</th><th></th></tr></thead>
                    <tbody>
                    @forelse($recent as $e)
                        <tr>
                            <td class="text-nowrap">{{ $e->created_at->format('d M, h:i A') }}</td>
                            <td class="fw-semibold">{{ $e->name }}</td>
                            <td><a href="tel:{{ $e->mobile }}">{{ $e->mobile }}</a></td>
                            <td>{{ $e->service ?: '—' }}</td>
                            <td><span class="badge bg-light text-dark">{{ \App\Models\Enquiry::SOURCES[$e->source] ?? $e->source }}</span></td>
                            <td><span class="badge bg-{{ $e->statusColor() }}">{{ $e->statusLabel() }}</span></td>
                            <td class="text-end"><a href="{{ route('admin.enquiries.show', $e) }}" class="btn btn-sm btn-light"><i class="fa-solid fa-eye"></i></a></td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">No enquiries yet. They will appear here as soon as visitors use the contact or side enquiry form.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
(function () {
    const ctx = document.getElementById('enqChart');
    if (!ctx || typeof Chart === 'undefined') return;
    const g = ctx.getContext('2d').createLinearGradient(0, 0, 0, 260);
    g.addColorStop(0, 'rgba(47,71,224,.35)'); g.addColorStop(1, 'rgba(26,40,170,0)');
    new Chart(ctx, {
        type: 'line',
        data: { labels: @json($chart['labels']), datasets: [{ label: 'Enquiries', data: @json($chart['values']),
            borderColor: '#2f47e0', backgroundColor: g, fill: true, tension: .35, pointRadius: 4, pointBackgroundColor: '#1a28aa' }] },
        options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 } }, x: { grid: { display: false } } } }
    });
})();
</script>
@endpush
