<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class FaultType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'priority',
    ];

    protected $casts = [
        'priority' => 'string',
    ];
}
