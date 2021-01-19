<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(10)->create();

        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);

        \App\Models\ProductCategory::factory(50)->create();
        \App\Models\ProductBrand::factory(50)->create();
        \App\Models\Product::factory(200)->create();
    }
}
