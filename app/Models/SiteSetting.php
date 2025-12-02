<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    protected $guarded = [];

    protected static function booted()
{
    static::deleting(function ($model) {
        if ($model->qris_image) {
            Storage::disk('public')->delete($model->qris_image);
        }
    });
}

}
