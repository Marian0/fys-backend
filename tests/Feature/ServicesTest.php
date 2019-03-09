<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class ServicesTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    public function testGetServices()
    {
        $response = $this->get('api/services');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'title',
                        'description',
                        'lat',
                        'long'
                    ]
                ]
            ]);
    }


    public function testNewServiceWithoutToken()
    {

        $service = factory(\App\Models\Service::class)->create();
        $response = $this->post('api/services', $service->toArray(), ['Accept' => 'application/json']);

        $response->assertStatus(401)
            ->assertJsonStructure(['message']);

    }


    public function testNewServiceWithToken()
    {

        $user = User::inRandomOrder()->first();

        $service = factory(\App\Models\Service::class)->create();
        $response = $this->post('api/services', $service->toArray(), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $user->api_token
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data'
            ]);

        //Exists in database
        $this->assertDatabaseHas('services', [
            'id' => $response->json('data.id')
        ]);

    }
}
