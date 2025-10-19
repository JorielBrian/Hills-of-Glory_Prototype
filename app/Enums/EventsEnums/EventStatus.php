<?php

namespace App\Enums\EventsEnums;

enum EventStatus: string
{
    case SCHEDULED = 'scheduled';
    case ONGOING = 'ongoing';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case POSTPONED = 'postponed';
}
