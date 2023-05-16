<?php

namespace App\Http\Controllers\resto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate();
        return view('resto.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = ['RESTO' => 'RESTO', 'KURIR' => 'KURIR', 'KONSUMEN' => 'KONSUMEN'];
        return view('resto.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|unique:users|email',
            'name' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'
        ], [
            'email.required' => 'Email harus diisi!',
            'email.unique' => 'Email sudah dipakai!',
            'email.email' => 'Format email tidak sesuai!',
            'name.required' => 'Nama lengkap harus diisi!',
            'password.required' => 'Password harus diisi!',
            'password.min' => 'Password minimal :min karakter!',
            'confirm_password.required' => 'Konfirmasi password harus diisi!',
            'confirm_password.same' => 'Konfirmasi password harus sama dengan password!'
        ])->validate();
        try {
            $user = new User();
            $user->email = $request->email;
            $user->name = $request->name;
            $user->role = $request->role;
            $user->password = Hash::make($request->password);
            $user->save();
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['msg' => $e->getMessage()]);
        }
        return redirect('/resto/user')->with('success', 'Berhasil tambah data');
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
    public function edit(string $id)
    {
        $data = User::find($id);
        $roles = ['RESTO' => 'RESTO', 'KURIR' => 'KURIR', 'KONSUMEN' => 'KONSUMEN'];
        return view('resto.user.edit', compact(['data', 'roles']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Validator::make($request->all(), [
            'name' => 'required'
        ], [
            'name.required' => 'Nama lengkap harus diisi!'
        ])->validate();
        try {
            $user = User::find($id);
            $user->name = $request->name;
            $user->role = $request->role;
            $user->save();
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['msg' => $e->getMessage()]);
        }
        return redirect('/resto/user')->with('success', 'Berhasil ubah data');;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::find($id);
            $user->delete();
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['msg' => $e->getMessage()]);
        }
        return redirect('/resto/user')->with('success', 'Berhasil hapus data');
    }
}
