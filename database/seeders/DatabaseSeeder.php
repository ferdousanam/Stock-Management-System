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
        $this->call(ProductCategorySeeder::class);
        $this->call(ProductBrandSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(WarehouseSeeder::class);
        $this->call(PurchaseSeeder::class);
        $this->call(PurchaseItemSeeder::class);
    }
}
