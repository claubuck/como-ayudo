<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasUuid;
    
    protected $fillable = [
        'name',
        'description',
        'status',
        'active',
        'order',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function donationPoints()
    {
        return $this->hasMany(DonationPoint::class);
    }
}
