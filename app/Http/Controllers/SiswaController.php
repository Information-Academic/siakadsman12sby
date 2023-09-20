<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\Presensi;
use App\Siswa;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade\Pdf;
class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $kelas = Kelas::OrderBy('kelas', 'asc')-> OrderBy('tipe_kelas','asc')->get();
        return view('admin.siswa.index', compact('kelas'));
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
            'nis' => 'required|string|unique:siswas',
            'nama_siswa' => 'required',
            'jenis_kelamin' => 'required',
        ]);

        if ($request->foto_siswa) {
            $foto = $request->foto_siswa;
            $new_foto = date('siHdmY') . "_" . $foto->getClientOriginalName();
            $foto->move('uploads/siswa/', $new_foto);
            $nameFoto = 'uploads/siswa/' . $new_foto;
        } else {
            if ($request->jenis_kelamin == 'L') {
                $nameFoto = 'uploads/siswa/52471919042020_male.jpg';
            } else {
                $nameFoto = 'uploads/siswa/50271431012020_female.jpg';
            }
        }

        Siswa::create([
            'nis' => $request->nis,
            'nama_siswa' => $request->nama_siswa,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kelas_id' => $request->kelas_id,
            'tipe_kelas' => $request->tipe_kelas,
            'nomor_telepon' => $request->nomor_telepon,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'foto_siswa' => $nameFoto
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan data siswa baru!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $id = Crypt::decrypt($id);
        $siswa = Siswa::findorfail($id);
        return view('admin.siswa.details', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $id = Crypt::decrypt($id);
        $siswa = Siswa::findorfail($id);
        $kelas = Kelas::all();
        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        $this->validate($request, [
            'nama_siswa' => 'required',
            'jenis_kelamin' => 'required',
            'kelas_id' => 'required'
        ]);

        $siswa = Siswa::findorfail($id);
        $user = User::where('nis', $siswa->nis)->first();
        if ($user) {
            $user_data = [
                'nama_depan' => $request->nama_depan,
                'nama_belakang' => $request->nama_belakang,
            ];
            $user->update($user_data);
        }
        $siswa_data = [
            'nis' => $request->nis,
            'nama_siswa' => $request->nama_siswa,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kelas_id' => $request->kelas_id,
            'nomor_telepon' => $request->nomor_telepon,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
        ];
        $siswa->update($siswa_data);
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $siswa = Siswa::findorfail($id);
        $countUser = User::where('nis', $siswa->nis)->count();
        if ($countUser >= 1) {
            $user = User::where('nis', $siswa->nis)->first();
            $siswa->delete();
            $user->delete();
            return redirect()->back()->with('warning', 'Data siswa berhasil dihapus!');
        } else {
            $siswa->delete();
            return redirect()->back()->with('warning', 'Data siswa berhasil dihapus!');
        }
    }

    public function kelas($id)
    {
        $id = Crypt::decrypt($id);
        $siswa = Siswa::where('kelas_id', $id)->OrderBy('nama_siswa', 'asc')->get();
        $kelas = Kelas::findorfail($id);
        return view('admin.siswa.show', compact('siswa', 'kelas'));
    }

    public function ubah_foto($id)
    {
        $id = Crypt::decrypt($id);
        $siswa = Siswa::findorfail($id);
        return view('admin.siswa.ubah-foto', compact('siswa'));
    }

    public function view(Request $request)
    {
        $siswa = Siswa::OrderBy('nama_siswa', 'asc')->where('kelas_id', $request->id)->get();
        foreach ($siswa as $val) {
            $newForm[] = array(
                'kelas' => $val->kelas->kelas,
                'tipe_kelas' => $val->kelas->tipe_kelas,
                'nis' => $val->nis,
                'nama_siswa' => $val->nama_siswa,
                'jenis_kelamin' => $val->jenis_kelamin,
                'alamat' => $val->alamat,
                'tempat_lahir' => $val->tempat_lahir,
                'tanggal_lahir' => $val->tanggal_lahir,
                'foto_siswa' => $val->foto_siswa,
                'status_siswa' => $val->status_siswa
            );
        }

        return response()->json($newForm);
    }

    public function cetak_pdf(Request $request)
    {
        $siswa = Siswa::OrderBy('nama_siswa','asc')->where('kelas_id', $request->id)->get();
        $kelas = Kelas::find($request->id);
        $pdf = PDF::loadView('admin.siswa.siswa-pdf', ['siswa'=>$siswa,'kelas'=>$kelas])->setPaper('A4','portrait');
        return $pdf->stream();
    }

    public function presensi(){
        $siswa = Siswa::all();
        return view('admin.siswa.absen',compact('siswa'));
    }

    public function presensikehadiran($id)
    {
        $id = Crypt::decrypt($id);
        $siswa = Siswa::findorfail($id);
        $absen = Presensi::orderBy('tanggal_absen', 'desc')->where('siswas_id', $id)->get();
        return view('admin.siswa.kehadiran', compact('siswa', 'absen'));
    }

}
