<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    //
    protected $table = 'jawabans';
    protected $fillable = ['pilihan','nilai','status','ulangans_id','users_id','kelas_id'];

    public function user()
  {
    return $this->belongsTo('App\User', 'users_id');
  }
  public function detailSoal()
  {
    return $this->belongsTo('App\DetailSoal', 'ulangans_id');
  }
}
