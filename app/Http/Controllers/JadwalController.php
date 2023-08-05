<?php

namespace App\Http\Controllers;

use App\Jadwal;
use App\Hari;
use App\Kelas;
use App\Guru;
use App\Mapel;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $hari = Hari::all();
        $mapel = Mapel::all();
        $kelas = Kelas::OrderBy('kelas','asc')->get();
        $guru = Guru::OrderBy('nama_guru', 'asc')->get();
        return view('admin.jadwal.index', compact('hari', 'mapel','kelas', 'guru'));
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
            'haris_id' => 'required',
            'kelas_id' => 'required',
            'gurus_id' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',            
        ]);

        $guru = Guru::findorfail($request->gurus_id);
        Jadwal::updateOrCreate(
            [
                'id' => $request->jadwals_id
            ],
            [
                'haris_id' => $request->haris_id,
                'kelas_id' => $request->kelas_id,
                'mapels_id' => $guru->mapels_id,
                'gurus_id' => $request->gurus_id,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
            ]
        );

        return redirect()->back()->with('success', 'Data jadwal berhasil diperbarui!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function show(Jadwal $jadwal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function edit(Jadwal $jadwal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jadwal $jadwal)
    {
        //
    }
}
