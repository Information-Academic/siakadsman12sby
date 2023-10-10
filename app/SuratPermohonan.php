<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuratPermohonan extends Model
{
    //
    protected $table = 'surats';

    protected $fillable = ['kehadirans_id','alasan','users_id'];

    public function kehadiran()
    {
        return $this->belongsTo('App\Kehadiran','kehadirans_id');
    }

    public function user(){
        return $this->belongsTo('App\User','users_id');
    }
}
