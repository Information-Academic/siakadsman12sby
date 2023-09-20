<?php

namespace App\Http\Controllers;

use App\Guru;
use App\Jadwal;
use App\Kelas;
use App\Rapor;
use App\Siswa;
use App\Ulangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class UlanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $kelas = Kelas::orderBy('kelas')->get();
        return view('admin.ulangan.home',compact('kelas'));
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
        $guru = Guru::findorfail($request->gurus_id);
        $cekJadwal = Jadwal::where('gurus_id',$request->gurus_id)->where('kelas_id',$request->kelas_id)->count();

        if($cekJadwal >=1){
            if($request->ulha_1 && $request->ulha_2 && $request->uts && $request->ulha_3 && $request->uas){
                $nilai = ($request->ulha_1 + $request->ulha_2 + $request->uts + $request->ulha_3 + (2 * $request->uas)) / 6;
                $nilai = (int) $nilai;
                if($nilai>90){
                    Rapor::create([
                        'siswas_id' => $request->siswas_id,
                        'kelas_id' => $request->kelas_id,
                        'gurus_id' => $request->gurus_id,
                        'mapels_id' => $guru->mapels_id,
                        'kkm_nilai' => $nilai,
                    ]);
                }
                else if($nilai > 80){
                    Rapor::create([
                        'siswas_id' => $request->siswas_id,
                        'kelas_id' => $request->kelas_id,
                        'gurus_id' => $request->gurus_id,
                        'mapels_id' => $guru->mapels_id,
                        'kkm_nilai' => $nilai,
                    ]);
                }
                else if($nilai > 70){
                    Rapor::create([
                        'siswas_id' => $request->siswas_id,
                        'kelas_id' => $request->kelas_id,
                        'gurus_id' => $request->gurus_id,
                        'mapels_id' => $guru->mapels_id,
                        'kkm_nilai' => $nilai,
                    ]);
                }
                else {
                    Rapor::create([
                        'siswas_id' => $request->siswas_id,
                        'kelas_id' => $request->kelas_id,
                        'gurus_id' => $request->gurus_id,
                        'mapels_id' => $guru->mapels_id,
                        'kkm_nilai' => $nilai,
                    ]);
                }
            }
            else{

            }
            Ulangan::updateOrCreate(
                [
                    'id' => $request->id
                ],
                [
                    'siswas_id' => $request->siswas_id,
                    'kelas_id' => $request->kelas_id,
                    'gurus_id' => $request->gurus_id,
                    'mapels_id' => $guru->mapels_id,
                    'ulha_1' => $request->ulha_1,
                    'ulha_2' => $request->ulha_2,
                    'uts' => $request->uts,
                    'ulha_3' => $request->ulha_3,
                    'uas' => $request->uas,
                ]);
            return redirect()->route('guru.ulangan.kelas')->with('success', 'Data Nilai berhasil disimpan!');
        }
        else{
            return redirect()->route('guru.ulangan.kelas')->with('error', 'Data Nilai gagal disimpan!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ulangan  $ulangan
     * @return \Illuminate\Http\Response
     */
    public function show(Ulangan $ulangan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ulangan  $ulangan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $id = Crypt::decrypt($id);
        $kelas = Kelas::findorfail($id);
        $siswa = Siswa::orderBy('nama_siswa')->where('kelas_id', $id)->get();
        return view('admin.ulangan.index', compact('kelas', 'siswa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ulangan  $ulangan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ulangan $ulangan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ulangan  $ulangan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ulangan $ulangan)
    {
        //
    }

    public function ulangan($id)
    {
        $id = Crypt::decrypt($id);
        $siswa = Siswa::findorfail($id);
        $kelas = Kelas::findorfail($siswa->kelas_id);
        $jadwal = Jadwal::orderBy('mapels_id')->where('kelas_id', $kelas->id)->get();
        $mapel = $jadwal->groupBy('mapels_id');
        return view('admin.ulangan.show', compact('mapel', 'siswa', 'kelas'));
    }
}
