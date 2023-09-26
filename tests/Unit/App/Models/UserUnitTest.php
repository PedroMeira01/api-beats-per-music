<?php

namespace Tests\Unit\App\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserUnitTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
