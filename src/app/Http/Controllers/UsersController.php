<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:create-user'], ['only' => ['store']]);
        $this->middleware(['permission:read-user'], ['only' => ['index']]);
        $this->middleware(['permission:edit-user'], ['only' => ['update']]);    
        $this->middleware(['permission:delete-user'], ['only' => ['destroy']]);
    }

    public function index()
    {
        $metadata = [
            'title' => 'Users',
            'description' => 'Auth',
            'submenu' => 'users',
        ];

        $branches = Branch::latest()->get();
        $roles = Role::all();
        $users = User::with('branch')->latest()->get();
        if ( request()->ajax() ) {
            return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('branch_name', function($user) {
                return $user->branch ? $user->branch->code : 'N/A';
            })
            ->addColumn('role', function($user) use ($roles) {
                if($user->hasAnyRole($roles)) {
                    return $user->getRoleNames()->first();
                } else {
                    return 'N/A';
                }
            })
            ->addColumn('aksi', function($user) {
                $branches = Branch::latest()->get();
                $unKey = Str::random(4);
                return view('components.action-user', compact('user', 'branches', 'unKey'));
            })
            ->rawColumns(['aksi'])
            ->make();
        }   
        
        return view('pages.users.index', compact('branches', 'roles', 'metadata', 'users') );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'branch_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user = User::create([
                'name' => $request->name,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'branch_id' => $request->branch_id,
            ]);
            $user->assignRole($request->role);
            return redirect()->back()->with('success', "Pengguna baru $request->name berhasil ditambahkan");
        }
    }


    public function create()
    {
        abort(404);
    }

    public function show(User $user)
    {
        abort(404);
    }

    public function edit(User $user)
    {
        $metadata = [
            'title' => 'Edit User',
            'description' => 'Auth',
            'submenu' => 'users',
        ];

        $branches = Branch::latest()->get();
        $roles = Role::latest()->get();
        return view('pages.users.edit', compact('user', 'roles', 'branches', 'metadata'));
    }

    public function update(Request $request, User $user)
    {
        $data = [
            'branch_id' => $request->branch_id,
            'name' => $request->name,
            'username' => $request->username,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'email' => $request->email,
        ];

        if($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        if($request->role) {
            $user->syncRoles($request->role);
        }

        $user->update($data);
        return redirect()->route('user.index')->with('success', "Data pengguna $request->name berhasil diperbaharui!");
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'Pengguna berhasil di hapus!');
    }
}
