<?php

namespace App\Http\Controllers;

use App\Jadwal;
use App\Hari;
use App\Kelas;
use App\Guru;
use App\Mapel;
use App\Siswa;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
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
        $jadwal = DB::table('jadwals')->where('haris_id', $request->haris_id)->where('kelas_id', $request->kelas_id)->where('mapels_id', $guru->mapels_id)->where('gurus_id', $request->gurus_id)->where('jam_mulai', $request->jam_mulai)->where('jam_selesai', $request->jam_selesai)->get();
        if(count($jadwal) > 0){
            return redirect()->back()->with('warning', 'Data jadwal sudah ada!');
            // return response()->json(['dataExists'=>$jadwal]);
        }
        else{
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $id = Crypt::decrypt($id);
        $kelas = Kelas::findorfail($id);
        $jadwal = Jadwal::OrderBy('haris_id', 'asc')->OrderBy('jam_mulai', 'asc')->where('kelas_id', $id)->get();
        return view('admin.jadwal.show', compact('jadwal', 'kelas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $id = Crypt::decrypt($id);
        $jadwal = Jadwal::findorfail($id);
        $hari = Hari::all();
        $kelas = Kelas::all();
        $guru = Guru::OrderBy('nip', 'asc')->get();
        return view('admin.jadwal.edit', compact('jadwal', 'hari', 'kelas', 'guru'));
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
        $jadwal->haris_id = $request->haris_id;
        $jadwal->kelas_id = $request->kelas_id;
        $jadwal->gurus_id = $request->gurus_id;
        $jadwal->jam_mulai = $request->jam_mulai;
        $jadwal->jam_selesai = $request->jam_selesai;
        $jadwal->save();
        return redirect()->back()->with('success', 'Data jadwal berhasil disunting!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $jadwal = Jadwal::findorfail($id);
        $jadwal->delete();

        return redirect()->back()->with('warning', 'Data jadwal berhasil dihapus!');
    }

    public function jadwalSekarang(Request $request)
    {
        $jadwal = Jadwal::OrderBy('jam_mulai')->OrderBy('jam_selesai')->OrderBy('kelas_id')->where('hari_id', $request->hari)->where('jam_mulai', '<=', $request->jam)->where('jam_selesai', '>=', $request->jam)->get();
        foreach ($jadwal as $val) {
            $newForm[] = array(
                'mapel' => $val->mapels->nama_mapel,
                'kelas' => $val->kelas->kelas,
                'guru' => $val->gurus->nama_guru,
                'jam_mulai' => $val->jam_mulai,
                'jam_selesai' => $val->jam_selesai,
            );
        }
        return response()->json($newForm);
    }

    public function view(Request $request)
    {
        $jadwal = Jadwal::OrderBy('haris_id', 'asc')->OrderBy('jam_mulai', 'asc')->where('kelas_id', $request->id)->get();
        foreach ($jadwal as $val) {
            $newForm[] = array(
                'hari' => $val->hari['nama_hari'],
                'mapel' => $val->mapel['nama_mapel'],
                'kelas' => $val->kelas['kelas'],
                'tipe_kelas' => $val->kelas['tipe_kelas'],
                'guru' => $val->guru['nama_guru'],
                'jam_mulai' => $val->jam_mulai,
                'jam_selesai' => $val->jam_selesai,
            );
        }
        return response()->json($newForm);
    }

    public function guru(){
        $guru = Guru::where('nip', Auth::user()->nip)->first();
        $jadwal = Jadwal::orderBy('haris_id')->OrderBy('jam_mulai')->where('gurus_id', $guru->id)->get();
        return view('guru.jadwal', compact('jadwal', 'guru'));
    }

    public function siswa()
    {
        $siswa = Siswa::where('nis', Auth::user()->nis)->first();
        $kelas = Kelas::findorfail($siswa->kelas_id);
        $jadwal = Jadwal::orderBy('haris_id')->OrderBy('jam_mulai')->where('kelas_id', $kelas->id)->get();
        return view('siswa.jadwal', compact('jadwal', 'kelas', 'siswa'));
    }

    public function cetakJadwal(){
        $siswa = Siswa::where('nis', Auth::user()->nis)->first();
        $kelas = Kelas::findorfail($siswa->kelas_id);
        $jadwal = Jadwal::orderBy('haris_id')->OrderBy('jam_mulai')->where('kelas_id', $kelas->id)->get();
        $pdf = FacadePdf::loadView('siswa.cetakjadwal',['jadwal'=>$jadwal]);
        return $pdf->download('jadwal.pdf');
    }
}
