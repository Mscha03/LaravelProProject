<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use SweetAlert2\Laravel\Swal;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $permissions = Permission::query();

        if($keyword = request('table_search')) {
            $permissions->where('name', 'like', '%'.$keyword.'%')->orWhere('label', 'like', '%'.$keyword.'%');
        }

        $permissions = $permissions->latest()->paginate(20); // Assuming you have a User model
        return view('admin.permissions.all', compact('permissions')); // Assuming you have a view for listing permissions

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.permissions.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:permissions',
            'label' => 'required|string|max:255',
        ]);

        $permission = Permission::create($data);


        Swal::fire([
            'title' => " دسترسی $permission->name  ایجاد شد",
            'icon' => 'info',
            'confirmButtonText' => 'باشه'
        ]);

        return redirect()->route('admin.permissions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions')->ignore($permission->id)],
            'label' => 'required|string|max:255',
        ]);


        $permission->update($data);

        Swal::fire([
            'title' => 'با موفقیت ویرایش شد',
            'icon' => 'success',
            'confirmButtonText' => 'باشه'
        ]);
        return redirect()->route('admin.permissions.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        Swal::fire([
            'title' => 'با موفقیت حذف شد',
            'icon' => 'success',
            'confirmButtonText' => 'باشه'
        ]);


        return redirect()->route('admin.permissions.index');
    }
}
