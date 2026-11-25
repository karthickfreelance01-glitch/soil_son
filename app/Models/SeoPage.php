<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoPage extends Model
{
    protected $fillable = [
        'page_key', 'page_name', 'path', 'meta_title', 'meta_description',
        'meta_keywords', 'og_image', 'noindex',
    ];

    protected $casts = ['noindex' => 'boolean'];
}
