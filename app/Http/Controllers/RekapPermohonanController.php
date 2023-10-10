<?php

namespace App\Http\Controllers;

use App\SuratPermohonan;
use Illuminate\Http\Request;

class RekapPermohonanController extends Controller
{
    //
    public function index(){
        $suratPermohonan = SuratPermohonan::all();
        return view('admin.rekappermohonan.index',compact('suratPermohonan'));
    }
}
