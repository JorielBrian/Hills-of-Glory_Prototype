<?php

namespace App\Enums\MemberEnums;

enum NetworkLeaders: string
{
    case ARVIE = 'Arvie';
    case DANIEL = 'Daniel';
    case DEMI = 'Demi';
    case DONNA = 'Donna';
    case DONALD = 'Donald';
    case EDDIESON = 'Eddieson';
    case FAE_ANNE = 'Fae Anne';
    case HARLEY = 'Harley';
    case HAZEL = 'Hazel';
    case JAYCEE = 'Jaycee';
    case JEZREAL = 'Jezreal';
    case JORIEL = 'Joriel';
    case KIER = 'Kier';
    case LEANNE = 'Leanne';
    case MICHAEL = 'Michael';
    case RAD = 'Rad';
    case GAB = 'Gab';
    case REY = 'Rey';
    case ROVI = 'Rovi';
    case WILSON = 'Wilson';
    case ZARRENCE = 'Zarrence';

    public function label(): string
    {
        return $this->value;
    }
}
