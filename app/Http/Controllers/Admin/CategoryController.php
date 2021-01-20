<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $sql = ProductCategory::orderBy('id', 'desc');

        $input = $request->all();
        if (!empty($input['q'])) {
            $sql->where('title', 'LIKE', '%' . $input['q'] . '%');
        }

        $perPage = 25;
        $records = $sql->paginate($perPage);
        $serial = $records->currentPage() * $records->perPage() - $records->perPage() + 1;

        return view('admin.categories.index', compact('serial', 'records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $data = new ProductCategory();
        $categories = ProductCategory::all();
        return view('admin.categories.create', compact('data', 'categories'));
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
            'parent_id' => 'nullable',
            'description' => 'nullable',
        ]);
        $validator->validate();

        $input = $request->all();
        $insert = ProductCategory::create([
            'code' => str_pad(rand(0, pow(10, 6)-1), 6, '0', STR_PAD_LEFT),
            'title' => $input['title'],
            'parent_id' => $input['parent_id'],
            'slug' => Str::slug($input['title']),
            'description' => $input['description'],
        ]);

        $request->session()->flash("message", "Product Category added successfully!");
        return redirect()->route('admin.categories.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $data = ProductCategory::findOrFail($id);
        return view('admin.categories.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id)
    {
        $data = ProductCategory::findOrFail($id);
        $categories = ProductCategory::all();
        return view('admin.categories.edit', compact('data', 'categories'));
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
            'parent_id' => 'nullable',
            'description' => 'nullable',
        ]);
        $validator->validate();

        $input = $request->all();
        $updateData = [
            'title' => $input['title'],
            'parent_id' => $input['parent_id'],
            'description' => $input['description'],
        ];

        $data = ProductCategory::findOrFail($id);
        $data->update($updateData);

        $request->session()->flash("message", "Product Category updated successfully!");
        return redirect()->route('admin.categories.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        ProductCategory::destroy($id);
        session()->flash("message", "Product Category deleted successfully!");
        return redirect()->route('admin.categories.index');
    }
}
