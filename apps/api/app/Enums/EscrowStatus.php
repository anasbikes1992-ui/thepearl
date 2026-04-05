<?php

namespace App\Enums;

enum EscrowStatus: string
{
    case Held = 'held';
    case InDispute = 'in_dispute';
    case Released = 'released';
    case Refunded = 'refunded';
}
