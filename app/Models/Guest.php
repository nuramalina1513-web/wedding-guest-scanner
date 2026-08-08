<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'guest_type',
        'invitation_limit',
        'attended_count',
        'scanned_at',
    ];

    protected function casts():array
    {
        return [
            'invitation_limit' => 'integer',
            'attended_count' => 'integer',
            'scanned_at' => 'datetime',
        ];
    }
}
