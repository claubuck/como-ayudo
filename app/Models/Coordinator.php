<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Coordinator extends Model
{
    use HasUuid;
    protected $fillable = [
        'name',
        'organization',
        'phone',
        'whatsapp',
        'email',
        'description',
        'active',
        'order',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
