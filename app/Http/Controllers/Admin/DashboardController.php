<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\GalleryItem;
use App\Models\Service;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'enquiries_total' => Enquiry::count(),
            'enquiries_new'   => Enquiry::where('status', 'new')->count(),
            'enquiries_today' => Enquiry::whereDate('created_at', today())->count(),
            'enquiries_month' => Enquiry::where('created_at', '>=', now()->startOfMonth())->count(),
            'admitted'        => Enquiry::where('status', 'admitted')->count(),
            'services'        => Service::where('is_active', true)->count(),
            'gallery'         => GalleryItem::where('is_active', true)->count(),
            'staff'           => User::count(),
        ];

        // Enquiries per day for the last 14 days (for the chart)
        $days = collect(range(13, 0))->map(fn ($i) => now()->subDays($i)->startOfDay());
        $counts = Enquiry::where('created_at', '>=', $days->first())
            ->get(['created_at'])
            ->groupBy(fn ($e) => $e->created_at->format('Y-m-d'))
            ->map->count();
        $chart = [
            'labels' => $days->map->format('d M')->values(),
            'values' => $days->map(fn ($d) => $counts[$d->format('Y-m-d')] ?? 0)->values(),
        ];

        $byService = Enquiry::selectRaw("COALESCE(service, 'General') as service, COUNT(*) as total")
            ->groupBy('service')->orderByDesc('total')->limit(6)->get();

        $recent = Enquiry::latest()->limit(8)->get();

        return view('admin.dashboard', compact('stats', 'chart', 'byService', 'recent'));
    }
}
