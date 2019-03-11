<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class AuthTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

   public function testAuthWrong()
   {
       $user = User::inRandomOrder()->first();

       $data = [
           'email' => $user->email,
           'password' => 'wrongpassword'
       ];

       $response = $this->post('api/login', $data, [
           'Accept' => 'application/json',
       ]);

       $response->assertStatus(Response::HTTP_UNAUTHORIZED)
           ->assertJsonStructure([
               'message',
           ]);
   }

    public function testAuthOk()
    {
        $user = User::inRandomOrder()->first();

        //set a password for matching
        $user->password = Hash::make('mypass');
        $user->save();

        $data = [
            'email' => $user->email,
            'password' => 'mypass'
        ];

        $response = $this->post('api/login', $data, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'user_id',
                'api_token',
            ]);
    }
}
