<?php

namespace App\Enums\EventsEnums;

enum AttendanceStatus: string
{
    case PRESENT = 'present';
    case ABSENT = 'absent';
    case LATE = 'late';
    case EXCUSED = 'excused';
    case LEFT_EARLY = 'left_early';
}
