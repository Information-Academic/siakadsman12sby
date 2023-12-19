<?php
namespace App\Http\Controllers;

use App\DetailSoal;
use App\DistribusiSoal;
use App\Kelas;
use App\Mapel;
use App\Soal;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FormatSoalImport;
use App\Ulangan;
use Illuminate\Support\Facades\DB;

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
        if (Auth::user()->roles == 'Admin') {
            $user = User::where('id', Auth::user()->id)->first();
            if (Auth::user()->roles == 'Admin') {
              $soals = Soal::join('mapels','mapels.id','=','ulangans.mapels_id')
              ->select('ulangans.*','mapels.nama_mapel')
              ->where('ulangans.users_id', Auth::user()->id)->paginate(5);
            }
            $mapels = Mapel::orderBy('nama_mapel','ASC')->get();
            $tahunPembuatan = Soal::select('created_at')->groupBy('created_at')->get();
            return view('admin.soal.index', compact('user', 'soals', 'mapels','tahunPembuatan'));
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
        if ($soals->tipe_ulangan == 'UH1') {
          return '<center><span class="label label-success">Ulangan Harian 1</label></center>';
        }
        else if ($soals->tipe_ulangan == 'UH2') {
            return '<center><span class="label label-success">Ulangan Harian 2</label></center>';
        }
        else if ($soals->tipe_ulangan == 'UH3') {
            return '<center><span class="label label-success">Ulangan Harian 3</label></center>';
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
      if ($request['tipe_ulangan'] == "UH1") {
        if ($request['mapels_id'] == "") {
          return "Nama mapel tidak boleh kosong";
        }
      }
      else if ($request['tipe_ulangan'] == "UH2") {
        if ($request['mapels_id'] == "") {
          return "Nama mapel tidak boleh kosong";
        }
      }
      else if ($request['tipe_ulangan'] == "UH3") {
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
        if ($soals->tipe_ulangan == 'UH1') {
          return '<span class="label label-info">Ulangan Harian 1</label>';
        }
        else if ($soals->tipe_ulangan == 'UH2') {
            return '<span class="label label-info">Ulangan Harian 2</label>';
        }
        else if ($soals->tipe_ulangan == 'UH3') {
            return '<span class="label label-info">Ulangan Harian 3</label>';
        }
        else if ($soals->tipe_ulangan == 'UTS') {
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

  public function ubahSoal(Request $request)
  {
    if (Auth::user()->roles == 'Guru' || Auth::user()->roles == 'Admin') {
      $soal = Soal::where('id', $request->id)->first();
      $user = User::where('id', Auth::user()->id)->first();
      $mapels = Mapel::orderBy('nama_mapel')->get();
      return view('guru.soal.form.ubah', compact('user', 'soal', 'mapels'));
    } else {
      return redirect()->route('home.index');
    }
  }

  public function ubahDetailSoal(Request $request)
  {
    if (Auth::user()->roles == 'Guru' || Auth::user()->roles == 'Admin') {
      $ulangans_id = $request->id;
      $user = User::where('id', Auth::user()->id)->first();
      $soal = DetailSoal::where('id', $request->id)->first();
      return view('admin.soal.form.ubah', compact('user', 'soal', 'ulangans_id'));
    } else {
      return redirect()->route('home.index');
    }
  }

  public function detail(Request $request)
  {
    if (Auth::user()->roles == 'Admin') {
      $ulangans_id = $request->id;
      $user = User::where('id', Auth::user()->id)->first();
      $soal = Soal::where('id', $request->id)->first();
      $soals = DetailSoal::where('ulangans_id', $request->id)->get();
      $cekDistribusisoal = DistribusiSoal::get();
      if (count($cekDistribusisoal) > 0) {
        $kelas = Kelas::leftjoin('distribusisoalulangans', 'kelas.id', '=', 'distribusisoalulangans.kelas_id')
          ->select('distribusisoalulangans.ulangans_id', 'kelas.*')
          ->orderBy('kelas.id','ASC')
          ->groupBy('kelas.id','kelas.kelas','kelas.tipe_kelas','kelas.tahun','kelas.status_kelas','kelas.gurus_id','kelas.created_at','kelas.updated_at','distribusisoalulangans.ulangans_id')
          ->get();
      } else {
        $kelas = Kelas::get();
      }
      return view('admin.soal.detail', compact('user', 'soal', 'soals', 'kelas', 'ulangans_id'));
    } else {
      return redirect()->route('home.index');
    }
  }

  public function dataDetailSoal(Request $request)
  {
    // return Input::get('id');
    $soals = DetailSoal::where('ulangans_id', $request->input('id'))->get();
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
      ->editColumn('nilai', function ($soals) {
        return '<center>' . $soals->nilai . '</center>';
      })
      ->addColumn('action', function ($soals) {
        return '<div style="text-align:center"><a href="ubah/' . $soals->id . '" class="btn btn-success btn-xs">Ubah</a> <a href="data-soal/' . $soals->id . '" class="btn btn-primary btn-xs">Detail</a></div>';
      })
      ->rawColumns(['soal', 'kunci', 'nilai', 'action', 'status'])
      ->make(true);
  }

  public function detailDataSoal(Request $request)
  {
    if (Auth::user()->roles == 'Guru' || Auth::user()->roles == 'Admin') {
      $ulangans_id = $request->id;
      $user = User::where('id', Auth::user()->id)->first();
      $soal = DetailSoal::where('id', $request->id)->first();
      return view('admin.soal.detailSoal', compact('user', 'soal', 'ulangans_id'));
    } else {
      return redirect()->route('home.index');
    }
  }


  public function terbitSoal(Request $request)
  {
    $cek = DistribusiSoal::where('ulangans_id', $request->ulangans_id)->where('kelas_id', $request->kelas_id)->first();
    if ($cek != "") {
      DistribusiSoal::where('ulangans_id', $request->ulangans_id)->where('kelas_id', $request->kelas_id)->delete();
      return 'N';
    } else {
      $query = new DistribusiSoal();
      $query->ulangans_id = $request->ulangans_id;
      $query->kelas_id = $request->kelas_id;
      $query->save();
      return 'Y';
    }
  }

  public function simpanDetailSoal(Request $request)
  {
    if ($request->soal == "") {
      return "Soal tidak boleh kosong.";
    } elseif ($request->kunci == "") {
      return "Kunci jawaban soal tidak boleh kosong.";
    } elseif ($request->nilai == "") {
      return "Nilai soal tidak boleh kosong.";
    } elseif ($request->status == "") {
      return "Status soal tidak boleh kosong.";
    } else {
      if ($request->id == 'N') {
        $query = new DetailSoal();
        $query->ulangans_id = $request->ulangans_id;
        $query->users_id = Auth::user()->id;
      } else {
        $query = DetailSoal::where('id', $request->id)->first();
      }
      $query->soal = $request->soal;
      $query->pila = $request->pila;
      $query->pilb = $request->pilb;
      $query->pilc = $request->pilc;
      $query->pild = $request->pild;
      $query->pile = $request->pile;
      $query->kunci = $request->kunci;
      $query->nilai = $request->nilai;
      $query->status = $request->status;
      $query->save();
      return 'ok';
    }
  }

  public function simpanDetailSoalExcel(Request $request)
  {
    $baris = 1;
    $sukses = 0;
    $gagal = 0;
    $kesalahan = '';
    if ($request->hasFile('file')) {
      $path = $request->file('file')->getRealPath();
      $data = Excel::import(new FormatSoalImport, $path);
      foreach ($data as $data_arr) {
        foreach ($data_arr as $key => $value) {
          $jumlah = $key;
          if ($value->ulangans_id == '') {
            if ($kesalahan) {
              $kesalahan = $kesalahan . '<br>- Kode soal kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
            } else {
              $kesalahan = $kesalahan . '- Kode soal kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
            }
            return view('admin.soal.hasil_upload_via_excel', compact('sukses', 'gagal', 'jumlah', 'kesalahan'));
          } elseif ($value->soal == '') {
            if ($kesalahan) {
              $kesalahan = $kesalahan . '<br>- Soal kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
            } else {
              $kesalahan = $kesalahan . '- Soal kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
            }
            return view('admin.soal.hasil_upload_via_excel', compact('sukses', 'gagal', 'jumlah', 'kesalahan'));
          } elseif ($value->kunci == '') {
            if ($kesalahan) {
              $kesalahan = $kesalahan . '<br>- Pilihan jawaban kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
            } else {
              $kesalahan = $kesalahan . '- Pilihan jawaban kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
            }
            return view('admin.soal.hasil_upload_via_excel', compact('sukses', 'gagal', 'jumlah', 'kesalahan'));
          } elseif ($value->nilai == '') {
            if ($kesalahan) {
              $kesalahan = $kesalahan . '<br>- Score kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
            } else {
              $kesalahan = $kesalahan . '- Score kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
            }
            return view('admin.soal.hasil_upload_via_excel', compact('sukses', 'gagal', 'jumlah', 'kesalahan'));
          }
          $query = new DetailSoal;
          $query->ulangans_id = $value->ulangans_id;
          $query->soal = $value->soal;
          $query->pila = $value->pila;
          $query->pilb = $value->pilb;
          $query->pilc = $value->pilc;
          $query->pild = $value->pild;
          $query->pile = $value->pile;
          $query->kunci = $value->kunci;
          $query->nilai = $value->nilai;
          $query->status = 'Y';
          $query->users_id = Auth::user()->id;
          if ($query->save()) {
            $sukses = $sukses + 1;
          }
        }
      }
      return view('admin.soal.index', compact('sukses', 'gagal', 'kesalahan'));
    } else {
      return redirect()->route('soal');
    }
  }

  public function saveEssay(Request $request)
  {
    return $request;
  }

  public function soalUlangan(){
    if (Auth::user()->roles == 'Guru') {
        $user = User::where('id', Auth::user()->id)->first();
        if (Auth::user()->roles == 'Guru') {
          $soals = Soal::join('mapels','mapels.id','=','ulangans.mapels_id')
          ->select('ulangans.*','mapels.nama_mapel')
          ->where('ulangans.users_id', Auth::user()->id)->paginate(5);
        }
        $mapels = Mapel::orderBy('nama_mapel','ASC')->get();
        $tahunPembuatan = Soal::select('created_at')->groupBy('created_at')->get();
        return view('guru.soal.index', compact('user', 'soals', 'mapels','tahunPembuatan'));
      } else {
        return redirect()->route('home.index');
    }
  }

  public function dataSoalSiswa()
    {
    if (Auth::user()->roles == 'Guru') {
      $soals = Soal::where('users_id', Auth::user()->id)->get();
    } else {
      $soals = Soal::get();
    }
    return DataTables::of($soals)
      ->editColumn('waktu', function ($soals) {
        return $soals->waktu . ' menit';
      })
      ->editColumn('tipe_ulangan', function ($soals) {
        if ($soals->tipe_ulangan == 'UH1') {
          return '<center><span class="label label-success">Ulangan Harian 1</label></center>';
        }
        else if ($soals->tipe_ulangan == 'UH2') {
            return '<center><span class="label label-success">Ulangan Harian 2</label></center>';
        }
        else if ($soals->tipe_ulangan == 'UH3') {
            return '<center><span class="label label-success">Ulangan Harian 3</label></center>';
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
        return '<div style="text-align:center"><a href="ubah/' . $soals->id . '" class="btn btn-success btn-xs">Ubah</a> <a href="detail/' . $soals->id . '" class="btn btn-primary btn-xs">Detail</a></div>';
      })
      ->rawColumns(['tipe_ulangan', 'action','nama_mapel'])->make(true);
  }

  public function simpanDetailSoalSiswaExcel(Request $request)
  {
    $baris = 1;
    $sukses = 0;
    $gagal = 0;
    $kesalahan = '';
    if ($request->hasFile('file')) {
      $path = $request->file('file')->getRealPath();
      $data = Excel::import(new FormatSoalImport, $path);
      foreach ($data as $data_arr) {
        foreach ($data_arr as $key => $value) {
          $jumlah = $key;
          if ($value->ulangans_id == '') {
            if ($kesalahan) {
              $kesalahan = $kesalahan . '<br>- Kode soal kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
            } else {
              $kesalahan = $kesalahan . '- Kode soal kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
            }
            return view('guru.soal.hasil_upload_via_excel', compact('sukses', 'gagal', 'jumlah', 'kesalahan'));
          } elseif ($value->soal == '') {
            if ($kesalahan) {
              $kesalahan = $kesalahan . '<br>- Soal kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
            } else {
              $kesalahan = $kesalahan . '- Soal kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
            }
            return view('guru.soal.hasil_upload_via_excel', compact('sukses', 'gagal', 'jumlah', 'kesalahan'));
          } elseif ($value->kunci == '') {
            if ($kesalahan) {
              $kesalahan = $kesalahan . '<br>- Pilihan jawaban kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
            } else {
              $kesalahan = $kesalahan . '- Pilihan jawaban kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
            }
            return view('guru.soal.hasil_upload_via_excel', compact('sukses', 'gagal', 'jumlah', 'kesalahan'));
          } elseif ($value->nilai == '') {
            if ($kesalahan) {
              $kesalahan = $kesalahan . '<br>- Score kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
            } else {
              $kesalahan = $kesalahan . '- Score kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
            }
            return view('guru.soal.hasil_upload_via_excel', compact('sukses', 'gagal', 'jumlah', 'kesalahan'));
          }
          $query = new DetailSoal;
          $query->ulangans_id = $value->ulangans_id;
          $query->soal = $value->soal;
          $query->pila = $value->pila;
          $query->pilb = $value->pilb;
          $query->pilc = $value->pilc;
          $query->pild = $value->pild;
          $query->pile = $value->pile;
          $query->kunci = $value->kunci;
          $query->nilai = $value->nilai;
          $query->status = 'Y';
          $query->users_id = Auth::user()->id;
          if ($query->save()) {
            $sukses = $sukses + 1;
          }
        }
      }
      return view('guru.soal.index', compact('sukses', 'gagal', 'kesalahan'));
    } else {
      return redirect()->route('soal');
    }
  }

  public function simpanSoalSiswa(Request $request)
  {
    if ($request['tipe_ulangan'] == "") {
      return "Tipe ulangan tidak boleh kosong.";
    } elseif ($request['mapels_id'] == "") {
      return "Nama mapel tidak boleh kosong.";
    } elseif ($request['waktu'] == "") {
      return "Waktu tidak boleh kosong.";
    } else {
      if ($request['tipe_ulangan'] == "UH1") {
        if ($request['mapels_id'] == "") {
          return "Nama mapel tidak boleh kosong";
        }
      }
      else if ($request['tipe_ulangan'] == "UH2") {
        if ($request['mapels_id'] == "") {
          return "Nama mapel tidak boleh kosong";
        }
      }
      else if ($request['tipe_ulangan'] == "UH3") {
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
  public function ubahSoalSiswa(Request $request)
  {
    if (Auth::user()->roles == 'Guru') {
      $soal = Soal::where('id', $request->id)->first();
      $user = User::where('id', Auth::user()->id)->first();
      $mapels = Mapel::orderBy('nama_mapel')->get();
      return view('guru.soal.ubah_soal_siswa', compact('user', 'soal', 'mapels'));
    } else {
      return redirect()->route('home.index');
    }
  }

  public function detailSoalSiswa(Request $request)
  {
    if (Auth::user()->roles == 'Guru') {
      $ulangans_id = $request->id;
      $user = User::where('id', Auth::user()->id)->first();
      $soal = Soal::where('id', $request->id)->first();
      $soals = DetailSoal::where('ulangans_id', $request->id)->get();
      $cekDistribusisoal = DistribusiSoal::get();
      if (count($cekDistribusisoal) > 0) {
        DB::statement("SET SQL_MODE=''");
        $kelas = Kelas::leftjoin('distribusisoalulangans', 'kelas.id', '=', 'distribusisoalulangans.kelas_id')
          ->select('distribusisoalulangans.ulangans_id', 'kelas.*')
          ->orderBy('kelas.id','ASC')
          ->groupBy('kelas.id')
          ->get();
      } else {
        $kelas = Kelas::get();
      }
      return view('guru.soal.detail', compact('user', 'soal', 'soals', 'kelas', 'ulangans_id'));
    } else {
      return redirect()->route('home.index');
    }
  }

  public function dataDetailSoalSiswa(Request $request)
  {
    // return Input::get('id');
    $soals = DetailSoal::where('ulangans_id', $request->input('id'))->get();
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
      ->editColumn('nilai', function ($soals) {
        return '<center>' . $soals->nilai . '</center>';
      })
      ->addColumn('action', function ($soals) {
        return '<div style="text-align:center"><a href="ubah/' . $soals->id . '" class="btn btn-success btn-xs">Ubah</a> <a href="data-soal/' . $soals->id . '" class="btn btn-primary btn-xs">Detail</a></div>';
      })
      ->rawColumns(['soal', 'kunci', 'nilai', 'action', 'status'])
      ->make(true);
  }

  public function simpanDetailSoalSiswa(Request $request)
  {
    if ($request->soal == "") {
      return "Soal tidak boleh kosong.";
    } elseif ($request->kunci == "") {
      return "Kunci jawaban soal tidak boleh kosong.";
    } elseif ($request->nilai == "") {
      return "Nilai soal tidak boleh kosong.";
    } elseif ($request->status == "") {
      return "Status soal tidak boleh kosong.";
    } else {
      if ($request->id == 'N') {
        $query = new DetailSoal();
        $query->ulangans_id = $request->ulangans_id;
        $query->users_id = Auth::user()->id;
      } else {
        $query = DetailSoal::where('id', $request->id)->first();
      }
      $query->soal = $request->soal;
      $query->pila = $request->pila;
      $query->pilb = $request->pilb;
      $query->pilc = $request->pilc;
      $query->pild = $request->pild;
      $query->pile = $request->pile;
      $query->kunci = $request->kunci;
      $query->nilai = $request->nilai;
      $query->status = $request->status;
      $query->save();
      return 'ok';
    }
  }

  public function ubahDetailSoalSiswa(Request $request)
  {
    if (Auth::user()->roles == 'Guru') {
      $ulangans_id = $request->id;
      $user = User::where('id', Auth::user()->id)->first();
      $soal = DetailSoal::where('id', $request->id)->first();
      return view('guru.soal.ubah_detail_soal_ulangan', compact('user', 'soal', 'ulangans_id'));
    } else {
      return redirect()->route('home.index');
    }
  }

  public function detailDataSoalSiswa(Request $request)
  {
    if (Auth::user()->roles == 'Guru') {
      $ulangans_id = $request->id;
      $user = User::where('id', Auth::user()->id)->first();
      $soal = DetailSoal::where('id', $request->id)->first();
      return view('guru.soal.detailSoal', compact('user', 'soal', 'ulangans_id'));
    } else {
      return redirect()->route('home.index');
    }
  }

  public function terbitSoalSiswa(Request $request)
  {
    $cek = DistribusiSoal::where('ulangans_id', $request->ulangans_id)->where('kelas_id', $request->kelas_id)->first();
    if ($cek != "") {
      DistribusiSoal::where('ulangans_id', $request->ulangans_id)->where('kelas_id', $request->kelas_id)->delete();
      return 'N';
    } else {
      $query = new DistribusiSoal();
      $query->ulangans_id = $request->ulangans_id;
      $query->kelas_id = $request->kelas_id;
      $query->save();
      return 'Y';
    }
  }

}
