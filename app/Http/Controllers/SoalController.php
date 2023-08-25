<?php
namespace App\Http\Controllers;

use App\Kelas;
use App\Mapel;
use App\Soal;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
class SoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Auth::user()->roles == 'Admin' || Auth::user()->roles == 'Guru') {
            $user = User::where('id', Auth::user()->id)->first();
            if (Auth::user()->roles == 'Admin') {
              $soals = Soal::join('mapels','mapels.id','=','ulangans.mapels_id')
              ->select('ulangans.*','mapels.nama_mapel')
              ->where('ulangans.users_id', Auth::user()->id)->paginate(5);
            }
            $mapels = Mapel::orderBy('nama_mapel','ASC')->get();
            return view('admin.soal.index', compact('user', 'soals', 'mapels'));
          } else {
            return redirect()->route('home.index');
        }
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Soal  $soal
     * @return \Illuminate\Http\Response
     */
    public function show(Soal $soal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Soal  $soal
     * @return \Illuminate\Http\Response
     */
    public function edit(Soal $soal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Soal  $soal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Soal $soal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Soal  $soal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Soal $soal)
    {
        //
    }

    public function dataSoal()
    {
    if (Auth::user()->roles == 'Guru' || Auth::user()->roles == 'Admin') {
      $soals = Soal::where('users_id', Auth::user()->id)->get();
    } else {
      $soals = Soal::get();
    }
    return DataTables::of($soals)
      ->editColumn('waktu', function ($soals) {
        return $soals->waktu . ' menit';
      })
      ->editColumn('tipe_ulangan', function ($soals) {
        if ($soals->tipe_ulangan == 'UH') {
          return '<center><span class="label label-success">Ulangan Harian</label></center>';
        }
        else if ($soals->tipe_ulangan == 'UTS') {
          return '<center><span class="label label-success">Ulangan Tengah Semester</label></center>';
        }
         else {
          return '<center><span class="label label-info">Ulangan Akhir Semester</label></center>';
        }
      })
      ->editColumn('nama_mapel', function ($soals) {
        return '<div style="text-align:center;">'.$soals->mapel->nama_mapel.'</div>';
      })
      ->addColumn('action', function ($soals) {
        return '<div style="text-align:center"><a href="soal/ubah/' . $soals->id . '" class="btn btn-success btn-xs">Ubah</a> <a href="soal/detail/' . $soals->id . '" class="btn btn-primary btn-xs">Detail</a></div>';
      })
      ->rawColumns(['tipe_ulangan', 'action','nama_mapel'])->make(true);
  }

  public function simpanSoal(Request $request)
  {
    if ($request['tipe_ulangan'] == "") {
      return "Tipe ulangan tidak boleh kosong.";
    } elseif ($request['mapels_id'] == "") {
      return "Nama mapel tidak boleh kosong.";
    } elseif ($request['waktu'] == "") {
      return "Waktu tidak boleh kosong.";
    } else {
      if ($request['tipe_ulangan'] == "UH") {
        if ($request['mapels_id'] == "") {
          return "Nama mapel tidak boleh kosong";
        }
      }
      else if ($request['tipe_ulangan'] == "UTS") {
        if ($request['mapels_id'] == "") {
          return "Nama mapel tidak boleh kosong";
        }
      }
      else if ($request['tipe_ulangan'] == "UAS") {
        if ($request['mapels_id'] == "") {
          return "Nama mapel tidak boleh kosong";
        }
      }
      if ($request['id'] == 'N') {
        $query = new Soal;
        $query->users_id = Auth::user()->id;
      } else {
        $query = Soal::where('id', $request['id'])->first();
      }
      $query->tipe_ulangan = $request['tipe_ulangan'];
      $query->mapels_id = $request['mapels_id'];
      $query->waktu = $request['waktu'];
      $query->save();
      return 'ok';
    }
  }

  public function dataSoalHome()
  {
    if (Auth::user()->roles == 'Guru' || Auth::user()->roles == 'Admin' ) {
      $soals = Soal::where('users_id', Auth::user()->id)->get();
    } else {
      $soals = Soal::get();
    }
    return Datatables::of($soals)
      ->editColumn('waktu', function ($soals) {
        return '<center>' . $soals->waktu . ' menit</center>';
      })
      ->editColumn('tipe_ulangan', function ($soals) {
        if ($soals->tipe_ulangan == 'UH') {
          return '<span class="label label-success">Ulangan Harian</label>';
        } else if ($soals->tipe_ulangan == 'UTS') {
          return '<span class="label label-success">Ulangan Tengah Semester</label>';
        }
        else{
          return '<span class="label label-success">Ulangan Akhir Semester</label>';
        }
      })
      ->addColumn('action', function ($soals) {
        return '<div style="text-align:center"><a href="elearning/soal/ubah/' . $soals->id . '" class="btn btn-success btn-xs">Ubah</a> <a href="elearning/soal/detail/' . $soals->id . '" class="btn btn-primary btn-xs">Detail</a></div>';
      })
      ->rawColumns(['waktu', 'jenis', 'action'])->make(true);
  }

  public function detail(Request $request)
  {
    if (Auth::user()->roles == 'Guru' || Auth::user()->roles == 'Admin') {
      $id_soal = $request->id;
      $user = User::where('id', Auth::user()->id)->first();
      $soal = Soal::where('id', $request->id)->first();
      $soals = Soal::where('id', $request->id)->get();
      $cekDistribusisoal = Soal::get();
      if (count($cekDistribusisoal) > 0) {
        $kelas = Kelas::leftjoin('ulangans', 'kelas.id', '=', 'ulangans.kelas_id')
          ->select('ulangans.id', 'kelas.*')
          ->orderBy('kelas.id', 'ASC')
          ->get();
      } else {
        $kelas = Kelas::get();
      }
      return view('admin.soal.detail', compact('user', 'soal', 'soals', 'kelas', 'id_soal'));
    } else {
      return redirect()->route('home.index');
    }
  }

  public function dataDetailSoal(Request $request)
  {
    // return Input::get('id');
    $soals = Soal::where('id', $request->input('id'))->get();
    return Datatables::of($soals)
      ->editColumn('status', function ($soals) {
        if ($soals->status == 'Y') {
          return "<center><span class='label label-success'>Tampil</span></center>";
        } else {
          return "<center><span class='label label-danger'>Tidak tampil</span></center>";
        }
      })
      ->editColumn('kunci', function ($soals) {
        return '<center>' . $soals->kunci . '</center>';
      })
      ->editColumn('score', function ($soals) {
        return '<center>' . $soals->score . '</center>';
      })
      ->addColumn('action', function ($soals) {
        return '<div style="text-align:center"><a href="ubah/' . $soals->id . '" class="btn btn-success btn-xs">Ubah</a> <a href="data-soal/' . $soals->id . '" class="btn btn-primary btn-xs">Detail</a></div>';
      })
      ->rawColumns(['soal', 'kunci', 'score', 'action', 'status'])
      ->make(true);
  }

  public function terbitSoal(Request $request)
  {
    $cek = Soal::where('id', $request->id)->where('kelas_id', $request->kelas_id)->first();
    if ($cek != "") {
      Soal::where('id', $request->id)->where('kelas_id', $request->kelas_id)->delete();
      return 'N';
    } else {
      $query = new Soal;
      $query->id = $request->id;
      $query->kelas_id = $request->kelas_id;
      $query->save();
      return 'Y';
    }
  }
}
