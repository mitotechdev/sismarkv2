<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    public function index()
    {
        $branches = Branch::latest()->get();
        if ( request()->ajax() ) {
            return DataTables::of(User::query()->with('branch')->latest())
            ->addIndexColumn()
            ->addColumn('branch_name', function($user) {
                return $user->branch ? $user->branch->code : 'N/A';
            })
            ->addColumn('aksi', function($user) {
                $branches = Branch::latest()->get();
                $unKey = Str::random(4);
                return view('components.action-user', compact('user', 'branches', 'unKey'));
            })
            ->rawColumns(['aksi'])
            ->make();
        }   
        
        return view('pages.user', compact('branches') );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
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
            User::create([
                'employee_id' => $request->employee_id,
                'name' => $request->name,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'branch_id' => $request->branch_id,
            ]);
            return redirect()->back()->with('success', "$request->name");
        }
    }


    public function create()
    {

    }

    public function show(User $user)
    {
        dd($user);
    }

    public function update(Request $request, User $user)
    {
        $data = [
            'employee_id' => $request->employee_id,
            'branch_id' => $request->branch_id,
            'name' => $request->name,
            'username' => $request->username,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'email' => $request->email,
        ];

        if($request->password) {
            $data['password'] = $request->password;
        }

        $user->update($data);
        return redirect()->back()->with('updated', "$request->name");
    }

    public function destroy(User $user)
    {
        // $user->delete();
        // return redirect()->back()->with('deleted', "$user->name");
        return redirect()->back()->with('warning', 'Sistem tidak dapat mengakomodir penghapusan data. Hal ini akan mengakibatkan relasi data terganggu.');
    }

    public function preview()
    {
        $branches = Branch::latest()->get();
        return view('pages.user-show', compact('branches'));
    }
}
