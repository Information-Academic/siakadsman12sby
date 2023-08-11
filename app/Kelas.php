<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    //
    protected $table = 'kelas';
    protected $fillable = ['kelas', 'tipe_kelas', 'tahun'];

    public function guru()
    {
        return $this->belongsTo('App\Guru');
    }
}
