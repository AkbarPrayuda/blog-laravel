<?php

namespace Tests\Feature;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceProviderTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testUserServiceProvider()
    {
        $userService = $this->app->make(UserService::class);

        $this->assertInstanceOf(UserService::class, $userService);
    }
}
