<?php

namespace App\Http\Controllers;

use App\DetailSoalEssay;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DetailSoalEssaySiswaController extends Controller
{
    //
    public function store(Request $request)
    {
        //
        $save = new DetailSoalEssay();
        $save->saveEssay($request);
        return redirect('/soalsiswa/detail/' . $request->ulangans_id);
    }

    public function edit(DetailSoalEssay $essay)
    {
        //
        return view('guru.soal.essay.ubah_essay',compact('essay'));
    }

    public function update(Request $request, DetailSoalEssay $essay)
    {
        //
        $update = new DetailSoalEssay();
        $update->updateEssay($request,$essay);
        return redirect('soalsiswa/detail/' . $request->ulangans_id);
    }

    public function dataSiswa(Request $request)
    {
      $soal_essays = DetailSoalEssay::where('ulangans_id', $request->ulangans_id);
      return DataTables::of($soal_essays)
        ->editColumn('soal', function ($soal_essays) {
          return $soal_essays->soal ?? '-';
        })
        ->editColumn('nilai', function ($soal_essays) {
            return $soal_essays->nilai ?? '-';
          })
        ->editColumn('status', function ($soal_essays) {
          if ($soal_essays->status == 'Y') {
            return "<center><span class='label label-success'>Tampil</span></center>";
          } elseif ($soal_essays->status == 'N') {
            return "<center><span class='label label-danger'>Tidak Tampil</span></center>";
          } else {
            return '<center>-</center>';
          }
        })
        ->addColumn('action', function ($soal_essays) {
          return '<div style="text-align:center"><a href="../essay/' . $soal_essays->id . '/edit" class="btn btn-success btn-xs">Ubah</a></div>';
        })
        ->rawColumns(['soal', 'nilai', 'status', 'action'])
        ->make(true);
    }
}
