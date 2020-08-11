<?php

namespace Tests\Feature\Profile;

use App\Entity\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateApiTest extends TestCase
{
    use RefreshDatabase;

    public function testUnauthenticated()
    {
        $user = factory(User::class)->create();

        $response = $this->json("PUT", "/api/v1/profiles/me", $user->attributesToArray());

        $response->assertStatus(401)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson(
                [
                    "error" => ["message" => 'Unauthenticated.']
                ]
            );
    }

    public function testInvalidDate()
    {
        $response = $this->json("PUT", "/api/v1/profiles/me", []);

        $response->assertStatus(422)
            ->assertHeader('Content-Type', 'application/json');
    }

    public function testCreateProfile()
    {
        $response = $this->json("POST", "/api/v1/profiles/me", []);

        $response->assertStatus(405);
    }

    public function testValidData()
    {
        $user = factory(User::class)->create();

        $dataToUpdate = [
            "name" => "John Doe",
            "language" => "de",
            "date_format" => "european_standard",
            "time_format_12h" => false,
            "timezone" => "America/Los_Angeles",
            "country" => "USA",
            "avatar" => null,
            "welcome_message" => 'New message'
        ];

        $response = $this->actingAs($user)->json("PUT", "/api/v1/profiles/me", $dataToUpdate);

        $response->assertStatus(200)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonFragment(
                $dataToUpdate
            );

        $this->assertDatabaseHas('users', array_merge($user->attributesToArray(), $dataToUpdate));
    }
}
