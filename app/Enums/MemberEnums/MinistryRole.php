<?php

namespace App\Enums\MemberEnums;

enum MinistryRole: string
{
    //People who can post or view their ministry announcments or postings
    case DIRECTOR = 'Director';
    case LEADER = 'Leader';
    case ADMIN = 'Admin';

        // Members only
    case MEMBER = 'Member';
    case TRAINEE = 'Trainee';
}
