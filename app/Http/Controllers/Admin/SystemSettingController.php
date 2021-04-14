<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SystemSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $data = SystemSetting::firstOrFail();

        return view('admin.system-settings.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $data = new SystemSetting();
        return view('admin.system-settings.create', compact('data'));
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
            'app_name' => 'required',
        ]);
        $validator->validate();

        $insert = SystemSetting::updateOrCreate(['id' => 1], [
            'app_name' => $request->input('app_name'),
            'app_email' => $request->input('app_email'),
            'app_mobile' => $request->input('app_mobile'),
            'updated_by' => auth()->id(),
        ]);

        if ($insert) {
            $request->session()->flash("message", "System Setting added successfully!");
        }

        return redirect()->route('admin.system-settings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $data = SystemSetting::findOrFail($id);
        return view('admin.system-settings.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id)
    {
        $data = SystemSetting::findOrFail($id);
        return view('admin.system-settings.edit', compact('data'));
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

        $data = SystemSetting::findOrFail($id);
        $data->update($updateData);

        $request->session()->flash("message", "System Setting updated successfully!");
        return redirect()->route('admin.system-settings.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        SystemSetting::destroy($id);
        session()->flash("message", "System Setting deleted successfully!");
        return redirect()->route('admin.system-settings.index');
    }
}
