<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Arr;
use App\Casts\ProductMetadataCast;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function getByUuid(string $uuid): Category
    {
        return Category::where('uuid', $uuid)->firstOrFail();
    }
}
