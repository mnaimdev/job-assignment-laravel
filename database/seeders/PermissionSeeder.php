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
        $data = [
            [
                'name' => 'create_user'
            ],
            [
                'name' => 'delete_user'
            ],
            [
                'name' => 'update_user'
            ],
            [
                'name' => 'edit_user'
            ],
            [
                'name' => 'user_list'
            ],
        ];

        Permission::create($data);
    }
}
