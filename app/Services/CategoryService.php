<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Category;

final class CategoryService
{
    public function getByUuid(string $uuid): Category
    {
        return Category::where('uuid', $uuid)->firstOrFail();
    }
}
