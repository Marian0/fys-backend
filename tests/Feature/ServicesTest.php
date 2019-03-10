<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Grimzy\LaravelMysqlSpatial\Types\Point;
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
                        'created_at',
                        'updated_at',
                        'location'
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

        $data = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->text,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip_code' => $this->faker->postcode,
            'location' => [
                'lat' => $this->faker->latitude,
                'lng' => $this->faker->latitude
            ]
        ];

        $response = $this->post('api/services', $data, [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $user->api_token
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data'
            ]);

        //Exists in database
        $service = Service::where([
            'id' => $response->json('data.id'),
            'title' => $data['title'],
            'city' => $data['city'],
            'address' => $data['address'],
        ])->first();

        $this->assertTrue($service instanceof Service);
        $this->assertTrue($service->location instanceof Point);
        $this->assertTrue($service->location->getLat() === $data['location']['lat']);
        $this->assertTrue($service->location->getLng() === $data['location']['lng']);
    }


    public function testNewServiceErrorWithToken()
    {

        $user = User::inRandomOrder()->first();

        //Some errors in data
        $data = [
            'title' => $this->faker->sentence,
            'zip_code' => $this->faker->postcode,
            'location' => [
                'lat' => '123a', //wrong lat
                //missing long
            ]
        ];

        $response = $this->post('api/services', $data, [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $user->api_token
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors'
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


        $data = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->text,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip_code' => $this->faker->postcode,
            'location' => [
                'lat' => $this->faker->latitude,
                'lng' => $this->faker->latitude
            ]
        ];


        $user = User::inRandomOrder()->first();
        $response = $this->put('api/services/' . $service->id , $data,  [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $user->api_token
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data'
            ]);

        //Exists in database
        $service = Service::where([
            'id' => $response->json('data.id'),
            'title' => $data['title'],
            'city' => $data['city'],
            'address' => $data['address'],
        ])->first();

        $this->assertTrue($service instanceof Service);
        $this->assertTrue($service->location instanceof Point);
        $this->assertTrue($service->location->getLat() === $data['location']['lat']);
        $this->assertTrue($service->location->getLng() === $data['location']['lng']);

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
