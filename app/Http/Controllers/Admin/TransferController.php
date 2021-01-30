<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseItem;
use App\Models\Transfer;
use App\Models\Warehouse;
use App\Repositories\ProductTransferRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class TransferController extends Controller
{
    /**
     * @var ProductTransferRepository
     */
    private $productTransferRepository;

    public function __construct(ProductTransferRepository $productTransferRepository) {
        $this->productTransferRepository = $productTransferRepository;

        $warehouses = Warehouse::all();
        View::share('warehouses', $warehouses);
    }

    private function validateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'from_warehouse_id' => 'required',
            'to_warehouse_id' => 'required',
            'product_id' => 'required',
            'transfer_items' => 'required',
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
        $sql = Transfer::with(['fromWarehouse', 'toWarehouse'])->orderByDesc('id');

        $input = $request->all();
        if (!empty($input['q'])) {
            $sql->where('transfer_code', 'LIKE', '%' . $input['q'] . '%');
        }

        $perPage = 25;
        $records = $sql->paginate($perPage);
        $serial = $records->currentPage() * $records->perPage() - $records->perPage() + 1;

        return view('admin.transfers.index', compact('serial', 'records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $data = new Transfer();
        return view('admin.transfers.create', compact('data'));
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
        $this->productTransferRepository->store($request);

        $request->session()->flash("message", "Transfer added successfully!");
        return redirect()->route('admin.transfers.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $data = Transfer::with(['fromWarehouse', 'toWarehouse', 'transferItems.product'])->findOrFail($id);
        return view('admin.transfers.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id)
    {
        $data = Transfer::findOrFail($id);
        $transferItems = PurchaseItem::where(['purchasable_id' => $id, 'purchasable_type' => Transfer::class])
            ->select('products.*')
            ->addSelect('purchase_items.*')
            ->addSelect('purchase_items.id as transfer_item_id')
            ->join('products', 'purchase_items.product_id', '=', 'products.id')
            ->get();
        return view('admin.transfers.edit', compact('data', 'transferItems'));
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
        $this->productTransferRepository->update($request, $id);

        $request->session()->flash("message", "Transfer updated successfully!");
        return redirect()->route('admin.transfers.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->productTransferRepository->delete($id);
        session()->flash("message", "Transfer deleted successfully!");
        return redirect()->route('admin.transfers.index');
    }
}
