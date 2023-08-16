<?php

namespace App\Http\Controllers;

use App\Guru;
use App\Jadwal;
use App\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $mapel = Mapel::OrderBy('nama_mapel', 'asc')->get();
        return view('admin.mapel.index', compact('mapel'));
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
            'nama_mapel' => 'required',
            'kurikulum' => 'required',
        ]);

        Mapel::updateOrCreate(
            [
                'id' => $request->mapels_id
            ],
            [
                'nama_mapel' => $request->nama_mapel,
                'kurikulum' => $request->kurikulum,
            ]
        );

        return redirect()->back()->with('success', 'Data mapel berhasil diperbarui!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mapel  $mapel
     * @return \Illuminate\Http\Response
     */
    public function show(Mapel $mapel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mapel  $mapel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $id = Crypt::decrypt($id);
        $mapel = Mapel::findorfail($id);
        return view('admin.mapel.edit', compact('mapel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mapel  $mapel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mapel $mapel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mapel  $mapel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $mapel = Mapel::findorfail($id);
        $countJadwal = Jadwal::where('mapels_id', $mapel->id)->count();
        if ($countJadwal >= 1) {
            $jadwal = Jadwal::where('mapels_id', $mapel->id)->delete();
        }
        $countGuru = Guru::where('mapels_id', $mapel->id)->count();
        if ($countGuru >= 1) {
            $guru = Guru::where('mapels_id', $mapel->id)->delete();
        } else {
        }
        $mapel->delete();
        return redirect()->back()->with('warning', 'Data mapel berhasil dihapus!');
    }

    
    public function getMapelJson(Request $request)
    {
        $jadwal = Jadwal::OrderBy('mapels_id', 'asc')->where('kelas_id', $request->kelas_id)->get();
        $jadwal = $jadwal->groupBy('mapels_id');

        foreach ($jadwal as $val => $data) {
            $newForm[] = array(
                'mapels' => $data[0]->pelajaran($val)->nama_mapel,
                'gurus' => $data[0]->pengajar($data[0]->gurus_id)->id
            );
        }

        return response()->json($newForm);
    }
}
