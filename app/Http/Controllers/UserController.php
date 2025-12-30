<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index', [
            'title' => 'User',
            'user' => User::with('role')->get(),
            'role' => Role::all(),
        ]);
    }

    public function addUser()
    {
        $validator = request()->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'confirmed'],
            ],
            [
                'name.required' => 'Nama tidak boleh kosong',
                'name.string' => 'Nama hanya boleh hufuf dan angka',
                'name.max' => 'Nama maksimal 255 karakter',
                'username.required' => 'Username tidak boleh kosong',
                'username.string' => 'Username hanya boleh hufuf dan angka',
                'username.max' => 'Username maksimal 255 karakter',
                'username.unique' => 'Username yang sama sudah terdaftar',
                'password.required' => 'Password tidak boleh kosong',
                'password.string' => 'Password hanya boleh hufuf dan angka',
                'password.confirmed' => 'Password tidak sama',

            ]
        );


        // if ($validator->fails())
        // {
        //     return response()->json(['errors'=>$validator->errors()->all()]);
        // }

        User::create([
            'name' => request('name'),
            'username' => request('username'),
            'password' => bcrypt(request('password')),
            'role_id' => request('role_id'),
            'aktif' => 1
        ]);

        return redirect()->back()->with('success', 'Data user berhasil dibuat');
    }

    public function gantiPassword()
    {
        return view('user.ganti_password', [
            'title' => 'Ganti Password'
        ]);
    }

    public function editPassword(Request $request)
    {
        if (!(Hash::check($request->old_password, Auth::user()->password))) {
            return redirect(route('gantiPassword'))->with('error', 'Password sekarang tidak cocok');
        }
        $validator = request()->validate(
            [
                'password' => ['required', 'string', 'confirmed'],
                'old_password' => ['required']

            ],
            [
                'password.required' => 'Password tidak boleh kososng',
                'password.string' => 'Password hanya boleh hufuf dan angka',
                'password.confirmed' => 'Password tidak sama',
            ]
        );

        User::where('id', Auth::user()->id)->update([
            'password' => bcrypt($request->password)
        ]);

        return redirect(route('gantiPassword'))->with('success', 'Password berhasil diganti');
    }


    public function editUser(Request $request)
    {
        $edit = User::where('id', $request->id)->update([
            'name' => $request->name,
            'role_id' => $request->role_id,
            'aktif' => $request->aktif,
        ]);
        return redirect()->back()->with('success', 'Data user berhasil diubah');
    }
}
