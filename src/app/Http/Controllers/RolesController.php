<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Super Admin', ['only' => ['index', 'store', 'show', 'update', 'destroy', 'givePermission']]);
    }
    public function index()
    {
        $metadata = [
            'title' => 'Roles',
            'description' => 'Auth',
            'submenu' => 'roles',
        ];
        $roles = Role::latest()->get();
        if ( request()->ajax() ) {
            return DataTables::of($roles)
                ->addIndexColumn()
                ->addColumn('aksi', function($role) {
                    $random = Str::random(5);
                    return view('components.action-roles', compact('role', 'random'));
                })
                ->rawColumns(['aksi'])
                ->make();
        }
        return view('pages.roles.index', compact('metadata'));
    }

    public function store(Request $request)
    {
        try {
            Role::create($request->all());
            return redirect()->back()->with('success', 'Role telah ditambahkan 🚀');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show(Role $role)
    {
        $metadata = [
            'title' => 'Role Permission',
            'description' => 'Auth',
            'submenu' => 'roles',
        ];
        $permissions = Permission::latest()->get()->groupBy('for_menu');
        return view('pages.roles.role-permission', compact('role', 'permissions', 'metadata'));
    }

    public function update(Request $request, Role $role)
    {
        try {
            $role->update($request->all());
            return redirect()->route('roles.index')->with('success', 'Role telah diupdate 🚀');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->back()->with("success", "Data role berhasil dihapus!");
    }

    public function givePermission(Request $request, Role $role)
    {
        try {
            // Validasi bahwa semua permission yang dikirim ada di database
            $permissions = Permission::whereIn('name', $request->permission)->get();
        
            if ($permissions->count() !== count($request->permission)) {
                // Jika ada permission yang tidak ditemukan, lemparkan pengecualian
                $missingPermissions = array_diff($request->permission, $permissions->pluck('name')->toArray());
                return redirect()->back()->with('error', 'Permission tidak ditemukan: ' . implode(', ', $missingPermissions));
            }
        
            // Sync permissions jika valid
            $role->syncPermissions($permissions);
        
            return redirect()->back()->with('success', 'Permission telah ditambahkan 🚀');
        } catch (\Throwable $th) {
            // Tangani pengecualian umum
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan permission. Silakan coba lagi.');
        }
    }
}
