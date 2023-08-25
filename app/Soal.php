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
}
