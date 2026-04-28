<?php

namespace App\Enums;

enum ReservationStatus: string
{
    case Pending = 'PENDING';
    case Confirmed = 'CONFIRMED';
    case Canceled = 'CANCELED';
}
