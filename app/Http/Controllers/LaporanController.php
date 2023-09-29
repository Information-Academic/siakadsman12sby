<?php

namespace App\Http\Controllers;

use App\DetailSoal;
use App\DetailSoalEssay;
use App\Jawaban;
use App\Kelas;
use App\Siswa;
use App\Soal;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
class LaporanController extends Controller
{
    //
    public function index()
    {
    if (Auth()->user()->roles == 'Admin') {
      $user = User::where('id', Auth()->user()->id)->first();
      $kelas = Kelas::orderBy('kelas', 'ASC')->orderBy('tipe_kelas','ASC')->paginate(20);
      return view('admin.laporan.index', compact('user', 'kelas'));
    } else {
      return redirect()->route('home');
    }
    }

    public function detailKelas(Request $request)
    {
      if (Auth()->user()->roles == 'Admin') {
        $user = User::where('id', Auth()->user()->id)->first();
        $kelas = Kelas::where('id', $request->id)->first();
        $jawaban = Jawaban::all();
        return view('admin.laporan.detailKelas', compact('user', 'kelas','jawaban'));
      } else {
        return redirect()->route('home');
      }
    }

    public function data_paket_soal(Request $request)
    {
    $hasils = Jawaban::join('ulangans', 'jawabans.ulangans_id', '=', 'ulangans.id')
      ->select('ulangans.tipe_ulangan', 'jawabans.*')
      ->where('jawabans.ulangans_id', $request->ulangans_id)->get();
    return DataTables::of($hasils)
      ->addColumn('action', function ($hasils) {
        return '<div style="text-align:center"><a href="' . $hasils->ulangans_id . '/paket-soal/' . $hasils->ulangans_id . '" class="btn btn-primary btn-xs">Detail</a></div>';
      })
      ->make(true);
    }

    public function detailPaketSoalPerKelas(Request $request)
    {
      if (Auth()->user()->roles == 'Admin') {
        $user = User::where('id', Auth()->user()->id)->first();
        $kelas = Kelas::where('id', Auth()->user()->id)->first();
        $soal = Soal::where('id', Auth()->user()->id)->first();
        $jawaban = Jawaban::all();
        return view('admin.laporan.detailKelasPaket', compact('user', 'kelas', 'soal','jawaban'));
      } else {
        return redirect()->route('home');
      }
    }

    public function dataKelasPaketSoal(Request $request)
    {
      $jawabs = Jawaban::select('jawabans.*', DB::raw('sum(nilai) as jumlah_nilai'))
        ->where('ulangans_id', $request->ulangans_id)->groupBy('id','nama_depan','nama_belakang','pilihan','nilai','status','ulangans_id','created_at','updated_at')->get();
      return Datatables::of($jawabs)
        ->addColumn('nama_depan', function ($jawabs) {
            return $jawabs->nama_depan;
        })
        ->addColumn('nama_belakang', function ($jawabs) {
            return $jawabs->nama_belakang;
          })
        ->addColumn('jumlah_nilai', function ($jawabs) {
          return $jawabs->jumlah_nilai;
        })
        ->addColumn('action', function ($jawabs) {
          return '<div style="text-align:center"><a href="../../../' . $jawabs->ulangans_id .'" class="btn btn-primary btn-xs">Detail</a></div>';
        })
        ->make(true);
    }

    public function detailLaporanSiswa(Request $request)
    {
      if (Auth()->user()->roles == 'Admin') {
        $user = User::where('id', Auth()->user()->id)->first();
        $siswa = Siswa::where('id', Auth()->user()->id)->first();
        $soal = Soal::select('tipe_ulangan', 'id')->where('id',Auth()->user()->id)->first();
        $hasil_ujian = Jawaban::select(DB::raw('SUM(jawabans.nilai) as jumlah_nilai'),'jawabans.status')
          ->groupBy('id','nama_depan','nama_belakang','pilihan','nilai','status','ulangans_id','created_at','updated_at')
          ->first();
        $soal_essay = DetailSoalEssay::where('ulangans_id', $request->ulangans_id)->get();
        $nilai_essay = 0;
        if ($soal_essay->count() > 0) {
          foreach ($soal_essay as $essay) {
            $nilai_essay = $nilai_essay + ($essay->getJawab->score ?? 0);
          }
        }

        return view('admin.laporan.detailSiswa', compact('user', 'siswa', 'hasil_ujian', 'soal', 'soal_essay', 'nilai_essay'));
      } else {
        return redirect()->route('home');
      }
    }

 public function hasilSiswa(Request $request)
  {
    $jawabs = Jawaban::where('jawabans.ulangans_id', $request->ulangans_id)->get();
    return Datatables::of($jawabs)
      ->addColumn('empty_space', function () {
        return '&nbsp;';
      })
      ->addColumn('dataSoal', function ($jawabs) {
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
      ->rawColumns(['dataSoal'])
      ->make(true);
  }

  public function pdfHasilUjianPersiswa(Request $request)
  {
    $siswa = Siswa::where('id', Auth()->user()->id)->first();
    $jumlah_soal = DetailSoal::where('ulangans_id', $request->soal)->count();
    $soals = Detailsoal::where('ulangans_id', $request->soal)->where('status', 0)->get();
    $jawabs = Jawaban::where('status', 0)->get();
    $jawabBenar = Jawaban::where('status', 0)->get();
    $jawab_first = Jawaban::where('status', 0)->first();
    $jumlah_jawaban_benar = Jawaban::where('status', 0)
      ->select(DB::raw('sum(jawabans.nilai) as jumlahNilai'))
      ->first();
    $pdf = PDF::loadView('admin.laporan.pdf.hasil_ujian', compact('jawabs', 'siswa', 'soals', 'jawabBenar', 'jumlah_jawaban_benar', 'jawab_first', 'jumlah_soal'));
    return $pdf->setPaper('legal')->stream('hasil ujian.pdf');
  }

}
