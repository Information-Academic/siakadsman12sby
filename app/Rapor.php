<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rapor extends Model
{
    //
    protected $table = 'rapors';

    protected $fillable = ['siswas_id', 'kelas_id', 'gurus_id', 'mapels_id', 'nilai_rapor','kkm_nilai','catatan'];

    public function kehadiran()
    {
        return $this->belongsTo('App\Kehadiran','kehadirans_id');
    }
}
