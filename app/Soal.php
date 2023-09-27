<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    //
    protected $table = 'ulangans';
    protected $fillable = ['tipe_ulangan','pilihan_ganda','mapels_id','waktu'];

    public function mapel()
    {
        return $this->belongsTo('App\Mapel','mapels_id');
    }

    public function kelas()
    {
        return $this->belongsTo('App\Kelas','kelas_id');
    }

    public function user()
    {
      return $this->belongsTo('App\User', 'users_id');
    }

    public function jawab()
    {
      return $this->belongsTo('App\Jawaban', 'ulangans_id');
    }

    public function detailSoal()
    {
      return $this->hasMany('App\DetailSoal', 'ulangans_id');
    }

    public function detail_soal_essays()
    {
      return $this->hasMany(DetailSoalEssay::class, 'ulangans_id', 'id');
    }
}
