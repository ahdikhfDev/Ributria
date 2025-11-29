<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guarded = [];

    // Cast features jadi array biar otomatis jadi JSON
    protected $casts = [
        'features' => 'array',
        'is_sold_out' => 'boolean',
        'is_featured' => 'boolean',
    ];
}