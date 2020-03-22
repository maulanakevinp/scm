<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use function GuzzleHttp\json_encode;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(5);
        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function profil()
    {
        return view('users.profil');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateProfil(Request $request, User $user)
    {
        $data = $request->validate([
            'nama'          => ['required', 'max:32', 'string'],
            'alamat'        => ['nullable','string'],
            'nomor_hp'      => ['nullable','digits_between:11,13'],
            'tentang_saya'  => ['nullable','string']
        ]);
        $user->update($data);
        return redirect()->back()->with('success','Profil berhasil di perbarui');
    }

    public function gantiPassword()
    {
        # code...
    }

    public function updatePassword()
    {
        # code...
    }

    public function updateAvatar(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->avatar != 'noimage.jpg') {
            File::delete(storage_path('app/'.$user->avatar));
        }
        $user->avatar = $request->file('avatar')->store('public/avatar');
        $user->save();
    }
}
