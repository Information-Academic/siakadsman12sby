<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    //
    protected $table = 'presensis';
    protected $fillable = ['tanggal_absen','titik_lokasi','status_kehadiran'];

    public function guru(){
        return $this->belongsTo('App\Guru','gurus_id');
    }

    public function siswa(){
        return $this->belongsTo('App\Siswa','siswas_id');
    }
}
