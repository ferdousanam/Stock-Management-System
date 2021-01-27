<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sale;
use App\Http\Controllers\Controller;
use App\Repositories\ProductSaleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    /**
     * @var ProductSaleRepository
     */
    private $productSaleRepository;

    public function __construct(ProductSaleRepository $productSaleRepository) {
        $this->productSaleRepository = $productSaleRepository;
    }

    private function validateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'due_date' => 'required',
            'payment_status' => 'required',
            'product_id' => 'required',
            'sale_items' => 'required',
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
        $sql = Sale::latest();

        $input = $request->all();
        if (!empty($input['q'])) {
            $sql->where('sale_code', 'LIKE', '%' . $input['q'] . '%');
        }

        $perPage = 25;
        $records = $sql->paginate($perPage);
        $serial = $records->currentPage() * $records->perPage() - $records->perPage() + 1;

        return view('admin.sales.index', compact('serial', 'records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $data = new Sale();
        return view('admin.sales.create', compact('data'));
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
        $insert = Sale::create([
            'title' => $input['title'],
        ]);

        $request->session()->flash("message", "Sale added successfully!");
        return redirect()->route('route.name.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $data = Sale::with('saleItems.product')->findOrFail($id);
        return view('admin.sales.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id)
    {
        $data = Sale::findOrFail($id);
        return view('admin.sales.edit', compact('data'));
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

        $data = Sale::findOrFail($id);
        $data->update($updateData);

        $request->session()->flash("message", "Sale updated successfully!");
        return redirect()->route('route.name.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Sale::destroy($id);
        session()->flash("message", "Sale deleted successfully!");
        return redirect()->route('route.name.index');
    }
}
