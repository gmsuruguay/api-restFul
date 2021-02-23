<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
            'name'      => 'User Admin',
            'email'     => 'tinchohlj@gmail.com',
            'password'     => bcrypt('123456'),

        ]);

        App\User::create([
            'name'      => 'User Invitado',
            'email'     => 'email@email.com',
            'password'     => bcrypt('123456'),

        ]);
    }
}
