<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DistribusiSoal extends Model
{
    //
    protected $table = 'distribusisoalulangans';
    protected $fillable = ['ulangans_id','kelas_id'];

    public function soal()
    {
  	    return $this->belongsTo('App\Soal', 'ulangans_id');
    }
    public function kelas()
    {
  	    return $this->belongsTo('App\Kelas', 'kelas_id');
    }
    public function jawabUser()
    {
  	    return $this->belongsTo('App\Jawaban', 'ulangans_id', 'ulangans_id');
    }
}
