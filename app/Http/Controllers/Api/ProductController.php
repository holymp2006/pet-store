<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
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
    /**
     * @OA\Post(
     *     path="/users",
     *     summary="Adds a new user - with oneOf examples",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="id",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     oneOf={
     *                     	   @OA\Schema(type="string"),
     *                     	   @OA\Schema(type="integer"),
     *                     }
     *                 ),
     *                 example={"id": "a3fb6", "name": "Jessica Smith", "phone": 12345678}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             oneOf={
     *                 @OA\Schema(ref="#/components/schemas/Result"),
     *                 @OA\Schema(type="boolean")
     *             },
     *             @OA\Examples(example="result", value={"success": true}, summary="An result object."),
     *             @OA\Examples(example="bool", value=false, summary="A boolean value."),
     *         )
     *     )
     * )
     */
    public function store(StoreProductRequest $request): JsonResource
    {
        $product = $this->productService->create($request->validated());
        return $this->productResource->make($product);
    }

    public function show(string $uuid): JsonResource
    {
        $product = $this->productService->getByUuid($uuid);
        return $this->productResource->make($product);
    }
    /**
     * @OA\Put(
     *     path="/orders/{uuid}",
     *     summary="Updates a product",
     *     @OA\Parameter(
     *         description="Parameter with multiple examples",
     *         in="path",
     *         name="uuid",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="uuid", value="0006faf6-7a61-426c-9034-579f2cfcfa83", summary="A UUID value."),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function update(UpdateProductRequest $request, string $uuid): JsonResource
    {
        $product = $this->productService->getByUuid($uuid);
        $this->productService->update($product, $request->validated());

        return $this->productResource->make($product);
    }
}
