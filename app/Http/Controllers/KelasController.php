<?php

namespace App\Http\Controllers;

use App\Guru;
use App\Jadwal;
use App\Kelas;
use App\Siswa;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $kelas = Kelas::OrderBy('kelas', 'asc')->get();
        $guru = Guru::OrderBy('nama_guru', 'asc')->get();
        return view('admin.kelas.index', compact('kelas', 'guru'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $guru = Guru::OrderBy('nama_guru', 'asc')->get();
        return view('admin.kelas.create', compact('guru'));
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
        if ($request->id != '') {
            $this->validate($request, [
                'kelas' => 'required|min:1|max:200',
                'tipe_kelas' => 'required|min:3|max:100',
                'tahun' => 'required|min:2|max:200',
                'gurus_id' => 'required|unique:kelas',
            ]);
        } else {
            $this->validate($request, [
                'kelas' => 'required|min:1|max:200',
                'tipe_kelas' => 'required|min:3|max:100',
                'tahun' => 'required|min:2|max:200',
                'gurus_id' => 'required|unique:kelas',
            ]);
        }

        Kelas::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'kelas' => 'required|min:1|max:200',
                'tipe_kelas' => 'required|min:3|max:100',
                'tahun' => 'required|min:2|max:200',
                'gurus_id' => 'required|unique:kelas',
            ]
        );

        return redirect()->back()->with('success', 'Data kelas berhasil diperbarui!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function show(Kelas $kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelas $kelas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kelas $kelas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $kelas = Kelas::findorfail($id);
        $countJadwal = Jadwal::where('kelas_id', $kelas->id)->count();
        if ($countJadwal >= 1) {
            Jadwal::where('kelas_id', $kelas->id)->delete();
        } else {
        }
        $countSiswa = Siswa::where('kelas_id', $kelas->id)->count();
        if ($countSiswa >= 1) {
            Siswa::where('kelas_id', $kelas->id)->delete();
        } else {
        }
        $kelas->delete();
        return redirect()->back()->with('warning', 'Data kelas berhasil dihapus!');
    }

    public function getEdit(Request $request)
    {
        $kelas = Kelas::where('id', $request->id)->get();
        foreach ($kelas as $val) {
            $newForm[] = array(
                'id' => $val->id,
                'kelas' => $val->kelas,
                'tipe_kelas'=> $val->tipe_kelas,
                'tahun'=> $val->tahun,
                'gurus_id' => $val->gurus_id,
            );
        }
        return response()->json($newForm);
    }
}
