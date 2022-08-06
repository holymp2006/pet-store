<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\UserResource;
use App\Services\JwtTokenService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    public function __construct(
        private UserResource $userResource,
        private UserService $userService
    ) {
    }
    /**
     * @OA\Get(
     *     path="/api/v1/admin/user-listing",
     *     tags={"Admin"},
     *     summary="List all users",

     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function index(): JsonResource
    {
        return $this->userResource->collection($this->userService->getAll());
    }
    /**
     * @OA\Post(
     *     path="/api/v1/user/login",
     *     tags={"User"},
     *     summary="Login a User account",
     *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function login(UserLoginRequest $request): JsonResponse
    {
        if (!$this->userService->login(
            $request->validated()
        )) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }
        $user = auth()->user();

        return response()->json([
            'message' => 'Login successful',
            'token' => (new JwtTokenService())
                ->createTokenForUser($user),
        ]);
    }
}
