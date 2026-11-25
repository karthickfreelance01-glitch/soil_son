<?php

namespace App\Support;

use App\Models\SeoPage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

/**
 * Resolves the SEO data for a page: values saved in Admin > SEO win,
 * otherwise the defaults written in the page are used. Never throws, so
 * the public site keeps working even before the migrations are run.
 */
class Seo
{
    public static function for(string $key, array $defaults = []): array
    {
        $row = null;
        try {
            $row = Cache::remember("seo_page_{$key}", 600, function () use ($key) {
                return Schema::hasTable('seo_pages') ? SeoPage::where('page_key', $key)->first() : null;
            });
        } catch (\Throwable $e) {
            $row = null;
        }

        $base = rtrim(config('site.url'), '/');
        $path = $defaults['path'] ?? ($row->path ?? '/');

        return [
            'title'       => $row->meta_title ?? null ?: ($defaults['title'] ?? config('site.name')),
            'description' => $row->meta_description ?? null ?: ($defaults['description'] ?? ''),
            'keywords'    => $row->meta_keywords ?? null ?: ($defaults['keywords'] ?? ''),
            'image'       => self::absolute($row->og_image ?? null ?: ($defaults['image'] ?? 'assets/uploads/sswf/hero-1.jpg')),
            'canonical'   => $base.($path === '/' ? '/' : '/'.ltrim($path, '/')),
            'noindex'     => (bool) ($row->noindex ?? false),
            'type'        => $defaults['type'] ?? 'website',
        ];
    }

    public static function forget(string $key): void
    {
        Cache::forget("seo_page_{$key}");
    }

    public static function absolute(?string $path): ?string
    {
        if (! $path) {
            return null;
        }
        if (preg_match('#^https?://#', $path)) {
            return $path;
        }
        return rtrim(config('site.url'), '/').'/'.ltrim($path, '/');
    }
}
