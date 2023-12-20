<?php

namespace App\Http\Controllers;

use App\Guru;
use App\Jadwal;
use App\JawabanEssay;
use App\Kelas;
use App\Rapor;
use App\Siswa;
use App\SuratPermohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class RaporController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $guru = Guru::where('nip', Auth::user()->nip)->first();
        $jadwal = Jadwal::where('gurus_id', $guru->id)->orderBy('kelas_id')->get();
        $kelas = $jadwal->groupBy('kelas_id');
        return view('guru.rapor.kelas', compact('kelas', 'guru'));
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
        return view('admin.rapor.home', compact('kelas'));
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
        $cekJadwal = Jadwal::where('gurus_id', $guru->id)->where('kelas_id', $request->kelas_id)->count();
        if ($cekJadwal >= 1) {
            Rapor::create(
                [
                    'id' => $request->id
                ],
                [
                    'siswas_id' => $request->siswas_id,
                    'kelas_id' => $request->kelas_id,
                    'gurus_id' => $request->gurus_id,
                    'mapels_id' => $guru->mapels_id,
                    'kkm_nilai' => $request->kkm_nilai,
                    'nilai_rapor' => $request->nilai_rapor,
                    'catatan' => $request->catatan
                ]
            );
            return response()->json(['success' => 'Nilai rapor siswa berhasil ditambahkan!']);
        } else {
            return response()->json(['error' => 'Maaf guru ini tidak mengajar kelas ini!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rapor  $rapor
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        //
        $id = Crypt::decrypt($id);
        $guru = Guru::where('nip', Auth::user()->nip)->first();
        $kelas = Kelas::findorfail($id);
        $siswa = Siswa::where('kelas_id', $id)->get();
        $rapor = Rapor::where('siswas_id',$id)->get();
        return view('guru.rapor.rapor', compact('guru', 'kelas', 'siswa','rapor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rapor  $rapor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $id = Crypt::decrypt($id);
        $kelas = Kelas::findorfail($id);
        $siswa = Siswa::orderBy('nama_siswa')->where('kelas_id', $id)->get();
        return view('admin.rapor.index', compact('kelas', 'siswa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rapor  $rapor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rapor $rapor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rapor  $rapor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rapor $rapor)
    {
        //
    }

    public function rapor($id)
    {
        $id = Crypt::decrypt($id);
        $siswa = Siswa::findorfail($id);
        $kelas = Kelas::findorfail($siswa->kelas_id);
        $jadwal = Jadwal::orderBy('mapels_id')->where('kelas_id', $kelas->id)->get();
        $mapel = $jadwal->groupBy('mapels_id');
        return view('admin.rapor.show', compact('mapel', 'siswa', 'kelas'));
    }

    public function siswa()
    {
        $siswa = Siswa::where('nis', Auth::user()->nis)->first();
        $kelas = Kelas::findorfail($siswa->kelas_id);
        $jadwal = Jadwal::where('kelas_id', $kelas->id)->orderBy('mapels_id')->get();
        $mapel = $jadwal->groupBy('mapels_id');
        $rapor = Rapor::where('siswas_id', $siswa->id)->get();
        DB::statement("SET SQL_MODE=''");
        $surat = SuratPermohonan::select(DB::raw('count(surats.kehadirans_id) AS kehadiranSiswa,kehadirans.keterangan'))
        ->join('kehadirans','kehadirans.id','=','surats.kehadirans_id')
        ->where('surats.users_id', Auth::user()->id)
        ->where('kehadirans.keterangan','=','Sakit')
        ->orderBy('kehadirans.keterangan','ASC')
        ->groupBy('kehadirans.keterangan');

        $surat2 = SuratPermohonan::select(DB::raw('count(surats.kehadirans_id) AS hadirSiswa,kehadirans.keterangan'))
        ->join('kehadirans','kehadirans.id','=','surats.kehadirans_id')
        ->where('surats.users_id', Auth::user()->id)
        ->where('kehadirans.keterangan','=','Izin')
        ->orderBy('kehadirans.keterangan','ASC')
        ->groupBy('kehadirans.keterangan');
        // dd($surat2);

        return view('siswa.rapor', compact('siswa', 'kelas', 'mapel','rapor','surat','surat2'));
    }

    public function detailRaporSiswa($id){
        $id = Crypt::decrypt($id);
        $siswa = Siswa::where('nis', Auth::user()->nis)->first();
        $kelas = Kelas::findorfail($siswa->kelas_id);
        $jadwal = Jadwal::where('kelas_id', $kelas->id)->orderBy('mapels_id')->get();
        $mapel = $jadwal->groupBy('mapels_id');
        return view('siswa.detailrapor', compact('siswa','kelas','mapel'));
    }

    public function catatan(Request $request){
        if($request->siswas_id != null){
            $rapor = Rapor::where('siswas_id', $request->siswas_id)->first();
            if($rapor != null){
                $rapor->catatan = $request->catatan;
                $rapor->save();
                return response()->json(['success' => 'Catatan berhasil diubah!']);
            }else{
                $rapor = new Rapor();
                $rapor->siswas_id = $request->siswas_id;
                $rapor->catatan = $request->catatan;
                $rapor->save();
                return response()->json(['success' => 'Catatan berhasil ditambahkan!']);
            }
        }
    }

    public function kesimpulan(Request $request){
        if($request->siswas_id != null){
            $rapor = Rapor::where('siswas_id', $request->siswas_id)->first();
            if($rapor != null){
                $rapor->kesimpulan = $request->kesimpulan;
                $rapor->save();
                return response()->json(['success' => 'Kesimpulan berhasil diubah!']);
            }else{
                $rapor = new Rapor();
                $rapor->siswas_id = $request->siswas_id;
                $rapor->kesimpulan = $request->kesimpulan;
                $rapor->save();
                return response()->json(['success' => 'Kesimpulan berhasil ditambahkan!']);
            }
        }
    }

    public function cetakRapor(){
        $siswa = Siswa::where('nis', Auth::user()->nis)->first();
        $kelas = Kelas::findorfail($siswa->kelas_id);
        $nilai = Rapor::orderBy('mapels_id')->OrderBy('nilai_rapor')->where('kelas_id',$kelas->id)->get();
        $pdf = FacadePdf::loadView('siswa.cetakrapor',['nilai'=>$nilai]);
        // dd($nilai);
        return $pdf->download('nilai.pdf');
    }
}
