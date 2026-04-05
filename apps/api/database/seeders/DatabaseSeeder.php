<?php

namespace Database\Seeders;

use App\Models\ProviderProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->create([
            'id' => (string) Str::uuid(),
            'name' => 'Pearl Super Admin',
            'email' => 'admin@pearlhub.lk',
            'password' => bcrypt('ChangeMe123!'),
            'role' => 'super-admin',
            'kyc_status' => 'verified',
            'referral_code' => 'PEARLADMIN',
        ]);

        $provider = User::query()->create([
            'id' => (string) Str::uuid(),
            'name' => 'Colombo Luxe Stays',
            'email' => 'provider@pearlhub.lk',
            'password' => bcrypt('ChangeMe123!'),
            'role' => 'provider',
            'kyc_status' => 'verified',
            'district' => 'Colombo',
            'city' => 'Colombo',
            'referral_code' => 'LUXEHOST',
        ]);

        ProviderProfile::query()->create([
            'user_id' => $provider->id,
            'business_name' => 'Colombo Luxe Stays',
            'verticals' => ['stays', 'tours'],
            'bio' => 'Premium urban stays and curated travel experiences.',
            'phone' => '+94770000000',
            'supports_livestream' => true,
            'supports_resale' => false,
            'is_verified' => true,
            'sustainability_score' => 72.50,
        ]);
    }
}
