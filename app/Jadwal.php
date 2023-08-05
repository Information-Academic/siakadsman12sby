<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    //
    protected $table='jadwals';
    protected $fillable = ['haris_id', 'kelas_id', 'mapels_id', 'gurus_id', 'jam_mulai', 'jam_selesai'];

  public function hari()
  {
    return $this->belongsTo('App\Hari');
  }

  public function kelas()
  {
    return $this->belongsTo('App\Kelas');
  }

  public function mapel()
  {
    return $this->belongsTo('App\Mapel')->withDefault();
  }

  public function guru()
  {
    return $this->belongsTo('App\Guru')->withDefault();
  }

}
