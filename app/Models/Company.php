<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'name',
        'subdomain',
        'contract_start_at',
        'contract_end_at',
        'billing_status',
        'is_suspended',
        'enabled_modules',
    ];

    protected $casts = [
        'contract_start_at' => 'datetime',
        'contract_end_at'   => 'datetime',
        'enabled_modules'   => 'array',
        'is_suspended'      => 'boolean',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }
}
