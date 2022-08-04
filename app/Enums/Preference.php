<?php

declare(strict_types=1);

namespace App\Enums;

enum Preference: int
{
    case DEFAULT = 0;
    case MARKETING = 1;
}
