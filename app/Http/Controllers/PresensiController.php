<?php

namespace App\Http\Controllers;

use App\Guru;
use App\Kehadiran;
use App\Presensi;
use App\Setting;
use App\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PresensiController extends Controller
{
    //
    public function index()
    {
        $presensi = Presensi::where('users_id', Auth()->user()->id)->get();
        $kehadiran = Kehadiran::all();
        return view('guru.presensi.index', compact('presensi','kehadiran'));
    }

    public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $radius = 6371000; // Radius bumi dalam meter
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;

        $a = sin($dlat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($dlon / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $radius * $c;

        return $distance;
    }

    public function store(Request $request)
    {
    // Validasi data yang diterima
    $request->validate([
        'latitude' => 'required',
        'longitude' => 'required',
    ]);

    $existingPresence = Presensi::where('users_id', Auth()->user()->id)
        ->whereDate('created_at', date('Y-m-d'))
        ->first();
    if($existingPresence){
        return redirect()->route('presensi.index')->with('error', 'Anda sudah melakukan presensi');
    }

    $settings = Setting::first();
    $latSekolah = $settings->latitude;
    $longSekolah = $settings->longitude;

    // Simpan presensi ke database
    $presensi = Presensi::create([
        'users_id' => Auth()->user()->id, // Sesuaikan dengan autentikasi yang Anda gunakan
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
    ]);

    // Hitung jarak dari koordinat yang telah ditentukan (contoh: 0.0, 0.0)
    $distance = $this->calculateDistance(
        $request->latitude,
        $request->longitude,
        floatval($latSekolah), floatval($longSekolah)
    );

    if($request->latitude && $request->longitude > $distance){
        return redirect()->route('presensi.index')->with('error', 'Anda tidak berada di sekolah');
    }

    $presensi->distance = $distance;
    $presensi->save();
    return redirect()->route('presensi.index')->with('success', 'Presensi berhasil disimpan');
    }

    public function siswa()
    {
        $presensi = Presensi::where('users_id', Auth()->user()->id)->get();
        $kehadiran = Kehadiran::all();
        return view('siswa.presensi.siswa', compact('presensi','kehadiran'));
    }

    public function absen(Request $request)
    {
    // Validasi data yang diterima
    $request->validate([
        'latitude' => 'required',
        'longitude' => 'required',
    ]);

    $existingPresence = Presensi::where('users_id', Auth()->user()->id)
        ->whereDate('created_at', date('Y-m-d'))
        ->first();
    if($existingPresence){
        return redirect()->route('presensisiswaharian')->with('error', 'Anda sudah melakukan presensi');
    }

    $settings = Setting::first();
    $latSekolah = $settings->latitude;
    $longSekolah = $settings->longitude;

    // Simpan presensi ke database
    $presensi = Presensi::create([
        'users_id' => Auth()->user()->id, // Sesuaikan dengan autentikasi yang Anda gunakan
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'kehadirans_id' => $request->kehadirans_id,
    ]);

    // Hitung jarak dari koordinat yang telah ditentukan (contoh: 0.0, 0.0)
    $distance = $this->calculateDistance(
        $request->latitude,
        $request->longitude,
        floatval($latSekolah), floatval($longSekolah)
    );

    if($request->latitude && $request->longitude > $distance){
        return redirect()->route('presensisiswaharian')->with('error', 'Anda tidak berada di sekolah');
    }

    $presensi->distance = $distance;
    $presensi->save();
    return redirect()->route('presensisiswaharian')->with('success', 'Presensi berhasil disimpan');
    }

    public function presensikehadiran()
    {
        $absen = Presensi::all();
        return view('admin.kehadiran', compact('absen'));
    }

    public function presensiValid(Request $request){
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $settings = Setting::first();
        $latSekolah = $settings->latitude;
        $longSekolah = $settings->longitude;

        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            floatval($latSekolah), floatval($longSekolah)
        );

        return [
            "valid" => $distance <= 1000,
            "distance" => round($distance / 1000, 2)
        ];
    }

    public function presensiValidSiswa(Request $request){
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $settings = Setting::first();
        $latSekolah = $settings->latitude;
        $longSekolah = $settings->longitude;

        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            floatval($latSekolah), floatval($longSekolah)
        );

        return [
            "valid" => $distance <= 1000,
            "distance" => round($distance / 1000, 2)
        ];
    }
}
