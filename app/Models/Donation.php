<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasUuid;
    protected $fillable = [
        'name',
        'description',
        'quantity_needed',
        'quantity_received',
        'unit',
        'priority',
        'active',
        'order',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function getProgressPercentageAttribute(): int
    {
        if ($this->quantity_needed == 0) {
            return 0;
        }
        return min(100, (int) (($this->quantity_received / $this->quantity_needed) * 100));
    }

    public function getIsFulfilledAttribute(): bool
    {
        return $this->quantity_received >= $this->quantity_needed;
    }
}
