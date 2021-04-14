<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Warehouse;
use App\Repositories\ProductStockRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockManagementController extends Controller
{
    /**
     * @var ProductStockRepository
     */
    private $productStockRepository;

    public function __construct(ProductStockRepository $productStockRepository) {
        $this->productStockRepository = $productStockRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $sql = $this->productStockRepository;

        if (!empty($request->input('warehouse'))) {
            $sql->filterByWarehouse($request->input('warehouse'));
        }

        $sql = $sql->getSql();

        if (!empty($request->input('q'))) {
            $sql->where('products.title', 'LIKE', '%' . $request->input('q') . '%')
                ->orWhere('products.product_code', 'LIKE', '%' . $request->input('q') . '%');
        }

        $perPage = 25;
        $records = $sql->paginate($perPage);
        $serial = $records->currentPage() * $records->perPage() - $records->perPage() + 1;

        $warehouses = Warehouse::all();

        return view('admin.stock-management.index', compact('serial', 'records', 'warehouses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $data = new Product();
        return view('admin.stock-management.create', compact('data'));
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
            'title' => 'required',
        ]);
        $validator->validate();

        $input = $request->all();
        $insert = Product::create([
            'title' => $input['title'],
        ]);

        $request->session()->flash("message", "Product added successfully!");
        return redirect()->route('admin.stock-management.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $data = Product::findOrFail($id);
        return view('admin.stock-management.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id)
    {
        $data = Product::findOrFail($id);
        return view('admin.stock-management.edit', compact('data'));
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
            'title' => 'required',
        ]);
        $validator->validate();

        $input = $request->all();
        $updateData = [
            'title' => $input['title'],
        ];

        $data = Product::findOrFail($id);
        $data->update($updateData);

        $request->session()->flash("message", "Product updated successfully!");
        return redirect()->route('admin.stock-management.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Product::destroy($id);
        session()->flash("message", "Product deleted successfully!");
        return redirect()->route('admin.stock-management.index');
    }
}
