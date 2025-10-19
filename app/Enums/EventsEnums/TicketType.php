<?php

namespace App\Enums\EventsEnums;

enum TicketType: string
{
    case SVIP = 'super_vip';
    case VIP = 'vip';
    case PLATINUM = 'platinum';
    case GOLD = 'gold';
    case SILVER = 'silver';
    case BRONZE = 'bronze';
    case GENERAL = 'general_admission';
}
