<?php

namespace App\Enums;

enum UserStatus: string
{
    case ARCHIVED = 'archived';
    case ACTIVE = 'active';
}
