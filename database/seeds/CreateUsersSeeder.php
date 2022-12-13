<?php

use Illuminate\Database\Seeder;
use App\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
               'name'=>'Admin',
               'email'=>'admin@admin.com',
                'type'=>'1',
               'password'=> bcrypt('123456'),
            ],
            [
               'name'=>'User',
               'email'=>'user@user.com',
                'type'=>'0',
               'password'=> bcrypt('123456'),
            ],
        ];
        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
