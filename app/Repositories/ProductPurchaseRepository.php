<?php


namespace App\Repositories;


use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductPurchaseRepository
{
    public function store(Request $request)
    {
        $itemsFromDB = Product::whereIn('id', $request->product_id)->get();

        $purchaseItems = [];
        $net_total = 0;
        $net_discount = 0;
        foreach ($request->purchase_items as $item) {
            $dbItem = $itemsFromDB->where('id', $item['product_id'])->first();
            $net_cost = $dbItem->price * $item['quantity'];
            $purchaseItems[] = new PurchaseItem([
                'product_id' => $item['product_id'],
                'unit_cost' => $dbItem->price,
                'net_cost' => $net_cost,
                'quantity' => $item['quantity'],
                'warehouse_id' => $request->warehouse_id,
                'expiry_date' => formatDateDBFull($item['expiry_date']),
                'status' => $request->payment_status,
            ]);
            $net_total += $net_cost;
        }

        $input = $request->all();
        DB::transaction(function () use ($input, $net_total, $net_discount, $purchaseItems) {
            $purchase = Purchase::create([
                'date' => formatDateDBFull($input['date']),
                'due_date' => formatDateDBFull($input['due_date']),
                'net_total' => $net_total,
                'net_discount' => $net_discount,
                'warehouse_id' => $input['warehouse_id'],
                'payment_status' => $input['payment_status'],
            ]);
            $purchase->purchaseItems()->saveMany($purchaseItems);
        });
    }

    public function update(Request $request, $id)
    {
        $itemsFromDB = Product::whereIn('id', $request->product_id)->get();

        DB::transaction(function () use ($request, $itemsFromDB, $id) {
            $net_total = 0;
            $net_discount = 0;
            foreach ($request->purchase_items as $item) {
                $dbItem = $itemsFromDB->where('id', $item['product_id'])->first();
                $net_cost = $dbItem->price * $item['quantity'];
                $purchaseItem = [
                    'product_id' => $item['product_id'],
                    'unit_cost' => $dbItem->price,
                    'net_cost' => $net_cost,
                    'quantity' => $item['quantity'],
                    'warehouse_id' => $request->warehouse_id,
                    'expiry_date' => formatDateDBFull($item['expiry_date']),
                    'status' => $request->payment_status,
                ];
                $net_total += $net_cost;
                PurchaseItem::updateOrCreate([
                    'purchase_id' => $id,
                    'product_id' => $purchaseItem['product_id'],
                ], $purchaseItem);
            }
            PurchaseItem::whereNotIn('product_id', $request->product_id)->delete();

            $input = $request->all();
            $updateData = [
                'date' => formatDateDBFull($input['date']),
                'due_date' => formatDateDBFull($input['due_date']),
                'net_total' => $net_total,
                'net_discount' => $net_discount,
                'warehouse_id' => $input['warehouse_id'],
                'payment_status' => $input['payment_status'],
            ];

            $purchase = Purchase::findOrFail($id);
            $purchase->update($updateData);
        });
    }
}
