<?php

namespace App\Models\Social;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialFollow extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'follower_user_id',
        'following_user_id',
    ];
}
