<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;

class DonationPoint extends Model
{
    use HasUuid;
    protected $fillable = [
        'zone_id',
        'name',
        'address',
        'schedule',
        'phone',
        'whatsapp',
        'notes',
        'active',
        'order',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}
