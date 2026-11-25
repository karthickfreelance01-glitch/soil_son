<?php

namespace Database\Seeders;

use App\Models\GalleryItem;
use App\Models\SeoPage;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Safe to run more than once: it only adds rows that are missing and never
 * overwrites anything you have edited in the admin panel.
 *
 *   php artisan db:seed --class=SoilSonsSeeder
 */
class SoilSonsSeeder extends Seeder
{
    public function run(): void
    {
        /* ---------- First admin account ---------- */
        User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@soilsons.org')],
            [
                'name'      => 'SSWF Admin',
                'password'  => Hash::make(env('ADMIN_PASSWORD', 'SSWF@123')),
                'role'      => 'admin',
                'status'    => 1,
            ]
        );

        /* ---------- Services (the three existing pages) ---------- */
        $services = [
            [
                'title' => 'De-Addiction', 'slug' => 'de-addiction', 'icon' => 'fa-hand-holding-heart',
                'image' => 'assets/uploads/sswf/service-de-addiction.jpg', 'link_url' => '/de-addiction',
                'short_description' => 'Medically supervised detox and a structured de-addiction programme for alcohol and drug dependence, delivered with dignity and care.',
                'meta_title' => 'De-Addiction Centre in Madurai | Soil Sons Welfare Foundation',
            ],
            [
                'title' => 'Rehabilitation', 'slug' => 'rehabilitation', 'icon' => 'fa-seedling',
                'image' => 'assets/uploads/sswf/service-rehabilitation.jpg', 'link_url' => '/rehabilitation',
                'short_description' => 'Residential rehabilitation that rebuilds strength, confidence and purpose through therapy, routine, yoga and family support.',
                'meta_title' => 'Rehabilitation Centre in Madurai | Soil Sons Welfare Foundation',
            ],
            [
                'title' => 'Individual Counselling', 'slug' => 'individual-counselling', 'icon' => 'fa-comments',
                'image' => 'assets/uploads/sswf/service-counselling.jpg', 'link_url' => '/individual-counselling',
                'short_description' => 'Private one-to-one sessions with experienced counsellors in a safe, confidential space to understand yourself and move forward.',
                'meta_title' => 'Individual Counselling in Madurai | Soil Sons Welfare Foundation',
            ],
        ];
        foreach ($services as $i => $s) {
            Service::firstOrCreate(['slug' => $s['slug']], $s + [
                'sort_order' => $i + 1, 'is_active' => true,
                'meta_description' => $s['short_description'],
            ]);
        }

        /* ---------- Gallery (the photos already on the site) ---------- */
        $gallery = [
            ['yoga-session', 'Yoga Session', 'Therapy'],
            ['awareness-class', 'Awareness Class', 'Therapy'],
            ['counselling-desk', 'Counselling Desk', 'Therapy'],
            ['office-reception', 'Office Reception', 'Facilities'],
            ['lounge', 'Lounge', 'Facilities'],
            ['counselling-room', 'Counselling Room', 'Therapy'],
            ['dormitory-hall', 'Dormitory Hall', 'Facilities'],
            ['dormitory', 'Dormitory', 'Facilities'],
            ['main-gate', 'Main Gate', 'Campus'],
            ['entrance-pergola', 'Entrance Pergola', 'Campus'],
            ['campus-courtyard', 'Campus Courtyard', 'Campus'],
            ['campus-front', 'Campus Front View', 'Campus'],
            ['campus-building', 'Campus Building', 'Campus'],
            ['campus-garden-view', 'Garden View', 'Campus'],
            ['campus-surroundings', 'Green Surroundings', 'Campus'],
        ];
        foreach ($gallery as $i => [$file, $title, $cat]) {
            GalleryItem::firstOrCreate(
                ['image' => "assets/uploads/sswf/{$file}.jpg"],
                ['title' => $title, 'category' => $cat, 'sort_order' => $i + 1, 'is_active' => true,
                 'alt_text' => "{$title} - Soil Sons Welfare Foundation, Madurai"]
            );
        }

        /* ---------- SEO for every public page ---------- */
        $kw = 'de-addiction centre madurai, rehabilitation centre madurai, alcohol rehab, drug rehab, counselling madurai, sswf';
        $pages = [
            ['home', 'Home', '/', 'Best De-addiction center in Madurai | Soil Sons Welfare Foundation',
             'Best De-addiction center in Madurai - Soil Sons Welfare Foundation is a trusted and compassionate de-addiction and rehabilitation centre committed to helping individuals reclaim their lives.'],
            ['about', 'About', '/about', 'Best rehabilitation centre in Madurai',
             'Soil Sons Welfare Foundation is a trusted and compassionate de-addiction and rehabilitation centre in Madurai, helping individuals and families rebuild their lives.'],
            ['services', 'Services', '/services', 'Our Services | De-Addiction, Rehabilitation & Counselling in Madurai',
             'Explore de-addiction, residential rehabilitation and individual counselling services at Soil Sons Welfare Foundation, Sellur, Madurai.'],
            ['de-addiction', 'De-Addiction', '/de-addiction', 'De-Addiction - Soil Sons Welfare Foundation',
             'Addiction can take control of one’s life—impacting health, relationships, and self-worth. At our de-addiction centre in Madurai, recovery begins with care.'],
            ['rehabilitation', 'Rehabilitation', '/rehabilitation', 'Rehabilitation - Soil Sons Welfare Foundation',
             'Rehabilitation is more than recovery—it is the process of rebuilding strength, confidence, and purpose after overcoming addiction or personal challenges.'],
            ['individual-counselling', 'Individual Counselling', '/individual-counselling', 'Best Individual counselling in Madurai',
             'Best Individual counselling in Madurai - our counselling sessions offer a safe, confidential space to understand yourself and overcome life’s challenges.'],
            ['gallery', 'Gallery', '/gallery', 'Gallery - Soil Sons Welfare Foundation',
             'See our campus, therapy spaces, dormitories and facilities at Soil Sons Welfare Foundation, Sellur, Madurai.'],
            ['contact', 'Contact', '/contact', 'Contact - Soil Sons Welfare Foundation',
             'Contact Soil Sons Welfare Foundation, Sellur, Madurai. Call +91 74181 44991 or send an enquiry and our team will reach you shortly.'],
        ];
        foreach ($pages as [$key, $name, $path, $title, $desc]) {
            SeoPage::firstOrCreate(['page_key' => $key], [
                'page_name' => $name, 'path' => $path, 'meta_title' => $title,
                'meta_description' => $desc, 'meta_keywords' => $kw,
            ]);
        }
    }
}
