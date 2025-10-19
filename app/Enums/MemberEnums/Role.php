<?php

namespace App\Enums\MemberEnums;

enum Role: string
{
    // CORE ROLES
    case HEAD_PASTOR = 'Head Pastor';
    case PASTOR = 'Pastor';
    case CORE_LEADER = 'Core Leader';

        // MEMBER ROLES
    case LIFE_GUIDE = 'Life Guide';
    case MEMBER = 'Member';
    case FIRST_TIMER = 'First Timer';
}
