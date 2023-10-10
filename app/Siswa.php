<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Siswa extends Model
{
    //
    protected $table = 'siswas';

    protected $fillable = ['nis','nama_siswa','alamat','jenis_kelamin','nomor_telepon','tempat_lahir','tanggal_lahir','foto_siswa','status_siswa','kelas_id'];

    public function kelas(){
        return $this->belongsTo('App\Kelas','kelas_id');
    }

    public function ulangan($id)
    {
        $guru = Guru::where('nip', Auth::user()->nip)->first();
        $nilai = Ulangan::where('siswas_id', $id)->where('gurus_id', $guru->id)->first();
        return $nilai;
    }

    public function nilai($id)
    {
        $guru = Guru::where('nip', Auth::user()->nip)->first();
        $nilai = Rapor::where('siswas_id', $id)->where('gurus_id', $guru->id)->first();
        return $nilai;
    }
}
