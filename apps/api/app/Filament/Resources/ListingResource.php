<?php

namespace App\Filament\Resources;

use App\Models\Listing\Listing;
use Filament\Resources\Resource;

class ListingResource extends Resource
{
    protected static ?string $model = Listing::class;

    protected static ?string $navigationGroup = 'Marketplace';

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
}
