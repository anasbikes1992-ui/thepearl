<?php

namespace App\Models;

use App\Models\Booking\Booking;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use HasUuids;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'locale',
        'kyc_status',
        'district',
        'city',
        'pearl_points',
        'referral_code',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles, true);
    }

    public function providerProfile(): HasOne
    {
        return $this->hasOne(ProviderProfile::class);
    }

    public function receivedReviews(): HasMany
    {
        return $this->hasMany(Review::class, 'provider_user_id');
    }

    public function writtenReviews(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewer_user_id');
    }

    public function customerBookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'customer_id');
    }

    public function providerBookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'provider_id');
    }
}
