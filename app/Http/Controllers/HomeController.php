<?php

namespace App\Http\Controllers;

use App\Guru;
use App\Jadwal;
use App\Kehadiran;
use App\Kelas;
use App\Mapel;
use App\Pengumuman;
use App\Siswa;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $hari = date('w');
        $jam = date('H:i');
        $jadwal = Jadwal::OrderBy('jam_mulai')->OrderBy('jam_selesai')->OrderBy('kelas_id')->where('haris_id', $hari)->where('jam_mulai', '<=', $jam)->where('jam_selesai', '>=', $jam)->get();
        $pengumuman = Pengumuman::orderBy('id','desc')->first();
        return view('home', compact('jadwal', 'pengumuman'));
    }

    public function admin()
    {
        $jadwal = Jadwal::count();
        $guru = Guru::count();
        $gurulk = Guru::where('jenis_kelamin', 'L')->count();
        $gurupr = Guru::where('jenis_kelamin', 'P')->count();
        $siswa = Siswa::count();
        $siswalk = Siswa::where('jenis_kelamin', 'L')->count();
        $siswapr = Siswa::where('jenis_kelamin', 'P')->count();
        $kelas = Kelas::count();
        $kelas_id = Kelas::where('kelas')->count();
        $tipe_kelas = Kelas::where('tipe_kelas')->count();
        $tahun = Kelas::where('tahun')->count();
        $mapel = Mapel::count();
        $user = User::count();
        // $paket = Paket::all();
        return view('admin.index', compact(
            'jadwal',
            'guru',
            'gurulk',
            'gurupr',
            'siswalk',
            'siswapr',
            'siswa',
            'kelas',
            'kelas_id',
            'tipe_kelas',
            'tahun',
            'mapel',
            'user',
            // 'paket'
        ));
    }
}
