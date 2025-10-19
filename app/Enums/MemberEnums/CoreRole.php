<?php

namespace App\Enums\MemberEnums;

enum CoreRole: string
{
    case HEAD_PASTOR = 'Head Pastor';
    case PASTOR = 'Pastor';
    case CORE_LEADER = 'Core Leader';
    case LIFE_GUIDE = 'Life Guide';
}
