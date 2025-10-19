<?php

namespace App\Enums\EventsEnums;

enum EventType: string
{
    // REGULAR SERVICES
    case SUNDAY_SERVICE = 'sunday_service';
    case PROTEGE = 'protege';
    case PRAYER_ENCOUNTER = 'prayer_meeting';

        // ONCE A MONTH SERVICES
    case PROTEGE_GIG = 'protege_gig';
    case SOAKING = 'soaking';

        // MAIN CHURCH SERVICES
    case PRAYER_FASTING = 'prayer_and_fasting';
    case LIFE_GUIDE_SUMMIT = 'life_guide_summit';

        // HILLS JOURNEY
    case LIFE_GROUP = 'life_group';
    case START_UP = 'start_up';
    case NEW_LIFE_RETREAT = 'new_life_retreat';

        // SPECIAL EVENTS
    case SIMBANG_GABI = 'simbang_gabi';
    case CONCERT = 'concert';
    case ANNIVERSARY = 'anniversary';
    case CONFERENCE = 'conference';
    case BAPTISM = 'baptism';
}
