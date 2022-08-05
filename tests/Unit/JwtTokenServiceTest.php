<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\JwtTokenService;

class JwtTokenServiceTest extends TestCase
{
    /** @test
     *  @group auth
     */
    public function it_generates_token()
    {
        $token = (new JwtTokenService())->generateJwtToken();
        dd($token);

        $this->assertIsString($token);
    }
}
