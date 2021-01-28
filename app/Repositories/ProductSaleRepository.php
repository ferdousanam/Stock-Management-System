<?php


namespace App\Repositories;


use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductSaleRepository
{
    public function store(Request $request)
    {
        $itemsFromDB = Product::whereIn('id', $request->product_id)->get();

        $saleItems = [];
        $net_total = 0;
        $net_discount = 0;
        foreach ($request->sale_items as $item) {
            $dbItem = $itemsFromDB->where('id', $item['product_id'])->first();
            $net_cost = $dbItem->price * $item['quantity'];
            $saleItems[] = new SaleItem([
                'product_id' => $item['product_id'],
                'unit_cost' => $dbItem->price,
                'net_cost' => $net_cost,
                'quantity' => $item['quantity'],
                'warehouse_id' => $request->warehouse_id,
                'status' => $request->payment_status,
            ]);
            $net_total += $net_cost;
        }

        $input = $request->all();
        DB::transaction(function () use ($input, $net_total, $net_discount, $saleItems) {
            $sale = Sale::create([
                'date' => formatDateDBFull($input['date']),
                'due_date' => formatDateDBFull($input['due_date']),
                'net_total' => $net_total,
                'net_discount' => $net_discount,
                'warehouse_id' => $input['warehouse_id'],
                'payment_status' => $input['payment_status'],
            ]);
            $sale->saleItems()->saveMany($saleItems);
        });
    }

    public function update(Request $request, $id)
    {
        $itemsFromDB = Product::whereIn('id', $request->product_id)->get();

        DB::transaction(function () use ($request, $itemsFromDB, $id) {
            $net_total = 0;
            $net_discount = 0;
            foreach ($request->sale_items as $item) {
                $dbItem = $itemsFromDB->where('id', $item['product_id'])->first();
                $net_cost = $dbItem->price * $item['quantity'];
                $saleItem = [
                    'product_id' => $item['product_id'],
                    'unit_cost' => $dbItem->price,
                    'net_cost' => $net_cost,
                    'quantity' => $item['quantity'],
                    'warehouse_id' => $request->warehouse_id,
                    'status' => $request->payment_status,
                ];
                $net_total += $net_cost;
                SaleItem::updateOrCreate([
                    'sale_id' => $id,
                    'product_id' => $saleItem['product_id'],
                ], $saleItem);
            }
            SaleItem::whereNotIn('product_id', $request->product_id)->delete();

            $input = $request->all();
            $updateData = [
                'date' => formatDateDBFull($input['date']),
                'due_date' => formatDateDBFull($input['due_date']),
                'net_total' => $net_total,
                'net_discount' => $net_discount,
                'warehouse_id' => $input['warehouse_id'],
                'payment_status' => $input['payment_status'],
            ];

            $sale = Sale::findOrFail($id);
            $sale->update($updateData);
        });
    }
}
