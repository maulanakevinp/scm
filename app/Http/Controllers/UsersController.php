<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->q) {
            $users = User::orWhereHas('role', function($q) use ($request){
                    $q->where('peran','like','%'.$request->q.'%');
                })->orWhere('nama','like','%'.$request->q.'%')
                ->orWhere('email','like','%'.$request->q.'%')
                ->orWhere('nomor_hp','like','%'.$request->q.'%')
                ->orderBy('id','desc')->paginate(5);
        } else {
            $users = User::orderBy('id','desc')->paginate(5);
        }
        $totalUser = User::all()->count();
        $distributor = 'Distributor';
        $totalDistributor = User::whereHas('role', function($q) use($distributor){
            $q->where('peran',$distributor);
        })->count();
        return view('users.index',compact('users','totalUser','totalDistributor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'peran'                 => ['required'],
            'email'                 => ['required','email','string','max:32','unique:users'],
            'nama'                  => ['required','string','max:32'],
            'avatar'                => ['nullable','image','mimes:jpeg,png','max:2048'],
            'alamat'                => ['nullable','string'],
            'nomor_hp'              => ['nullable','digits_between:11,13'],
            'tentang_saya'          => ['nullable','string'],
            'password'              => ['required','string','min:8','confirmed'],
            'password_confirmation' => ['required','string','min:8'],
        ]);

        if ($request->file('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('public/avatar');
        } else {
            $data['avatar'] = 'noimage.jpg';
        }

        $data['password'] = Hash::make($request->password);
        $user = User::create($data);
        $user->sendEmailVerificationNotification();
        return redirect()->route('users.show',$user)->with('success','Pengguna berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user','roles'));
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
        $data = $request->validate([
            'peran'         => ['required'],
            'email'         => ['required','email','string','max:32',Rule::unique('users','email')->ignore($user)],
            'nama'          => ['required','string','max:32'],
            'alamat'        => ['nullable','string'],
            'nomor_hp'      => ['nullable','digits_between:11,13'],
            'tentang_saya'  => ['nullable','string']
        ]);

        if ($request->peran != $user->peran || $request->nama != $user->nama || $request->alamat != $user->alamat || $request->nomor_hp != $user->nomor_hp || $request->tentang_saya != $user->tentang_saya) {
            if ($request->email != $user->email) {
                $user->sendEmailVerificationNotification();
            }
            $user->update($data);
            return redirect()->back()->with('success','Profil Pengguna berhasil di perbarui');
        } else {
            return redirect()->back()->with('error','Tidak ada perubahan yang berhasil disimpan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->avatar != 'noimage.jpg') {
            File::delete(storage_path('app/'.$user->avatar));
        }
        User::destroy($user->id);
        return redirect('/users')->with('success','Pengguna bernama "'.$user->nama.'" berhasil dihapus');
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
            'email'         => ['nullable','string','email','max:32',Rule::unique('users','email')->ignore($user)],
            'password'      => ['nullable','string','min:8','confirmed'],
            'password_lama' => ['required','string','min:8'],
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
