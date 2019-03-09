<?php

namespace Tests\Feature;

use App\Models\Service;
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


    public function testUpdateServiceWithoutToken()
    {
        //
        $service = Service::inRandomOrder()->firstOrFail();

        //New data
        $new = factory(\App\Models\Service::class)->create();

        $response = $this->put('api/services/' . $service->id , $new->toArray(),  [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '
        ]);

        $response->assertStatus(401)
            ->assertJsonStructure(['message']);

    }


    public function testUpdateServiceWithToken()
    {
        //
        $service = Service::inRandomOrder()->firstOrFail();

        //New data
        $new = factory(\App\Models\Service::class)->create();

        $user = User::inRandomOrder()->first();
        $response = $this->put('api/services/' . $service->id , $new->toArray(),  [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $user->api_token
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data'
            ]);

        //Exists in database
        $test = [
            'id' => $service->id,
            'title' => $new->title,
            'lat' => $new->lat,
            'long' => $new->long
        ];

        $this->assertDatabaseHas('services', $test);

    }

    public function testDeleteServiceWithoutToken()
    {
        $service = Service::inRandomOrder()->firstOrFail();

        $response = $this->delete('api/services/' . $service->id , [],  [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '
        ]);

        $response->assertStatus(401)
            ->assertJsonStructure(['message']);
    }

    public function testDeleteServiceWithToken()
    {
        $service = Service::inRandomOrder()->firstOrFail();

        $user = User::inRandomOrder()->first();
        $response = $this->delete('api/services/' . $service->id , [],  [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $user->api_token
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data'
            ]);

        //Dont Exists in database
        $this->assertDatabaseMissing('services', ['id' => $service->id]);

    }


}
