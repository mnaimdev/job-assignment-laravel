<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = array(
            array(
                "id" => 1,
                "name" => "create_user",
                "guard_name" => "web",
                "created_at" => "2024-08-30 13:12:00",
                "updated_at" => "2024-08-30 15:05:20",
            ),
            array(
                "id" => 2,
                "name" => "delete_user",
                "guard_name" => "web",
                "created_at" => "2024-08-30 15:05:32",
                "updated_at" => "2024-08-30 15:05:32",
            ),
            array(
                "id" => 4,
                "name" => "edit_user",
                "guard_name" => "web",
                "created_at" => "2024-08-30 15:19:42",
                "updated_at" => "2024-08-30 15:19:42",
            ),
            array(
                "id" => 6,
                "name" => "create_role",
                "guard_name" => "web",
                "created_at" => "2024-08-30 15:21:09",
                "updated_at" => "2024-08-30 15:21:09",
            ),
            array(
                "id" => 7,
                "name" => "edit_role",
                "guard_name" => "web",
                "created_at" => "2024-08-30 15:21:14",
                "updated_at" => "2024-08-30 15:21:14",
            ),
            array(
                "id" => 10,
                "name" => "assign_role",
                "guard_name" => "web",
                "created_at" => "2024-08-30 15:21:33",
                "updated_at" => "2024-08-30 15:21:33",
            ),
            array(
                "id" => 13,
                "name" => "create_permission",
                "guard_name" => "web",
                "created_at" => "2024-08-30 15:22:44",
                "updated_at" => "2024-08-30 15:22:44",
            ),
            array(
                "id" => 14,
                "name" => "edit_permission",
                "guard_name" => "web",
                "created_at" => "2024-08-30 15:22:50",
                "updated_at" => "2024-08-30 15:22:50",
            ),
            array(
                "id" => 18,
                "name" => "create_assign_role",
                "guard_name" => "web",
                "created_at" => "2024-08-30 15:26:00",
                "updated_at" => "2024-08-30 15:26:00",
            ),
            array(
                "id" => 20,
                "name" => "edit_assign_role",
                "guard_name" => "web",
                "created_at" => "2024-08-30 15:26:12",
                "updated_at" => "2024-09-02 21:55:16",
            ),
            array(
                "id" => 21,
                "name" => "delete_assign_role",
                "guard_name" => "web",
                "created_at" => "2024-08-30 15:26:28",
                "updated_at" => "2024-08-30 15:26:28",
            ),
            array(
                "id" => 22,
                "name" => "create_permission_under_role",
                "guard_name" => "web",
                "created_at" => "2024-08-30 15:33:56",
                "updated_at" => "2024-08-30 15:33:56",
            ),
            array(
                "id" => 23,
                "name" => "edit_permission_under_role",
                "guard_name" => "web",
                "created_at" => "2024-08-30 15:34:03",
                "updated_at" => "2024-08-30 15:34:03",
            ),
            array(
                "id" => 24,
                "name" => "delete_permission_under_role",
                "guard_name" => "web",
                "created_at" => "2024-08-30 15:34:12",
                "updated_at" => "2024-08-30 15:34:12",
            ),
            array(
                "id" => 27,
                "name" => "role_permission",
                "guard_name" => "web",
                "created_at" => "2024-09-02 21:18:34",
                "updated_at" => "2024-09-02 21:18:34",
            ),
            array(
                "id" => 28,
                "name" => "user_management",
                "guard_name" => "web",
                "created_at" => "2024-09-02 21:18:51",
                "updated_at" => "2024-09-02 21:18:51",
            ),
            array(
                "id" => 29,
                "name" => "user",
                "guard_name" => "web",
                "created_at" => "2024-09-02 21:19:14",
                "updated_at" => "2024-09-02 21:19:14",
            ),
            array(
                "id" => 30,
                "name" => "profile_info",
                "guard_name" => "web",
                "created_at" => "2024-09-02 21:19:20",
                "updated_at" => "2024-09-02 21:19:20",
            ),
            array(
                "id" => 31,
                "name" => "role",
                "guard_name" => "web",
                "created_at" => "2024-09-02 21:19:26",
                "updated_at" => "2024-09-02 21:19:26",
            ),
            array(
                "id" => 32,
                "name" => "permission",
                "guard_name" => "web",
                "created_at" => "2024-09-02 21:19:31",
                "updated_at" => "2024-09-02 21:19:31",
            ),
            array(
                "id" => 33,
                "name" => "permission_under_role",
                "guard_name" => "web",
                "created_at" => "2024-09-02 21:19:38",
                "updated_at" => "2024-09-02 21:19:38",
            ),
            array(
                "id" => 34,
                "name" => "delete_role",
                "guard_name" => "web",
                "created_at" => "2024-09-02 23:28:26",
                "updated_at" => "2024-09-02 23:28:26",
            ),
            array(
                "id" => 35,
                "name" => "delete_permission",
                "guard_name" => "web",
                "created_at" => "2024-09-02 23:28:33",
                "updated_at" => "2024-09-02 23:28:33",
            ),
        );

        Permission::insert($permissions);
    }
}
