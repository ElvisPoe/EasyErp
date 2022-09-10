<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'organization_id' => Organization::create(['name' => 'SomeName'])->id,
            'first_name' => 'Admin',
            'last_name' => 'EasyErp',
            'email' => 'admin@admin.com',
            'password' => 'password',
            'role' => 0,
        ]);
    }
}
