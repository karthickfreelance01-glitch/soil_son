<?php

namespace App\Support;

use App\Models\GalleryItem;
use App\Models\Service;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

/**
 * Database-backed content for the public site, with safe fallbacks so the
 * site never breaks if the database is empty or not migrated yet.
 */
class SiteData
{
    public const DEFAULT_SERVICES = ['De-Addiction', 'Rehabilitation', 'Individual Counselling'];

    public static function services(): Collection
    {
        try {
            if (Schema::hasTable('services')) {
                $rows = Service::active()->get();
                if ($rows->isNotEmpty()) {
                    return $rows;
                }
            }
        } catch (\Throwable $e) {
        }

        return collect([
            new Service(['title' => 'De-Addiction', 'slug' => 'de-addiction', 'icon' => 'fa-hand-holding-heart', 'link_url' => '/de-addiction',
                'image' => 'assets/uploads/sswf/service-de-addiction.jpg',
                'short_description' => 'Medically supervised detox and a structured de-addiction programme for alcohol and drug dependence.']),
            new Service(['title' => 'Rehabilitation', 'slug' => 'rehabilitation', 'icon' => 'fa-seedling', 'link_url' => '/rehabilitation',
                'image' => 'assets/uploads/sswf/service-rehabilitation.jpg',
                'short_description' => 'Residential rehabilitation that rebuilds strength, confidence and purpose.']),
            new Service(['title' => 'Individual Counselling', 'slug' => 'individual-counselling', 'icon' => 'fa-comments', 'link_url' => '/individual-counselling',
                'image' => 'assets/uploads/sswf/service-counselling.jpg',
                'short_description' => 'Private one-to-one sessions in a safe, confidential space.']),
        ]);
    }

    /** Service names offered in the enquiry dropdowns. */
    public static function serviceNames(): array
    {
        return self::services()->pluck('title')->filter()->values()->all() ?: self::DEFAULT_SERVICES;
    }

    public static function gallery(): Collection
    {
        try {
            if (Schema::hasTable('gallery_items')) {
                $rows = GalleryItem::active()->get();
                if ($rows->isNotEmpty()) {
                    return $rows;
                }
            }
        } catch (\Throwable $e) {
        }

        $files = [
            ['yoga-session', 'Yoga Session', 'Therapy'], ['awareness-class', 'Awareness Class', 'Therapy'],
            ['counselling-desk', 'Counselling Desk', 'Therapy'], ['office-reception', 'Office Reception', 'Facilities'],
            ['lounge', 'Lounge', 'Facilities'], ['counselling-room', 'Counselling Room', 'Therapy'],
            ['dormitory-hall', 'Dormitory Hall', 'Facilities'], ['dormitory', 'Dormitory', 'Facilities'],
            ['main-gate', 'Main Gate', 'Campus'], ['entrance-pergola', 'Entrance Pergola', 'Campus'],
            ['campus-courtyard', 'Campus Courtyard', 'Campus'], ['campus-front', 'Campus Front View', 'Campus'],
        ];

        return collect($files)->map(fn ($f) => new GalleryItem([
            'image' => "assets/uploads/sswf/{$f[0]}.jpg", 'title' => $f[1], 'category' => $f[2],
            'alt_text' => "{$f[1]} - Soil Sons Welfare Foundation",
        ]));
    }
}
