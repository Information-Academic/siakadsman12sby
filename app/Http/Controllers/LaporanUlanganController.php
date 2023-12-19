<?php

namespace App\Http\Controllers;

use App\DetailSoal;
use App\DetailSoalEssay;
use App\Jawaban;
use App\JawabanEssay;
use App\Kelas;
use App\Siswa;
use App\Soal;
use App\Ulangan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class LaporanUlanganController extends Controller
{
  //
  public function index()
  {
    if (auth()->user()->roles == 'Guru') {
      $user = User::where('id', auth()->user()->id)->first();
      $kelas = Kelas::orderBy('kelas', 'ASC')->orderBy('tipe_kelas', 'ASC')->paginate(20);
      return view('guru.laporan.index', compact('user', 'kelas'));
    } else {
      return redirect()->route('home.index');
    }
  }

  public function detailLaporanSiswa(Request $request)
  {
    if (Auth::user()->roles == 'Guru') {
      $user = User::where('id', auth()->user()->id)->first();
      $siswa = User::where('id', $request->id_user)->first();
      $siswa2 = Siswa::where('nis', $siswa->nis)->first();
      $soal = Soal::select('tipe_ulangan', 'mapels_id')->where('id', $request->id_soal)->first();
      // dd($soal);
      DB::statement("SET SQL_MODE=''");
      $hasil_ujian = Jawaban::select(DB::raw('SUM(jawabans.nilai) as nilaiSiswa'), 'jawabans.created_at', 'jawabans.status','jawabans.ulangans_id')
        ->where('jawabans.users_id', $request->id_user)
        ->where('jawabans.ulangans_id', $request->id_soal)
        ->groupBy('jawabans.nilai','jawabans.ulangans_id')
        ->first();
      $soal_essay = DetailSoalEssay::where('ulangans_id', $request->id_soal)->get();
      $nilai_essay = 0;
      if ($soal_essay->count() > 0) {
        foreach ($soal_essay as $essay) {
          $nilai_essay = $nilai_essay + ($essay->getJawab->nilai ?? 0);
        }
      }
      return view('guru.laporan.detailSiswa', compact('user', 'siswa', 'hasil_ujian', 'soal', 'soal_essay', 'nilai_essay', 'siswa2'));
    } else {
      return redirect()->route('home.index');
    }
  }

  public function hasilSiswa(Request $request)
  {
    $jawabs = Jawaban::where('jawabans.users_id', $request->id_user)->where('jawabans.ulangans_id',$request->id_ulangan);
    return DataTables::of($jawabs)
      ->addColumn('soal', function ($jawabs) {
        if ($jawabs->detailSoal) {
          return $jawabs->detailSoal->soal;
        } else {
          return 'No have question';
        }
      })
      ->addColumn('kunci', function ($jawabs) {
        if ($jawabs->detailSoal) {
          return $jawabs->detailSoal->kunci;
        } else {
          return 'No have question';
        }
      })
      ->rawColumns(['soal'])
      ->make(true);
  }

  public function simpanScore(Request $request)
  {
    $ulangan_id = $request->ulangan_id;
    $essay_id = $request->essay_id;
    $user_id = $request->user_id;
    $siswa_id = $request->siswa_id;
    $nilai = $request->nilai;

    $ulangan = Soal::find($ulangan_id);

    $check_nilai = JawabanEssay::where([
      ['detailsoalessays_id', '=', $essay_id],
      ['users_id', '=', $user_id]
    ])
      ->update(['nilai' => $nilai]);

    if (!$check_nilai) return;

    $nilaiPilgan = Jawaban::where('ulangans_id', $ulangan_id)
      ->where('users_id', $user_id)
      ->sum('nilai');

    $nilaiEssay = DB::table('jawabanessays')
      ->join('detailsoalessays', 'detailsoalessays.id', '=', 'jawabanessays.detailsoalessays_id')
      ->where([
        ['detailsoalessays.ulangans_id', '=', $ulangan_id],
        ['jawabanessays.users_id', '=', $user_id]
      ])
      ->sum('jawabanessays.nilai');

    $nilaiSiswa = Ulangan::where([
        ['siswas_id', '=', $siswa_id],
        ['kelas_id', '=', $request->kelas_id],
        ['mapels_id', '=', $request->mapel_id]
      ])
      ->first();

    $nilaiTotal = $nilaiPilgan + $nilaiEssay;

    if ($nilaiTotal > 100) $nilaiTotal = 100;

    if ($ulangan->tipe_ulangan == 'UH1') {
      $nilaiSiswa->ulha_1 = $nilaiTotal;
    } else if ($ulangan->tipe_ulangan == 'UH2') {
      $nilaiSiswa->ulha_2 = $nilaiTotal;
    } else if ($ulangan->tipe_ulangan == 'UH3') {
      $nilaiSiswa->ulha_3 = $nilaiTotal;
    } else if ($ulangan->tipe_ulangan == 'UTS') {
      $nilaiSiswa->uts = $nilaiTotal;
    } else if ($ulangan->tipe_ulangan == 'UAS') {
      $nilaiSiswa->uas = $nilaiTotal;
    }

    $nilaiSiswa->save();
  }
}
