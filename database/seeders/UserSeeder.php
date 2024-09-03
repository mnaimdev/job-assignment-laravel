<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = array(
            array(
                "id" => 6,
                "name" => "Mohammad Naim",
                "email" => "mnaimdev@gmail.com",
                "email_verified_at" => NULL,
                "password" => Hash::make('Nadeveloper12*34s'),
                "remember_token" => NULL,
                "created_at" => "2024-08-31 21:02:27",
                "updated_at" => "2024-08-31 21:02:27",
            ),
            array(
                "id" => 9,
                "name" => "Java User",
                "email" => "java@gmail.com",
                "email_verified_at" => NULL,
                "password" => Hash::make('Java1234*34s'),
                "remember_token" => NULL,
                "created_at" => "2024-09-02 19:24:34",
                "updated_at" => "2024-09-02 19:24:34",
            ),
            array(
                "id" => 11,
                "name" => "Mir Faisal",
                "email" => "mirfaisal08@gmail.com",
                "email_verified_at" => NULL,
                "password" => 'Faisal1234*#',
                "remember_token" => NULL,
                "created_at" => "2024-09-02 20:31:18",
                "updated_at" => "2024-09-02 20:31:18",
            ),
        );
    }
}
