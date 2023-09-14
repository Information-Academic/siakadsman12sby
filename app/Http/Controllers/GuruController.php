<?php

namespace App\Http\Controllers;

use App\Guru;
use App\Jadwal;
use App\Mapel;
use App\Nilai;
use App\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $mapel = Mapel::orderBy('nama_mapel')->get();
        $max = Guru::max('nip');
        return view('admin.guru.index', compact('mapel', 'max'));
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
        $this->validate($request, [
            'nip' => 'required',
            'nama_guru' => 'required',
            'mapels_id' => 'required',
            'jenis_kelamin' => 'required'
        ]);

        if ($request->foto_guru) {
            $foto = $request->foto_guru;
            $new_foto = date('siHdmY') . "_" . $foto->getClientOriginalName();
            $foto->move('uploads/guru/', $new_foto);
            $nameFoto = 'uploads/guru/' . $new_foto;
        } else {
            if ($request->jenis_kelamin == 'L') {
                $nameFoto = 'uploads/guru/35251431012020_male.jpg';
            } else {
                $nameFoto = 'uploads/guru/23171022042020_female.jpg';
            }
        }

        $guru = Guru::create([
            'nip' => $request->nip,
            'nama_guru' => $request->nama_guru,
            'mapels_id' => $request->mapels_id,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request -> alamat,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'foto_guru' => $nameFoto,
            'status_guru' => $request->status_guru,
            'status_pegawai' => $request->status_pegawai
        ]);
        // Ditutup dulu sementara
        // Nilai::create([
        //     'gurus_id' => $guru->id
        // ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan data guru baru!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $id = Crypt::decrypt($id);
        $guru = Guru::findorfail($id);
        return view('admin.guru.details', compact('guru'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $id = Crypt::decrypt($id);
        $guru = Guru::findorfail($id);
        $mapel = Mapel::all();
        return view('admin.guru.edit', compact('guru', 'mapel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'nama_guru' => 'required',
            'mapels_id' => 'required',
            'jenis_kelamin' => 'required',
        ]);

        $guru = Guru::findorfail($id);
        $guru_data = [
            'nama_guru' => $request->nama_guru,
            'mapels_id' => $request->mapels_id,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request ->alamat,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'status_guru' => $request->status_guru,
            'status_pegawai' => $request->status_pegawai
        ];
        $guru->update($guru_data);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guru $id)
    {
        //
        $guru = Guru::findorfail($id);
        $countJadwal = Jadwal::where('gurus_id', $guru->id)->count();
        if ($countJadwal >= 1) {
            $jadwal = Jadwal::where('gurus_id', $guru->id)->delete();
        }
        $countUser = User::where('nip', $guru->nip)->count();
        if ($countUser >= 1) {
            $user = User::where('nip', $guru->nip)->delete();
        }
        $guru->delete();
        return redirect()->route('guru.index')->with('warning', 'Data guru berhasil dihapus!');
    }

    public function ubah_foto($id)
    {
        $id = Crypt::decrypt($id);
        $guru = Guru::findorfail($id);
        return view('admin.guru.ubah-foto', compact('guru'));
    }

    public function update_foto(Request $request, $id)
    {
        $this->validate($request, [
            'foto_guru' => 'required'
        ]);

        $guru = Guru::findorfail($id);
        $foto_guru = $request->foto_guru;
        $new_foto = date('s' . 'i' . 'H' . 'd' . 'm' . 'Y') . "_" . $foto_guru->getClientOriginalName();
        $guru_data = [
            'foto_guru' => 'uploads/guru/' . $new_foto,
        ];
        $foto_guru->move('uploads/guru/', $new_foto);
        $guru->update($guru_data);

        return redirect()->route('guru.index')->with('success', 'Berhasil merubah foto!');
    }

    public function mapel($id)
    {
        $id = Crypt::decrypt($id);
        $mapel = Mapel::findorfail($id);
        $guru = Guru::where('mapels_id', $id)->get();
        return view('admin.guru.show', compact('mapel', 'guru'));
    }
}
