<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Presensi extends Model
{
    //
    protected $table = 'presensis';
    protected $fillable = ['latitude','longitude','distance','users_id'];

    public function guru(){
        return $this->belongsTo('App\Guru','gurus_id');
    }

    public function siswa(){
        return $this->belongsTo('App\Siswa','siswas_id');
    }

    public function kehadiran(){
        return $this->belongsTo('App\Kehadiran','kehadirans_id');
    }

    public function getCreatedAtAtribute(){
        return Carbon::parse($this->attributes['created_at'])
        ->translatedFormat('l, d F Y');
    }

    public function user()
    {
        return $this->belongsTo('App\User','users_id');
    }
}
