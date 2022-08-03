<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
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
        return Product::create($data);
    }
    public function getByUuid(string $uuid): Product
    {
        return Product::where('uuid', $uuid)->firstOrFail();
    }
}
