<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaracraftTech\LaravelDateScopes\DateScopes;

class Transaction extends Model
{
    use DateScopes, HasFactory;

    protected $fillable = [
        'merchant_id',
        'description',
        'reference_id',
        'merchant_reference',
        'channel',
        'amount',
        'status',
        'status_code',
        'currency',
        'callback_url',
        'return_url',
        'cancel_url',
        'meta_data',
    ];

    protected $casts = [
        'meta_data' => 'array',
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function payout()
    {
        return $this->belongsTo(Payout::class);
    }

    public function scopeFilter($query)
    {
        if (request('search')) {
            $query->where('customer_name', 'like', '%'.request('search').'%')
                ->orWhere('customer_email', 'like', '%'.request('search').'%')
                ->orWhere('customer_phone_number', 'like', '%'.request('search').'%')
                ->paginate(15);
        }
    }
}
