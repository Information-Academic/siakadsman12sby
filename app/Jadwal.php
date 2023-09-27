<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Jadwal extends Model
{
    //
    protected $table='jadwals';
    protected $fillable = ['haris_id', 'kelas_id', 'mapels_id', 'gurus_id', 'jam_mulai', 'jam_selesai'];

  public function hari()
  {
    return $this->belongsTo('App\Hari','haris_id');
  }

  public function kelas()
  {
    return $this->belongsTo('App\Kelas','kelas_id');
  }

  public function mapel()
  {
    return $this->belongsTo('App\Mapel','mapels_id');
  }

  public function guru()
  {
    return $this->belongsTo('App\Guru','gurus_id');
  }

  public function cekRapot($id)
  {
    $data = json_decode($id, true);
    $rapot = Rapor::where('siswas_id', $data['siswa'])->where('mapels_id', $data['mapel'])->first();
    return $rapot;
  }

  public function rapot($id)
  {
    $kelas = Kelas::where('id', $id)->first();
    return $kelas;
  }

  public function ulangan($id)
  {
    $siswa = Siswa::where('nis', Auth::user()->nis)->first();
    $nilai = Ulangan::where('siswas_id', $siswa->id)->where('mapels_id', $id)->first();
    return $nilai;
  }

  public function nilai($id)
  {
    $siswa = Siswa::where('nis', Auth::user()->nis)->first();
    $nilai = Rapor::where('siswas_id', $siswa->id)->where('mapels_id', $id)->first();
    return $nilai;
  }

  public function cekUlangan($id)
  {
    $data = json_decode($id, true);
    $ulangan = Ulangan::where('siswas_id', $data['siswa'])->where('mapels_id', $data['mapel'])->first();
    return $ulangan;
  }


}
