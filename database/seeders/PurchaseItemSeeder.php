<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchaseItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\PurchaseItem::factory(500)->create();

        DB::statement("UPDATE purchases SET purchases.net_total = IFNULL((SELECT SUM(purchase_items.net_cost) FROM purchase_items WHERE purchase_items.purchase_id = purchases.id GROUP BY purchase_id), 0)");
    }
}
