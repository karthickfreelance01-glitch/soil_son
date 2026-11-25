<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Support\SiteData;
use Illuminate\Support\Facades\Schema;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', ['active' => 'home']);
    }

    public function about()
    {
        return view('pages.about', ['active' => 'about']);
    }

    public function deAddiction()
    {
        return view('pages.de-addiction', ['active' => 'de-addiction']);
    }

    public function rehabilitation()
    {
        return view('pages.rehabilitation', ['active' => 'rehabilitation']);
    }

    public function individualCounselling()
    {
        return view('pages.individual-counselling', ['active' => 'individual-counselling']);
    }

    public function services()
    {
        return view('pages.services', [
            'active'   => 'services',
            'services' => SiteData::services(),
        ]);
    }

    /** Detail page for services added from the admin panel (those without their own page). */
    public function serviceShow(string $slug)
    {
        $service = null;
        try {
            if (Schema::hasTable('services')) {
                $service = Service::where('slug', $slug)->where('is_active', true)->first();
            }
        } catch (\Throwable $e) {
        }
        abort_unless($service, 404);

        // A service that points to an existing page goes there instead.
        if ($service->link_url && $service->link_url !== '/services/'.$slug) {
            return redirect($service->link_url, 301);
        }

        return view('pages.service-show', [
            'active'   => 'services',
            'service'  => $service,
            'services' => SiteData::services(),
        ]);
    }

    public function gallery()
    {
        $items = SiteData::gallery();

        return view('pages.gallery', [
            'active'     => 'gallery',
            'items'      => $items,
            'categories' => $items->pluck('category')->filter()->unique()->values(),
        ]);
    }

    public function sitemap()
    {
        $base = rtrim(config('site.url'), '/');
        $urls = collect(['/', '/about', '/services', '/de-addiction', '/rehabilitation', '/individual-counselling', '/gallery', '/contact']);

        foreach (SiteData::services() as $s) {
            if (! $s->link_url && $s->slug) {
                $urls->push('/services/'.$s->slug);
            }
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n".'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
        foreach ($urls->unique() as $u) {
            $xml .= '  <url><loc>'.e($base.($u === '/' ? '/' : $u)).'</loc><changefreq>weekly</changefreq><priority>'.($u === '/' ? '1.0' : '0.8')."</priority></url>\n";
        }
        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
