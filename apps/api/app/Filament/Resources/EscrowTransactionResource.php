<?php

namespace App\Filament\Resources;

use App\Models\EscrowTransaction;
use Filament\Resources\Resource;

class EscrowTransactionResource extends Resource
{
    protected static ?string $model = EscrowTransaction::class;

    protected static ?string $navigationGroup = 'Finance';

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
}
