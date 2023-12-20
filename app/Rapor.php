<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Rapor extends Model
{
    //
    protected $table = 'rapors';

    protected $fillable = ['siswas_id', 'kelas_id', 'gurus_id', 'mapels_id', 'nilai_rapor','kkm_nilai','catatan','kesimpulan'];

    public function kehadiran()
    {
        return $this->belongsTo('App\Kehadiran','kehadirans_id');
    }

    public function mapel(){
        return $this->belongsTo('App\Mapel','mapels_id');
    }

    public function nilai($id)
    {
        $guru = Guru::where('nip', Auth::user()->nip)->first();
        $nilai = Rapor::where('siswas_id', $id)->where('gurus_id', $guru['id'])->first();
        return $nilai;
    }
}
