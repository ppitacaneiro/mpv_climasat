<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    protected $fillable = [
        'name',
        'tax_id',
        'specialty',
        'phone',
        'email',
        'availability',
    ];

    protected $casts = [
        'availability' => 'string',
    ];
}
