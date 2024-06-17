<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Activity extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'type',
        'distance',
        'time',
        'started_at'
    ];

    protected $casts = ['id' => 'string'];

    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
}
