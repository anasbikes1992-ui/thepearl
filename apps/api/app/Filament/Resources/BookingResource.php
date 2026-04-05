<?php

namespace App\Filament\Resources;

use App\Models\Booking\Booking;
use Filament\Resources\Resource;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationGroup = 'Marketplace';

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
}
