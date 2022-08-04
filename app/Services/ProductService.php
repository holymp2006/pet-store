<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Collection;

final class ProductService
{
    public function getAll(): Collection
    {
        return Product::all();
    }
    /**
     * @param array<string, string> $data
     */
    public function create(array $data): Product
    {
        return Product::create(
            Arr::only(
                $data,
                $this->getFillable()
            )
        );
    }
    /**
     * @param Product $product
     * @param array<string, string> $data
     */
    public function update(Product $product, array $data): Product
    {
        $product->update(
            Arr::only(
                $data,
                $this->getFillable()
            )
        );
        return $product;
    }
    public function getByUuid(string $uuid): Product
    {
        return Product::where('uuid', $uuid)->firstOrFail();
    }
    protected function getFillable(): array
    {
        return (new Product())->getFillable();
    }
}
