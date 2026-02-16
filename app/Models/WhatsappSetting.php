<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\MultiTenantModelTrait;

class WhatsappSetting extends Model
{
    use MultiTenantModelTrait; // Sua trait mágica

    protected $fillable = [
        'empresa_id',
        'confirmation_is_active',
        'cancellation_is_active',
        'reminder_is_active',
        'bot_is_active',
        'confirmation_template',
        'cancellation_template',
        'reminder_template',
        'bot_template',
        'reminder_time',
        'bot_cooldown',
    ];
}