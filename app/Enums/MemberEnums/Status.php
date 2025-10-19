<?php

namespace App\Enums\MemberEnums;

enum Status: string
{
    case STUDENT = 'Student';
    case YOUNG_PROFESSIONAL = 'Young Professional';
    case PROFESSIONAL = 'Professional';
}
