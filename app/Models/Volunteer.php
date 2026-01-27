<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    use HasUuid;
    protected $fillable = [
        'name',
        'phone',
        'email',
        'help_type',
        'notes',
        'status',
    ];
}
