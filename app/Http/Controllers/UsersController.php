<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
        if ($request->nama != $user->nama || $request->alamat != $user->alamat || $request->nomor_hp != $user->nomor_hp || $request->tentang_saya != $user->tentang_saya) {
            $user->update($data);
            return redirect()->back()->with('success','Profil berhasil di perbarui');
        } else {
            return redirect()->back()->with('error','Tidak ada perubahan yang berhasil disimpan');
        }

    }

    public function pengaturan()
    {
        return view('users.pengaturan');
    }

    public function updatePengaturan(Request $request, User $user)
    {
        $email = false;
        $password = false;
        $request->validate([
            'email'                     => ['nullable','string','email','max:32',Rule::unique('users','email')->ignore($user)],
            'password'             => ['nullable','string','min:8','confirmed'],
            'password_lama'                  => ['required','string','min:8'],
        ]);
        if (Hash::check($request->password_lama, $user->password)) {
            if ($request->email == '' && $request->password == '') {
                return redirect()->back()->with('error','Tidak ada perubahan yang berhasil disimpan');
            } else {
                if($request->email){
                    $user->email = $request->email;
                    $user->email_verified_at = null;
                    $email = true;
                }

                if ($request->password && $request->password_confirmation) {
                    $user->password = Hash::make($request->password);
                    $password = true;
                }
                $user->save();

                if ($email && $password) {
                    $user->sendEmailVerificationNotification();
                    return redirect()->back()->with('success','Email dan password berhasil diperbarui');
                } elseif ($email) {
                    $user->sendEmailVerificationNotification();
                    return redirect()->back()->with('success','Email berhasil diperbarui');
                } elseif($password){
                    return redirect()->back()->with('success','Password berhasil diperbarui');
                }
            }
        } else {
            return redirect()->back()->with('error','Password yang anda masukkan salah');
        }


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
