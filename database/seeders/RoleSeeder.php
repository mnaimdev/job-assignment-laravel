<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = array(
            array(
                "id" => 3,
                "name" => "Manager",
                "guard_name" => "web",
                "created_at" => "2024-08-30 13:01:30",
                "updated_at" => "2024-08-30 13:01:30",
            ),
            array(
                "id" => 4,
                "name" => "Admin",
                "guard_name" => "web",
                "created_at" => "2024-09-01 19:05:56",
                "updated_at" => "2024-09-02 09:49:08",
            ),
            array(
                "id" => 5,
                "name" => "User",
                "guard_name" => "web",
                "created_at" => "2024-09-02 18:52:51",
                "updated_at" => "2024-09-02 18:52:51",
            ),
        );

        Role::insert($roles);
    }
}
