<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Organization;
use App\Models\Product;
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
        // Org #1
        $org1 = Organization::create(['name' => 'Org#1']);
        User::create([ 'organization_id' => $org1->id, 'first_name' => 'Admin', 'last_name' => 'Org#1', 'email' => 'admin@org1.com', 'password' => 'password', 'role' => 0]);

        $cat1 = Category::create(['organization_id' => $org1->id, 'title' => 'Category #1', 'description' => 'Category #1 desc']);
        Product::create(['organization_id' => $org1->id, 'title' => 'Prod #1', 'price' => 15,'category_id' => $cat1->id]);

        // Org #2
        $org2 = Organization::create(['name' => 'Org#2']);
        User::create([ 'organization_id' => $org2->id, 'first_name' => 'Admin', 'last_name' => 'Org#2', 'email' => 'admin@org2.com', 'password' => 'password', 'role' => 0]);

        $cat2 = Category::create(['organization_id' => $org2->id, 'title' => 'Category #2', 'description' => 'Category #2 desc']);
        Product::create(['organization_id' => $org2->id, 'title' => 'Prod #2', 'price' => 15,'category_id' => $cat2->id]);

    }
}
