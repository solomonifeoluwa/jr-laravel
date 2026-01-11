<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Secret extends Model
{
    protected $fillable = [
        'public_id',
        'encrypted_payload',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];
}
