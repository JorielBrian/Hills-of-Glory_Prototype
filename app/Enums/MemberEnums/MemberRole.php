<?php

namespace App\Enums\MemberEnums;

enum MemberRole: string
{
    case HEAD_PASTOR = 'Head Pastor';
    case PASTOR = 'Pastor';
    case CORE_LEADER = 'Core Leader';
    case LIFE_GUIDE = 'Life Guide';
    case MEMBER = 'Member';
    case FIRST_TIMER = 'First Timer';
}
