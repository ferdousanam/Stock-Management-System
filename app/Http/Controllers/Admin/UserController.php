<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private function validateRequest(Request $request, $additional_rules = [])
    {
        $rules = array_merge([
            'name' => 'required',
            'email' => 'required',
        ], $additional_rules);
        $validator = Validator::make($request->all(), $rules);
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
        $sql = User::latest();

        $input = $request->all();
        if (!empty($input['q'])) {
            $sql->where('name', 'LIKE', '%' . $input['q'] . '%');
        }

        $perPage = 25;
        $records = $sql->paginate($perPage);
        $serial = $records->currentPage() * $records->perPage() - $records->perPage() + 1;

        return view('admin.users.index', compact('serial', 'records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $data = new User();
        $create = true;
        return view('admin.users.create', compact('data', 'create'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validateRequest($request, ['password' => 'required']);

        $input = $request->all();
        $insert = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
        ]);

        $request->session()->flash("message", "User added successfully!");
        return redirect()->route('admin.users.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $data = User::findOrFail($id);
        return view('admin.users.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id)
    {
        $data = User::findOrFail($id);
        return view('admin.users.edit', compact('data'));
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

        $input = $request->all();
        $updateData = [
            'name' => $input['name'],
            'email' => $input['email'],
        ];

        if ($input['password']) {
            $updateData['password'] = bcrypt($input['password']);
        }

        $data = User::findOrFail($id);
        $data->update($updateData);

        $request->session()->flash("message", "User updated successfully!");
        return redirect()->route('admin.users.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        User::destroy($id);
        session()->flash("message", "User deleted successfully!");
        return redirect()->route('admin.users.index');
    }
}
