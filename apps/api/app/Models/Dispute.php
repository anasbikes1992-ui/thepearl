<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'booking_id',
        'escrow_transaction_id',
        'opened_by_user_id',
        'status',
        'reason',
        'resolution',
    ];

    protected $casts = [
        'resolution' => 'array',
    ];
}
