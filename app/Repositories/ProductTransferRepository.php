<?php


namespace App\Repositories;


use App\Models\Product;
use App\Models\PurchaseItem;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductTransferRepository
{
    public function store(Request $request)
    {
        $itemsFromDB = Product::whereIn('id', $request->product_id)->get();

        $purchaseItems = [];
        $net_total = 0;
        $net_discount = 0;
        foreach ($request->transfer_items as $item) {
            $dbItem = $itemsFromDB->where('id', $item['product_id'])->first();
            $net_cost = $dbItem->price * $item['quantity'];
            $purchaseItems[] = new PurchaseItem([
                'product_id' => $item['product_id'],
                'unit_cost' => $dbItem->price,
                'net_cost' => $net_cost,
                'quantity' => $item['quantity'],
                'warehouse_id' => $request->to_warehouse_id,
                'expiry_date' => formatDateDBFull($item['expiry_date']),
                'status' => $request->status,
            ]);
            $net_total += $net_cost;
        }

        $input = $request->all();
        DB::transaction(function () use ($input, $net_total, $net_discount, $purchaseItems) {
            $purchase = Transfer::create([
                'date' => formatDateDBFull($input['date']),
                'net_total' => $net_total,
                'from_warehouse_id' => $input['from_warehouse_id'],
                'to_warehouse_id' => $input['to_warehouse_id'],
                'status' => $input['status'],
            ]);
            $purchase->transferItems()->saveMany($purchaseItems);
        });
    }

    public function update(Request $request, $id)
    {
        $itemsFromDB = Product::whereIn('id', $request->product_id)->get();

        DB::transaction(function () use ($request, $itemsFromDB, $id) {
            $net_total = 0;
            $net_discount = 0;
            foreach ($request->transfer_items as $item) {
                $dbItem = $itemsFromDB->where('id', $item['product_id'])->first();
                $net_cost = $dbItem->price * $item['quantity'];
                $transferItem = [
                    'product_id' => $item['product_id'],
                    'unit_cost' => $dbItem->price,
                    'net_cost' => $net_cost,
                    'quantity' => $item['quantity'],
                    'warehouse_id' => $request->to_warehouse_id,
                    'expiry_date' => formatDateDBFull($item['expiry_date']),
                    'status' => $request->status,
                ];
                $net_total += $net_cost;
                PurchaseItem::updateOrCreate([
                    'purchasable_id' => $id,
                    'purchasable_type' => Transfer::class,
                    'product_id' => $transferItem['product_id'],
                ], $transferItem);
            }
            PurchaseItem::where(['purchasable_id' => $id, 'purchasable_type' => Transfer::class])
                ->whereNotIn('product_id', $request->product_id)->delete();

            $input = $request->all();
            $updateData = [
                'date' => formatDateDBFull($input['date']),
                'net_total' => $net_total,
                'from_warehouse_id' => $input['from_warehouse_id'],
                'to_warehouse_id' => $input['to_warehouse_id'],
                'status' => $input['status'],
            ];

            $transfer = Transfer::findOrFail($id);
            $transfer->update($updateData);
        });
    }
}
