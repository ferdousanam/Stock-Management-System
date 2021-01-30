<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Warehouse;
use App\Repositories\ProductPurchaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class PurchaseController extends Controller
{
    /**
     * @var ProductPurchaseRepository
     */
    private $productPurchaseRepository;

    public function __construct(ProductPurchaseRepository $productPurchaseRepository) {
        $this->productPurchaseRepository = $productPurchaseRepository;

        $warehouses = Warehouse::all();
        View::share('warehouses', $warehouses);
    }

    private function validateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'due_date' => 'required',
            'warehouse_id' => 'required',
            'payment_status' => 'required',
            'product_id' => 'required',
            'purchase_items' => 'required',
        ]);
        $validator->validate();
    }

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
        $this->validateRequest($request);
        $this->productPurchaseRepository->store($request);

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
        $purchaseItems = PurchaseItem::where(['purchasable_id' => $id, 'purchasable_type' => Purchase::class])
            ->select('products.*')
            ->addSelect('purchase_items.*')
            ->addSelect('purchase_items.id as purchase_item_id')
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
        $this->validateRequest($request);
        $this->productPurchaseRepository->update($request, $id);

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
