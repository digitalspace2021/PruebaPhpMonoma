<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseMigrations;


    /** @test */
    public function user_can_login()
    {
        $this->withoutExceptionHandling();
        factory(User::class)->create([
            'username' => 'user',
            'password' => bcrypt('password')
        ]);

        $response = $this->post('/api/login', [
            'username' => 'user',
            'password' => 'password'
        ]);
        $this->assertAuthenticatedAs(User::first());
        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_logout()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create([
            'username' => 'user',
            'password' => bcrypt('password')
        ]);

        $this->assertGuest();

        $this->post('/api/login', [
            'username' => 'user',
            'password' => 'password'
        ]);

        $response = $this->post('/api/logout');

        $response->assertStatus(200);
    }
}
