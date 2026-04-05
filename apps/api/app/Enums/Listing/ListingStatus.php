<?php

namespace App\Enums\Listing;

enum ListingStatus: string
{
    case Draft = 'draft';
    case Pending = 'pending';
    case Published = 'published';
    case Rejected = 'rejected';
}
