<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductController extends Controller
{
    public function __construct(
        private ProductResource $productResource,
        private ProductService $productService
    ) {
    }

    public function index(): JsonResource
    {
        return $this->productResource->collection($this->productService->getAll());
    }

    public function store(StoreProductRequest $request): JsonResource
    {
        $product = $this->productService->create($request->validated());
        return $this->productResource->make($product);
    }

    public function show(Product $product)
    {
        //
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    public function destroy(Product $product)
    {
        //
    }
}
