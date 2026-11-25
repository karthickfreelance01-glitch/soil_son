<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'title', 'slug', 'icon', 'image', 'short_description', 'content', 'link_url',
        'sort_order', 'is_active', 'meta_title', 'meta_description', 'meta_keywords',
    ];

    protected $casts = ['is_active' => 'boolean'];

    protected static function booted(): void
    {
        static::saving(function (Service $s) {
            if (blank($s->slug)) {
                $s->slug = Str::slug($s->title);
            }
        });
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    /** Where the public "Read more" button goes: an existing page, or /services/{slug}. */
    public function url(): string
    {
        return $this->link_url ?: url('/services/'.$this->slug);
    }

    public function imageUrl(): ?string
    {
        return $this->image ? asset($this->image) : null;
    }
}
