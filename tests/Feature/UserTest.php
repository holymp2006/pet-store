<?php

namespace Tests\Feature;

use App\Enums\Role;
use App\Models\User;
use App\Services\JwtTokenService;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test
     *  @group auth
     */
    public function user_can_login()
    {
        $password = 'password';
        $user = User::factory(
            ['password' => $password]
        )->create();
        $response = $this->postJson('api/v1/user/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'token',
        ]);
    }
    /** @test
     *  @group auth
     */
    public function only_admin_can_view_all_users()
    {
        $admin = User::factory()->create(['is_admin' => Role::ADMIN]);
        $token = (new JwtTokenService)->createTokenForUser($admin);
        $response = $this->withToken($token)
            ->getJson('api/v1/admin/user-listing');
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'email',
                    'first_name',
                ],
            ],
        ]);
    }
    /** @test
     *  @group auth
     */
    public function basic_user_cant_view_all_users()
    {
        $user = User::factory()->create();
        $token = (new JwtTokenService)->createTokenForUser($user);
        $response = $this->withToken($token)
            ->getJson('api/v1/admin/user-listing');
        $response->assertUnauthorized();
    }
}
