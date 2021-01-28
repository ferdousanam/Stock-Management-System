<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['code' => 'Shop1', 'name' => 'Gulshan'],
            ['code' => 'Shop2', 'name' => 'Banani'],
            ['code' => 'Shop3', 'name' => 'Dhanmondi'],
            ['code' => 'Shop4', 'name' => 'Uttara'],
            ['code' => 'Shop5', 'name' => 'Bashundhara City Shopping Complex'],
        ];
        foreach ($data as $row) {
            Warehouse::create($row);
        }
    }
}
