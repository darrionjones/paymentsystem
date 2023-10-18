<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Merchant extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'address',
        'region',
        'digital_address',
        'business_email',
        'contact_person_name',
        'contact_person_email',
        'contact_person_phone',
        'client_id',
        'client_secret',
        'is_live',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);

    }

    public function banks(): BelongsToMany
    {
        return $this->belongsToMany(Bank::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
