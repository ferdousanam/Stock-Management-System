<?php

namespace App\Http\Controllers\Admin;

use App\Models\Warehouse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $sql = Warehouse::orderBy('name');

        $input = $request->all();
        if (!empty($input['q'])) {
            $sql->where('name', 'LIKE', '%' . $input['q'] . '%');
            $sql->orWhere('code', 'LIKE', '%' . $input['q'] . '%');
        }

        $perPage = 25;
        $records = $sql->paginate($perPage);
        $serial = $records->currentPage() * $records->perPage() - $records->perPage() + 1;

        return view('admin.warehouses.index', compact('serial', 'records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $data = new Warehouse();
        return view('admin.warehouses.create', compact('data'));
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
            'name' => 'required',
        ]);
        $validator->validate();

        $input = $request->all();
        $insert = Warehouse::create([
            'name' => $input['name'],
        ]);

        $request->session()->flash("message", "Warehouse added successfully!");
        return redirect()->route('admin.warehouses.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $data = Warehouse::findOrFail($id);
        return view('admin.warehouses.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id)
    {
        $data = Warehouse::findOrFail($id);
        return view('admin.warehouses.edit', compact('data'));
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
            'name' => 'required',
        ]);
        $validator->validate();

        $input = $request->all();
        $updateData = [
            'name' => $input['name'],
        ];

        $data = Warehouse::findOrFail($id);
        $data->update($updateData);

        $request->session()->flash("message", "Warehouse updated successfully!");
        return redirect()->route('admin.warehouses.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Warehouse::destroy($id);
        session()->flash("message", "Warehouse deleted successfully!");
        return redirect()->route('admin.warehouses.index');
    }
}
