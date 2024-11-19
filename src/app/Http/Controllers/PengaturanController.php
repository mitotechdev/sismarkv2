<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $metadata = [
            'title' => 'Pengaturan Profile',
            'description' => 'pengaturan',
            'submenu' => 'pengaturan',
        ];

        $user = auth()->user();
        $branches = Branch::latest()->get();
        return view('pages.pengaturan', compact('branches', 'user', 'metadata'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            "name" => "required",
            "gender" => "required",
            "phone" => "required",
            "email" => "required",
            "username" => "required",
        ]);

        $data = [
            'name' => $request->name,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'email' => $request->email,
            'username' => $request->username,
        ];

        if(auth()->user()->can('admin-switch-branch')) {
            $data['branch_id'] = $request->branch_id;
        }

        if($request->password) {
            $data['password'] = $request->password;
        }

        $user->update($data);

        return redirect()->route('home')->with('success', 'Profil telah diubah 🚀');
    }
}
