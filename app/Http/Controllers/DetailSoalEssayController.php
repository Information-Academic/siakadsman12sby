<?php

namespace App\Http\Controllers;

use App\DetailSoalEssay;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
class DetailSoalEssayController extends Controller
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
        $save = new DetailSoalEssay();
        $save->saveEssay($request);
        return redirect('/soal/detail/' . $request->ulangans_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DetailSoalEssay  $detailSoalEssay
     * @return \Illuminate\Http\Response
     */
    public function show(DetailSoalEssay $detailSoalEssay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DetailSoalEssay  $detailSoalEssay
     * @return \Illuminate\Http\Response
     */
    public function edit(DetailSoalEssay $essay)
    {
        //
        return view('guru.soal.essay.edit',compact('essay'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DetailSoalEssay  $detailSoalEssay
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DetailSoalEssay $essay)
    {
        //
        $update = new DetailSoalEssay();
        $update->updateEssay($request,$essay);
        return redirect('soal/detail/' . $request->ulangans_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DetailSoalEssay  $detailSoalEssay
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailSoalEssay $detailSoalEssay)
    {
        //
    }

    public function data(Request $request)
    {
      $soal_essays = DetailSoalEssay::where('ulangans_id', $request->ulangans_id);
      return Datatables::of($soal_essays)
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
