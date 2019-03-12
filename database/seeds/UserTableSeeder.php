<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\User::class, 10)->create();

        \App\Models\User::create([
            'name' => 'Mariano Peyregne',
            'email' => 'marianosantafe@gmail.com',
            'api_token' => \Illuminate\Support\Str::random(16),
            'password' => \Illuminate\Support\Facades\Hash::make('password')
        ]);

        \App\Models\User::create([
            'name' => 'Admin Sample',
            'email' => 'admine@fys.com',
            'api_token' => \Illuminate\Support\Str::random(16),
            'password' => \Illuminate\Support\Facades\Hash::make('password')
        ]);
    }
}
