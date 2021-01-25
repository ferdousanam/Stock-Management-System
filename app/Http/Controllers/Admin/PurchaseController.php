<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $sql = Purchase::latest();

        $input = $request->all();
        if (!empty($input['q'])) {
            $sql->where('purchase_code', 'LIKE', '%' . $input['q'] . '%');
        }

        $perPage = 25;
        $records = $sql->paginate($perPage);
        $serial = $records->currentPage() * $records->perPage() - $records->perPage() + 1;

        return view('admin.purchases.index', compact('serial', 'records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $data = new Purchase();
        return view('admin.purchases.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'due_date' => 'required',
            'payment_status' => 'required',
            'product_id' => 'required',
        ]);
        $validator->validate();

        $itemsFromDB = Product::whereIn('id', $request->product_id)->get();

        $requestItems = [];
        foreach ($request->product_id as $key => $product_id) {
            $requestItems[$product_id] = [
                'product_id' => $product_id,
                'quantity' => $request->quantity[$key],
                'expiry_date' => $request->expiry_date[$key],
                'status' => $request->payment_status,
            ];
        }

        $purchaseItems = [];
        $net_total = 0;
        $net_discount = 0;
        foreach ($itemsFromDB as $item) {
            $net_cost = $item->price * $requestItems[$item->id]['quantity'];
            $purchaseItems[] = new PurchaseItem([
                'product_id' => $requestItems[$item->id]['product_id'],
                'unit_cost' => $item->price,
                'net_cost' => $net_cost,
                'quantity' => $requestItems[$item->id]['quantity'],
                'expiry_date' => formatDateDBFull($requestItems[$item->id]['expiry_date']),
                'status' => $requestItems[$item->id]['status'],
            ]);
            $net_total += $net_cost;
        }

        $input = $request->all();
        DB::transaction(function () use ($input, $net_total, $net_discount, $purchaseItems){
            $purchase = Purchase::create([
                'date' => formatDateDBFull($input['date']),
                'due_date' => formatDateDBFull($input['due_date']),
                'net_total' => $net_total,
                'net_discount' => $net_discount,
                'payment_status' => $input['payment_status'],
            ]);
            $purchase->purchaseItems()->saveMany($purchaseItems);
        });

        $request->session()->flash("message", "Purchase added successfully!");
        return redirect()->route('admin.purchases.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $data = Purchase::with('purchaseItems.product')->findOrFail($id);
        return view('admin.purchases.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id)
    {
        $data = Purchase::findOrFail($id);
        $purchaseItems = PurchaseItem::where('purchase_id', $id)
            ->select('products.*')
            ->addSelect('purchase_items.*')
            ->join('products', 'purchase_items.product_id', '=', 'products.id')
            ->get();
        return view('admin.purchases.edit', compact('data', 'purchaseItems'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'due_date' => 'required',
            'payment_status' => 'required',
            'product_id' => 'required',
        ]);
        $validator->validate();

        $input = $request->all();
        $updateData = [
            'title' => $input['title'],
        ];

        $data = Purchase::findOrFail($id);
        $data->update($updateData);

        $request->session()->flash("message", "Purchase updated successfully!");
        return redirect()->route('admin.purchases.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Purchase::destroy($id);
        session()->flash("message", "Purchase deleted successfully!");
        return redirect()->route('admin.purchases.index');
    }
}
