<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

use SweetAlert2\Laravel\Swal;


class UserController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query();

        if($keyword = request('table_search')) {
            $users->where('email', 'like', '%'.$keyword.'%')->orWhere('name', 'like', '%'.$keyword.'%')->orWhere('id', '%'.$keyword.'%');
        }

        if (\request('admin')) {
            $users->where('is_superuser', true)->orWhere('is_stuff', true);
        }

        $users = $users->latest()->paginate(20); // Assuming you have a User model
        return view('admin.users.all', compact('users')); // Assuming you have a view for listing users
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a new user
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create($data);

        if ($request->has('verify')) {
            $user->markEmailAsVerified();
        }

            Swal::fire([
            'title' => "کاربر $user->name ایجاد شد",
            'icon' => 'info',
            'confirmButtonText' => 'باشه'
        ]);

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {

        if(Gate::allows('edit', $user)) {
            return view('admin.users.edit', compact('user'));
        }

        // $this->authorize('edit-user', $user);

        // if(auth()->user()->can('edit-user', $user)) {
        //  return view('admin.users.edit', compact('user'));
        // }

        abort(403);


        // if (Gate::denies('edit-user', $user)) {
        //     Swal::fire([
        //         'title' => 'شما اجازه ویرایش این کاربر را ندارید',
        //         'icon' => 'error',
        //         'confirmButtonText' => 'باشه'
        //     ]);
        //     return redirect()->route('admin.users.index');
        // }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|', Rule::unique('users')->ignore($user),
        ]);

        if (!is_null($request->password)) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);

            $data['password'] = $request->password;
        }

        $user->update($data);

        if ($request->has('verify')) {
            $user->markEmailAsVerified();
        }


        Swal::fire([
            'title' => 'با موفقیت ویرایش شد',
            'icon' => 'success',
            'confirmButtonText' => 'باشه'
        ]);
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        
        $user->delete();

        Swal::fire([
            'title' => 'با موفقیت حذف شد',
            'icon' => 'success',
            'confirmButtonText' => 'باشه'
        ]);


        return redirect()->route('admin.users.index');
    }
}   