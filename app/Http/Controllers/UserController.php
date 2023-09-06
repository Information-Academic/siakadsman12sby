<?php

namespace App\Http\Controllers;

use App\User;
use App\Guru;
use App\Imports\UserImport;
use App\Exports\UserExport;
use App\Kelas;
use App\Mapel;
use App\Siswa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = User::all();
        $user = $user->groupBy('roles');
        return view('admin.user.index', compact('user'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required',
        ]);

        if ($request->roles == 'Guru') {
            $countGuru = Guru::where('nip', $request->nomer)->count();
            $guruId = Guru::where('nip', $request->nomer)->get();
            foreach ($guruId as $val) {
                $guru = Guru::find($val->id);
            }
            if ($countGuru >= 1) {
                User::create([
                    'nama_depan' => $request->nama_depan,
                    'nama_belakang' => $request->nama_belakang,
                    'nama_pengguna'=> $request->nama_pengguna,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'roles' => $request->roles,
                    'nip' => $request->nomer,
                ]);
                return redirect()->back()->with('success', 'Berhasil menambahkan user Guru baru!');
            } else {
                return redirect()->back()->with('error', 'Maaf User ini tidak terdaftar sebagai guru!');
            }
        } elseif ($request->roles == 'Siswa') {
            $countSiswa = Siswa::where('nis', $request->nomer)->count();
            $siswaId = Siswa::where('nis', $request->nomer)->get();
            foreach ($siswaId as $val) {
                $siswa = Siswa::findorfail($val->id);
            }
            if ($countSiswa >= 1) {
                User::create([
                    'nama_depan' => $request-> nama_depan,
                    'nama_belakang' => $request -> nama_belakang,
                    'nama_pengguna' => strtolower($siswa->nama_siswa),
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'roles' => $request->roles,
                    'nis' => $request->nomer,
                ]);
                return redirect()->back()->with('success', 'Berhasil menambahkan user Siswa baru!');
            } else {
                return redirect()->back()->with('error', 'Maaf User ini tidak terdaftar sebagai siswa!');
            }
        } else {
            User::create([
                'nama_depan' => $request->nama_depan,
                'nama_pengguna' => $request->nama_pengguna,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'roles' => $request->roles,
            ]);
            return redirect()->back()->with('success', 'Berhasil menambahkan user Admin baru!');
        }
    }


    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::where('roles', $id)->get();
        $role = $user->groupBy('roles');
        return view('admin.user.show', compact('user', 'role'));
    }

    public function destroy($id)
    {
        $user = User::findorfail($id);
        if ($user->roles == 'Admin') {
            if ($user->id == Auth::user()->id) {
                $user->delete();
                return redirect()->back()->with('warning', 'Data user berhasil dihapus!');
            } else {
                return redirect()->back()->with('error', 'Maaf user ini bukan milik anda!');
            }
        }
        else {
            $user->delete();
            return redirect()->back()->with('warning', 'Data user berhasil dihapus!');
        }
    }

    public function email(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $countUser = User::where('email', $request->email)->count();
        if ($countUser >= 1) {
            return redirect()->route('reset.password', Crypt::encrypt($user->id))->with('success', 'Email ini sudah terdaftar!');
        } else {
            return redirect()->back()->with('error', 'Maaf email ini belum terdaftar!');
        }
    }

    public function password($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::findorfail($id);
        return view('auth.passwords.reset', compact('user'));
    }

    public function update_password(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'required|string|min:8|confirmed'
        ]);
        $user = User::findorfail($id);
        $user_data = [
            'password' => Hash::make($request->password)
        ];
        $user->update($user_data);
        return redirect()->route('login')->with('success', 'User berhasil diperbarui!');
    }

    public function profile()
    {
        return view('user.pengaturan');
    }

    public function edit_profile()
    {
        $mapel = Mapel::all();
        $kelas = Kelas::all();
        return view('user.profile', compact('mapel', 'kelas'));
    }

    public function ubah_profile(Request $request)
    {
        if (Auth::user()->roles == 'Guru') {
            $this->validate($request, [
                'nama_depan'      => 'required',
                'nama_pengguna'   => 'reqired',
                'mapels_id'  => 'required',
                'jenis_kelamin'        => 'required',
                'no_telepon'      => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
            ]);
            $guru = Guru::where('nip', Auth::user()->nip)->first();
            $user = User::where('nip', Auth::user()->nip)->first();
            if ($user) {
                $user_data = [
                    'nama_pengguna' => $request->nama_pengguna
                ];
                $user->update($user_data);
            }
            $guru_data = [
                'nama_guru' => $request->nama_guru,
                'mapels_id'  => $request->mapels_id,
                'jenis_kelamin'        => $request->jenis_kelamin,
                'no_telepon'      => $request->no_telepon,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir
            ];
            $guru->update($guru_data);
            return redirect()->route('profile')->with('success', 'Profile anda berhasil diperbarui!');
        } elseif (Auth::user()->roles == 'Siswa') {
            $this->validate($request, [
                'nama_depan'      => 'required',
                'nama_pengguna' => 'required',
                'jenis_kelamin'        => 'required',
                'kelas_id'  => 'required',
                'nis'       => 'required',
                'no_telepon'      => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
            ]);
            $siswa = Siswa::where('nis', Auth::user()->nis)->first();
            $user = User::where('nis', Auth::user()->nis)->first();
            if ($user) {
                $user_data = [
                    'nama_pengguna' => $request->nama_pengguna
                ];
                $user->update($user_data);
            }
            $siswa_data = [
                'nis'        => $request->nis,
                'nama_siswa' => $request->nama_siswa,
                'jenis_kelamin'         => $request->jenis_kelamin,
                'kelas_id'   => $request->kelas_id,
                'no_telepon'       => $request->no_telepon,
                'tempat_lahir'  => $request->tempat_lahir,
                'tanggal_lahir'  => $request->tanggal_lahir,
            ];
            $siswa->update($siswa_data);
            return redirect()->route('profile')->with('success', 'Profile anda berhasil diperbarui!');
        } else {
            $user = User::findorfail(Auth::user()->id);
            $data_user = [
                'nama_depan' => $request->nama_depan,
                'nama_belakang' => $request->nama_belakang,
            ];
            $user->update($data_user);
            return redirect()->route('profile')->with('success', 'Profile anda berhasil diperbarui!');
        }
    }

    public function edit_foto()
    {
        if (Auth::user()->roles == 'Guru' || Auth::user()->roles == 'Siswa') {
            return view('user.foto');
        } else {
            return redirect()->back()->with('error', 'Not Found 404!');
        }
    }

    public function ubah_foto(Request $request)
    {
        if ($request->roles == 'Guru') {
            $this->validate($request, [
                'foto_guru' => 'required'
            ]);
            $guru = Guru::where('nip', Auth::user()->nip)->first();
            $foto = $request->foto_guru;
            $new_foto = date('s' . 'i' . 'H' . 'd' . 'm' . 'Y') . "_" . $foto->getClientOriginalName();
            $guru_data = [
                'foto' => 'uploads/guru/' . $new_foto,
            ];
            $foto->move('uploads/guru/', $new_foto);
            $guru->update($guru_data);
            return redirect()->route('profile')->with('success', 'Foto Profile anda berhasil diperbarui!');
        } else {
            $this->validate($request, [
                'foto_siswa' => 'required'
            ]);
            $siswa = Siswa::where('nis', Auth::user()->nis)->first();
            $foto = $request->foto_siswa;
            $new_foto = date('s' . 'i' . 'H' . 'd' . 'm' . 'Y') . "_" . $foto->getClientOriginalName();
            $siswa_data = [
                'foto' => 'uploads/siswa/' . $new_foto,
            ];
            $foto->move('uploads/siswa/', $new_foto);
            $siswa->update($siswa_data);
            return redirect()->route('profile')->with('success', 'Foto Profile anda berhasil diperbarui!!');
        }
    }

    public function edit_email()
    {
        return view('user.email');
    }

    public function ubah_email(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email'
        ]);
        $user = User::findorfail(Auth::user()->id);
        $cekUser = User::where('email', $request->email)->count();
        if ($cekUser >= 1) {
            return redirect()->back()->with('error', 'Maaf email ini sudah terdaftar!');
        } else {
            $user_email = [
                'email' => $request->email,
            ];
            $user->update($user_email);
            return redirect()->back()->with('success', 'Email anda berhasil diperbarui!');
        }
    }

    public function edit_password()
    {
        return view('user.password');
    }

    public function ubah_password(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|string|min:8|confirmed'
        ]);
        $user = User::findorfail(Auth::user()->id);
        if ($request->password_lama) {
            if (Hash::check($request->password_lama, $user->password)) {
                if ($request->password_lama == $request->password) {
                    return redirect()->back()->with('error', 'Maaf password yang anda masukkan sama!');
                } else {
                    $user_password = [
                        'password' => Hash::make($request->password),
                    ];
                    $user->update($user_password);
                    return redirect()->back()->with('success', 'Password anda berhasil diperbarui!');
                }
            } else {
                return redirect()->back()->with('error', 'Tolong masukkan password lama anda dengan benar!');
            }
        } else {
            return redirect()->back()->with('error', 'Tolong masukkan password lama anda terlebih dahulu!');
        }
    }

    public function cek_email(Request $request)
    {
        $countUser = User::where('email', $request->email)->count();
        if ($countUser >= 1) {
            return response()->json(['success' => 'Email Anda Benar']);
        } else {
            return response()->json(['error' => 'Maaf user tidak ditemukan!']);
        }
    }

    public function cek_password(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $countUser = User::where('email', $request->email)->count();
        if ($countUser >= 1) {
            if (Hash::check($request->password, $user->password)) {
                return response()->json(['success' => 'Password Anda Benar']);
            } else {
                return response()->json(['error' => 'Maaf user tidak ditemukan!']);
            }
        } else {
            return response()->json(['warning' => 'Maaf user tidak ditemukan!']);
        }
    }

    public function import_excel(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        $file = $request->file('file');
        $nama_file = rand() . $file->getClientOriginalName();
        $file->move('file_user', $nama_file);
        Excel::import(new UserImport, public_path('/file_user/' . $nama_file));
        return redirect()->back()->with('success', 'Data User Berhasil Diimport!');
    }

    public function export_excel()
    {
        return Excel::import(new UserExport, 'user.xlsx');
    }

}
