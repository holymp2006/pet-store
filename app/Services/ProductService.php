<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Arr;
use App\Casts\ProductMetadataCast;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    public function getAll(): Collection
    {
        return Product::all();
    }
    /**
     * @param array<string> $data
     * @return Product
     */
    public function create(array $data): Product
    {
        $category = (new CategoryService())->getByUuid($data['category_uuid']);
        return $category->products()->create(
            Arr::only(
                $data,
                [
                    'title',
                    'price',
                    'description',
                    'metadata',
                ]
            )
        );
    }
    public function getByUuid(string $uuid): Product
    {
        return Product::where('uuid', $uuid)->firstOrFail();
    }
}
