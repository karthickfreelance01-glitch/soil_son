<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $fillable = [
        'name', 'mobile', 'email', 'address', 'service', 'message',
        'source', 'page_url', 'status', 'notes', 'handled_by', 'ip',
    ];

    public const STATUSES = [
        'new'       => ['label' => 'New',       'color' => 'danger'],
        'contacted' => ['label' => 'Contacted', 'color' => 'warning'],
        'admitted'  => ['label' => 'Admitted',  'color' => 'success'],
        'closed'    => ['label' => 'Closed',    'color' => 'secondary'],
    ];

    public const SOURCES = [
        'contact' => 'Contact page',
        'sidebar' => 'Side enquiry',
    ];

    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status]['label'] ?? ucfirst((string) $this->status);
    }

    public function statusColor(): string
    {
        return self::STATUSES[$this->status]['color'] ?? 'secondary';
    }
}
