<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    //
    protected $table = 'siswas';
    
    protected $fillable = ['nis','nama_siswa','alamat','jenis_kelamin','nomor_telepon','tempat_lahir','tanggal_lahir','foto_siswa','status_siswa','kelas_id'];

    public function kelas(){   
        return $this->belongsTo('App\Kelas','kelas_id');
    }
}
