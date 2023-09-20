<?php

namespace App\Http\Controllers;

use App\Guru;
use App\Hari;
use App\Jadwal;
use App\Kelas;
use App\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade\Pdf;
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
                'gurus_id' =>'required'
            ]);
        } else {
            $this->validate($request, [
                'kelas' => 'required|min:1|max:200',
                'tipe_kelas' => 'required|min:3|max:100',
                'tahun' => 'required',
                'status_kelas' => 'required',
                'gurus_id' => 'required'
            ]);
        }

        Kelas::updateOrCreate(
            [
                'id' => $request->kelas_id
            ],
            [
                'kelas' => $request->kelas,
                'tipe_kelas' => $request->tipe_kelas,
                'tahun' => $request->tahun,
                'status_kelas' => $request->status_kelas,
                'gurus_id' =>$request->gurus_id,
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
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $kelas = Kelas::findorfail($id);
        $guru = Guru::all();
        return view('admin.kelas.edit',['kelas'=>$kelas,'guru'=>$guru]);
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
                'status_kelas'=> $val->status_kelas,
                'gurus_id' => $val->gurus_id,
            );
        }
        return response()->json($newForm);
    }

    public function cetak_pdf(Request $request)
    {
        $guru = Guru::OrderBy('nama_guru','asc')->where('mapels_id', $request->id)->get();
        $kelas = Kelas::find($request->id);
        $jadwal = Jadwal::find($request->id);
        $pdf = PDF::loadView('admin.kelas.jadwal-pdf', ['guru'=>$guru,'kelas'=>$kelas,'jadwal'=>$jadwal])->setPaper('A4','portrait');
        return $pdf->stream();
    }
}
