<?php

namespace App\Http\Controllers;

use App\DetailSoal;
use App\DetailSoalEssay;
use App\DistribusiSoal;
use App\Guru;
use App\Jawaban;
use App\JawabanEssay;
use App\Kehadiran;
use App\Kelas;
use App\Mapel;
use App\Nilai;
use App\Presensi;
use App\Rapor;
use App\Siswa;
use App\Soal;
use App\SuratPermohonan;
use App\Ulangan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $kelas2 = Kelas::OrderBy('kelas','asc')->distinct()->get(['kelas']);
        $kelas3 = Kelas::orderBy('tipe_kelas','asc')->distinct()->get(['tipe_kelas']);
        return view('admin.siswa.index', compact('kelas','kelas2','kelas3'));
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

        if ($request->foto) {
            $foto = $request->foto;
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
            'foto' => $nameFoto
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
            'nis' => 'required',
            'nama_siswa' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'kelas_id' => 'required',
            'nomor_telepon' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
        ]);

        $siswa = Siswa::findorfail($id);
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

    public function update_foto(Request $request, $id)
    {
        $this->validate($request, [
            'foto' => 'required'
        ]);

        $siswa = Siswa::findorfail($id);
        $foto = $request->foto;
        $new_foto = date('s' . 'i' . 'H' . 'd' . 'm' . 'Y') . "_" . $foto->getClientOriginalName();
        $siswa_data = [
            'foto' => 'uploads/siswa/' . $new_foto,
        ];
        $foto->move('uploads/siswa/', $new_foto);
        $siswa->update($siswa_data);

        return redirect()->route('siswa.index')->with('success', 'Berhasil merubah foto!');
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
                'foto' => $val->foto,
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

    public function presensiSiswa()
    {
        $presensi = Presensi::where('tanggal_absen', date('d-m-Y'))->get();
        $kehadiran = Kehadiran::limit(4)->get();
        return view('siswa.presensi', compact('presensi','kehadiran'));
    }

    public function simpan(Request $request)
    {
        $this->validate($request, [
            'nis' => 'required',
            'status_kehadiran' => 'required'
        ]);
        $cekSiswa = Siswa::where('nis', $request->nis)->count();
        if ($cekSiswa >= 1) {
            $siswa = Siswa::where('nis', $request->nis)->first();
            if ($siswa->nis == Auth::user()->nis) {
                $cekAbsen = Presensi::where('siswas_id', $siswa->id)->where('tanggal_absen', date('d-m-Y'))->count();
                if ($cekAbsen == 0) {
                    if (date('w') != '0' && date('w') != '6') {
                        if (date('H:i:s') >= '06:00:00') {
                            if (date('H:i:s') >= '09:00:00') {
                                if (date('H:i:s') >= '16:15:00') {
                                    Presensi::create([
                                        'tanggal_absen' => date('d-m-Y'),
                                        'siswas_id' => $siswa->id,
                                        'kehadirans_id' => '4',
                                    ]);
                                    return redirect()->back()->with('info', 'Maaf sekarang sudah waktunya pulang!');
                                } else {
                                    if ($request->kehadirans_id == '1') {
                                        $terlambat = date('H') - 9 . ' Jam ' . date('i') . ' Menit';
                                        if (date('H') - 9 == 0) {
                                            $terlambat = date('i') . ' Menit';
                                        }
                                        Presensi::create([
                                            'tanggal_absen' => date('d-m-Y'),
                                            'siswas_id' => $siswa->id,
                                            'kehadirans_id' => '5',
                                        ]);
                                        return redirect()->back()->with('warning', 'Maaf anda terlambat ' . $terlambat . '!');
                                    } else {
                                        Presensi::create([
                                            'tanggal_absen' => date('d-m-Y'),
                                            'siswas_id' => $siswa->id,
                                            'kehadirans_id' => $request->kehadirans_id,
                                        ]);
                                        return redirect()->back()->with('success', 'Anda hari ini berhasil presensi!');
                                    }
                                }
                            } else {
                                Presensi::create([
                                    'tanggal_absen' => date('Y-m-d'),
                                    'siswas_id' => $siswa->id,
                                    'kehadirans_id' => $request->kehadirans_id,
                                ]);
                                return redirect()->back()->with('success', 'Anda hari ini berhasil presensi tepat waktu!');
                            }
                        } else {
                            return redirect()->back()->with('info', 'Maaf presensi di mulai jam 6 pagi!');
                        }
                    } else {
                        $namaHari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu"];
                        $d = date('w');
                        $hari = $namaHari[$d];
                        return redirect()->back()->with('info', 'Maaf sekolah hari ' . $hari . ' libur!');
                    }
                } else {
                    return redirect()->back()->with('warning', 'Maaf presensi tidak bisa dilakukan 2x!');
                }
            } else {
                return redirect()->back()->with('error', 'Maaf nomor induk siswa ini bukan milik anda!');
            }
        } else {
            return redirect()->back()->with('error', 'Maaf nomor induk siswa ini tidak terdaftar!');
        }


    }

    public function ujian()
    {
    $user = User::where('id', Auth()->user()->id)->first();
    $distribusi = DistribusiSoal::all();
    $kelas = Kelas::all();
    // dd($kelas2);
    return view('halaman-siswa.ujian', compact('user', 'distribusi','kelas'));
    }

    public function detailUjian($id)
    {
    $check_soal = DistribusiSoal::all();
    if ($check_soal) {
      $soal = Soal::with('detail_soal_essays')->where('id', $id)->first();
      $soals = DetailSoal::where('ulangans_id', $id)->where('status', 'Y')->get();
      $kelas = Kelas::all();
      return view('halaman-siswa.detail_ujian', compact('soal', 'soals','kelas'));
    }
    }

    public function getDetailEssay(Request $request)
    {
    $soal_essay = DetailSoalEssay::with('userJawab')->find($request->detailsoalessays_id);
    return view('halaman-siswa.get_soal_essay', compact('soal_essay'));
    }

    public function simpanJawabanEssay(Request $request)
    {
    if ($request->jawab == '' || $request->jawab == null) {
      return '';
    }
    $check_jawaban = JawabanEssay::where('users_id', Auth::user()->id)->where('detailsoalessays_id', $request->detailsoalessays_id)->first();
    if (!$check_jawaban) {
      $save = new JawabanEssay;
      $save->detailsoalessays_id = $request->detailsoalessays_id;
      $save->users_id = auth()->user()->id;
    } else {
      $save = $check_jawaban;
    }
    $save->jawab = $request->jawab;
    if ($save->save()) {
      return 1;
    }
  }

  public function getSoal($id)
  {
    $soal = DetailSoal::find($id);
    return view('halaman-siswa.get_soal', compact('soal'));
  }

  public function kirimJawaban(Request $request)
  {
    $jawaban = Jawaban::where('ulangans_id', $request->id_soal)->where('users_id', Auth::user()->id)->update(['status' => 1]);
  }

  public function jawab(Request $request)
  {
    $get_jawab = explode('/', $request->get_jawab);
    $pilihan = $get_jawab[0];
    $id_detail_soal = $get_jawab[1];
    $id_siswa = $get_jawab[2];
    $detail_soal = DetailSoal::find($id_detail_soal);
    $jawab = Jawaban::where('ulangans_id', $id_detail_soal)->where('users_id', Auth::user()->id)->first();

    if (!$jawab) {
      $jawab = new Jawaban();
    }
    $jawab->id = $id_detail_soal;
    $jawab->ulangans_id = $detail_soal->ulangans_id;
    $jawab->users_id = Auth::user()->id;
    $jawab->kelas_id = Auth::user()->kelas_id;
    $jawab->nama_depan = auth()->user()->nama_depan;
    $jawab->nama_belakang = auth()->user()->nama_belakang;
    $jawab->pilihan = $pilihan;

    $check_jawaban = DetailSoal::where('id', $id_detail_soal)->where('kunci', $pilihan)->first();
    if ($check_jawaban) {
      $jawab->nilai = $detail_soal->nilai;
    } else {
      $jawab->nilai = 0;
    }
    $jawab->status = 0;
    $jawab->save();
    return 1;
  }

  public function finishUjian(Request $request, $id)
  {
    $soal = Soal::find($id);
    $siswa = Siswa::where('nis',Auth::user()->nis)->first();
    $kelas = Kelas::find($siswa->kelas_id);
    $guru = Guru::where('nip', Auth::user()->nip)->first();
    $nilai = Jawaban::where('ulangans_id', $id)->where('users_id',Auth::user()->id)->sum('nilai');
    DB::statement("SET SQL_MODE=''");
    // UPDATE jawabanessays
    // JOIN detailsoalessays on detailsoalessays.id = jawabanessays.detailsoalessays_id
    // SET nilai = ()
    // WHERE jawabanessays.users_id = 11 detailsoalessays.ulangans_id = 1;
    DB::table('jawabanessays')
        ->join('detailsoalessays', 'detailsoalessays.id', '=', 'jawabanessays.detailsoalessays_id')
        ->where([
            ['detailsoalessays.ulangans_id', '=', $id],
            ['jawabanessays.users_id', '=', Auth::user()->id]
        ])
        ->update([
            'jawabanessays.nilai' =>
                DB::raw('(SELECT nilai FROM detailsoalessays WHERE detailsoalessays.id = jawabanessays.detailsoalessays_id)')
        ]);
    // SELECT SUM(jawabanessays.nilai)
    // FROM jawabanessays
    // JOIN detailsoalessays
    //     ON detailsoalessays.id = jawabanessays.detailsoalessays_id
    // WHERE jawabanessays.users_id = 11
    // AND
    // detailsoalessays.ulangans_id = 1;
    $nilaiEssay = DB::table('jawabanessays')
        ->join('detailsoalessays', 'detailsoalessays.id', '=', 'jawabanessays.detailsoalessays_id')
        ->where([
            ['detailsoalessays.ulangans_id', '=', $id],
            ['jawabanessays.users_id', '=', Auth::user()->id]
        ])
        ->sum('jawabanessays.nilai');

    $nilaiSiswa = Ulangan::where('siswas_id', $request->siswas_id)->where('kelas_id', $request->kelas_id)->where('mapels_id',$request->mapels_id)->first();
    if($nilaiSiswa!=null){
        $nilaiSiswa->siswas_id = $siswa->id;
        $nilaiSiswa->mapels_id = $soal->mapels_id;
        $nilaiSiswa->kelas_id = $kelas->id;
        if($soal->tipe_ulangan=='UH1'){
            $nilaiSiswa->ulha_1 = $nilai + $nilaiEssay;
            if ($nilaiSiswa->ulha_1 > 100) {
                $nilaiSiswa->ulha_1 = 100;
            }
        }
        if($soal->tipe_ulangan=='UH2'){
            $nilaiSiswa->ulha_2 = $nilai + $nilaiEssay;
            if ($nilaiSiswa->ulha_2 > 100) {
                $nilaiSiswa->ulha_2 = 100;
            }
        }
        if($soal->tipe_ulangan=='UH3'){
            $nilaiSiswa->ulha_3 = $nilai + $nilaiEssay;
            if ($nilaiSiswa->ulha_3 > 100) {
                $nilaiSiswa->ulha_3 = 100;
            }
        }
        if($soal->tipe_ulangan=='UTS'){
            $nilaiSiswa->uts = $nilai + $nilaiEssay;
            if ($nilaiSiswa->uts > 100) {
                $nilaiSiswa->uts = 100;
            }
        }
        if($soal->tipe_ulangan=='UAS'){
            $nilaiSiswa->uas = $nilai + $nilaiEssay;
            if ($nilaiSiswa->uas > 100) {
                $nilaiSiswa->uas = 100;
            }
        }
        $nilaiSiswa->save();
    }
    else{
        $nilaiSiswa = Ulangan::updateOrCreate([
            'siswas_id' => $siswa->id,
        ],
        [
            'kelas_id' => $kelas->id,
        ],
        [
            'mapels_id' => $soal->mapels_id,
        ]
    );
        $nilaiSiswa->siswas_id = $siswa->id;
        $nilaiSiswa->mapels_id = $soal->mapels_id;
        $nilaiSiswa->kelas_id = $kelas->id;
        if($soal->tipe_ulangan=='UH1'){
            $nilaiSiswa->ulha_1 = $nilai + $nilaiEssay;
            if ($nilaiSiswa->ulha_1 > 100) {
                $nilaiSiswa->ulha_1 = 100;
            }
        }
        if($soal->tipe_ulangan=='UH2'){
            $nilaiSiswa->ulha_2 = $nilai + $nilaiEssay;
            if ($nilaiSiswa->ulha_2 > 100) {
                $nilaiSiswa->ulha_2 = 100;
            }
        }
        if($soal->tipe_ulangan=='UH3'){
            $nilaiSiswa->ulha_3 = $nilai + $nilaiEssay;
            if ($nilaiSiswa->ulha_3 > 100) {
                $nilaiSiswa->ulha_3 = 100;
            }
        }
        if($soal->tipe_ulangan=='UTS'){
            $nilaiSiswa->uts = $nilai + $nilaiEssay;
            if ($nilaiSiswa->uts > 100) {
                $nilaiSiswa->uts = 100;
            }
        }
        if($soal->tipe_ulangan=='UAS'){
            $nilaiSiswa->uas = $nilai + $nilaiEssay;
            if ($nilaiSiswa->uas > 100) {
                $nilaiSiswa->uas = 100;
            }
        }
        $nilaiSiswa->save();
    }
    return view('halaman-siswa.finish', compact('soal', 'nilai','nilaiSiswa','nilaiEssay'));
  }

  public function suratPermohonan(){
    $kehadiran = Kehadiran::all();
    return view('siswa.suratpermohonan', compact('kehadiran'));
  }

  public function suratPermohonanSiswaStore(Request $request){

    $existingPresence = SuratPermohonan::where('users_id', Auth()->user()->id)
    ->whereDate('created_at', date('Y-m-d'))
    ->first();
    if($existingPresence){
        return redirect()->route('statussiswa.siswa')->with('error', 'Anda sudah membuat surat permohonan');
    }
    $kehadiran = SuratPermohonan::create([
        'kehadirans_id' => $request->kehadirans_id,
        'alasan' => $request->alasan,
        'users_id' => Auth()->user()->id, // Sesuaikan dengan autentikasi yang Anda gunakan
    ]);
    $kehadiran->save();
    return redirect()->route('statussiswa.siswa')->with('success', 'Berhasil mengajukan surat permohonan!');
}

public function statusSiswa(){
    $siswa = Siswa::where('nis',Auth::user()->nis)->get();
    $status = SuratPermohonan::where('users_id',Auth::user()->id)->get();
    return view('siswa.status', compact('status','siswa'));
}
}
