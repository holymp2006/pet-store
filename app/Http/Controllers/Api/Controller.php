<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *    title="Pet Store API",
 *    version="1.0.0",
 * )
 * @OA\PathItem(path="/api/v1")
 * 
 * @OA\Tag(
 *     name="User",
 *     description="User API endpoint"
 *  )
 * @OA\Tag(
 *     name="Admin",
 *     description="Admin API endpoint"
 * )
 *
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        auth()->setDefaultDriver('api');
    }
}
