<?php

use App\Entity\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Role::create([
            'name' => 'User',
            'slug' => 'user',
            'permissions' => json_encode([
                'create-link' => true,
                'see-all-links' => false,
            ]),
        ]);
        $editor = Role::create([
            'name' => 'Editor',
            'slug' => 'editor',
            'permissions' => json_encode([
                'delete-link' => true,
                'update-link' => true,
                'create-link' => true,
                'show-private-link' => true,
                'list-private-links' => true,
            ]),
        ]);
        $admin = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'permissions' => json_encode([
                'delete-link' => true,
                'update-link' => true,
                'create-link' => true,
                'show-private-link' => true,
                'list-private-links' => true,
                'update-user' => true,
                'update-user-status-and-role' => true,
                'delete-user' => true,
            ]),
        ]);
    }
}