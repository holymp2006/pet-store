<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\AuthService;

class AuthServiceTest extends TestCase
{
    /** @test
     *  @group auth
     */
    public function it_generates_token()
    {
        $token = (new AuthService())->generateJwtToken();
        dd($token);

        $this->assertIsString($token);
    }
}
