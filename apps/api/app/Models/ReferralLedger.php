<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralLedger extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'referrer_user_id',
        'referred_user_id',
        'trigger_transaction_id',
        'points_awarded_referrer',
        'points_awarded_referred',
        'status',
        'metadata',
    ];

    protected $casts = [
        'points_awarded_referrer' => 'integer',
        'points_awarded_referred' => 'integer',
        'metadata' => 'array',
    ];
}
