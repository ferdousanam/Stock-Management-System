<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(ProductRepository $productRepository) {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $records = $this->productRepository->paginate($request);
        $serial = $records->currentPage() * $records->perPage() - $records->perPage() + 1;

        $brands = ProductBrand::all();
        $categories = ProductCategory::all();
        return view('admin.products.index', compact('serial', 'records', 'brands', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $data = new Product();
        $brands = ProductBrand::all();
        $categories = ProductCategory::all();
        return view('admin.products.create', compact('data', 'brands', 'categories'));
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
            "product_brand_id" => 'required',
            "product_category_id" => 'required',
            "price" => 'required',
            "alert_quantity" => 'nullable',
        ]);
        $validator->validate();

        $input = $validator->validated();
        $input['product_code'] = str_pad(rand(0, pow(10, 6)-1), 6, '0', STR_PAD_LEFT);
        $input['slug'] = Str::slug($input['title']);
        $insert = Product::create($input);

        $request->session()->flash("message", "Product added successfully!");
        return redirect()->route('admin.products.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $data = Product::with(['category', 'brand'])->findOrFail($id);
        return view('admin.products.show', compact('data'));
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
        $brands = ProductBrand::all();
        $categories = ProductCategory::all();
        return view('admin.products.edit', compact('data', 'brands', 'categories'));
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
            "product_brand_id" => 'required',
            "product_category_id" => 'required',
            "price" => 'required',
            "alert_quantity" => 'nullable',
        ]);
        $validator->validate();

        $updateData = $validator->validated();
        $data = Product::findOrFail($id);
        $data->update($updateData);

        $request->session()->flash("message", "Product updated successfully!");
        return redirect()->route('admin.products.edit', $id);
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
        return redirect()->route('admin.products.index');
    }
}
