<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperUSSDRequests
 */
class USSDRequests extends Model
{
    use HasFactory;

    protected $table = 'ussd_requests';

    protected $primaryKey = 'id';

    protected $fillable = ['id', 'session_id', 'user_id', 'msisdn', 'ussd_body', 'menu_level', 'session_data'];

    protected $casts = [
        'session_data' => 'array',
    ];
}
