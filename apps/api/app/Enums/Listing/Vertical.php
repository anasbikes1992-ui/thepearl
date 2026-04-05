<?php

namespace App\Enums\Listing;

enum Vertical: string
{
    case Property = 'property';
    case Stays = 'stays';
    case Vehicles = 'vehicles';
    case Events = 'events';
    case SmeServices = 'sme_services';
    case Tours = 'tours';
    case HomeBeauty = 'home_beauty';
}
