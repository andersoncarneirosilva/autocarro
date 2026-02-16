<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\MultiTenantModelTrait;

class WhatsappInstance extends Model
{
    use MultiTenantModelTrait;

    protected $fillable = [
        'empresa_id',
        'name',
        'token',
        'status',
        'qrcode'
    ];
}