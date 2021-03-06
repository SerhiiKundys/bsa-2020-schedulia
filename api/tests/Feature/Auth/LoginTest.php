<?php

namespace Tests\Feature\Auth;

use App\Entity\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_with_valid_data_return_token_structure()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make($password = '12345678'),
            'timezone' => 'Europe/Amsterdam'
        ]);

        $response = $this->json('POST', '/api/v1/auth/login', [
            'email' => $user->email,
            'password' => $password
        ]);

        $response->
            assertStatus(200)->
            assertJsonStructure(['data'=>['access_token', 'token_type', 'expires_in']]);

        $responseData =  json_decode($response->getContent(), true);

        $this->assertNotNull(
            $responseData['data']['access_token']
        );
    }

    public function test_login_with_invalid_email_return_error()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('123456789'),
            'timezone' => 'Europe/Amsterdam'
        ]);

        $wrongEmail = 'error@gmail.com';

        $response = $this->json('POST', '/api/v1/auth/login', [
            'email' => $wrongEmail,
            'password' => '123456789'
        ]);

        $response->assertStatus(404)
        ->assertJson(['error'=>['message' => 'No account exists for ' . $wrongEmail]]);
    }

    public function test_login_with_invalid_password_return_error()
    {
        $user = factory(User::class)->create([
                                                 'password' => Hash::make('123456789'),
                                                 'timezone' => 'Europe/Amsterdam'
                                             ]);

        $response = $this->json('POST', '/api/v1/auth/login', [
            'email' => $user->email,
            'password' => '12345678910'
        ]);

        $response->assertStatus(401)
            ->assertJson(['error'=>['message' => 'Invalid email or password']]);
    }

    public function test_token_expired()
    {
        $user = factory(User::class)->create([
            'timezone' => 'Europe/Amsterdam'
        ]);

        $token = \JWTAuth::customClaims(['exp' => time() + 1])->fromUser($user);
        sleep(1);

        $response = $this->json('GET', '/api/v1/auth/me', [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(401)
            ->assertJson(['error'=>['message' => 'Unauthenticated.']]);
    }
}
