<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    protected $fillable = ['title', 'image', 'category', 'alt_text', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive($q)
    {
        return $q->where('is_active', true)->orderBy('sort_order')->orderByDesc('id');
    }

    public function imageUrl(): string
    {
        return asset($this->image);
    }
}
