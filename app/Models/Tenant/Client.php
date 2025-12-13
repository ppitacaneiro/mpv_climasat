<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'tax_id',
        'contact',
        'phone',
        'email',
        'address',
        'history',
    ];
}
