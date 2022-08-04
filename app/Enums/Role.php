<?php

declare(strict_types=1);

namespace App\Enums;

enum Role: int
{
    case DEFAULT = 0;
    case ADMIN = 1;
}
