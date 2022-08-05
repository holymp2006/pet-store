<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Services\JwtTokenService;

class JwtTokenServiceTest extends TestCase
{
    /** @test
     *  @group auth
     */
    public function it_generates_token_for_user()
    {
        $user = User::factory()->create();
        $token = (new JwtTokenService())->createTokenForUser($user);

        $this->assertIsString($token);
    }
}
