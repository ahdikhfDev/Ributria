<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Artist extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($artist) {
            if ($artist->image && Storage::disk('public')->exists($artist->image)) {
                Storage::disk('public')->delete($artist->image);
            }
        });
    }
}
