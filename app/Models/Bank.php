<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bank extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function merchants()
    {
        return $this->belongsToMany(Merchant::class);
    }

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }
}
