<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $sql = ProductBrand::orderBy('title');

        $input = $request->all();
        if (!empty($input['q'])) {
            $sql->where('title', 'LIKE', '%' . $input['q'] . '%')
                ->orWhere('code', 'LIKE', '%' . $input['q'] . '%');
        }

        $perPage = 25;
        $records = $sql->paginate($perPage);
        $serial = $records->currentPage() * $records->perPage() - $records->perPage() + 1;

        return view('admin.brands.index', compact('serial', 'records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $data = new ProductBrand();
        return view('admin.brands.create', compact('data'));
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
        $insert = ProductBrand::create([
            'title' => $input['title'],
        ]);

        $request->session()->flash("message", "Product Brand added successfully!");
        return redirect()->route('admin.brands.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $data = ProductBrand::findOrFail($id);
        return view('admin.brands.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id)
    {
        $data = ProductBrand::findOrFail($id);
        return view('admin.brands.edit', compact('data'));
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

        $data = ProductBrand::findOrFail($id);
        $data->update($updateData);

        $request->session()->flash("message", "Product Brand updated successfully!");
        return redirect()->route('admin.brands.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        ProductBrand::destroy($id);
        session()->flash("message", "Product Brand deleted successfully!");
        return redirect()->route('admin.brands.index');
    }
}
