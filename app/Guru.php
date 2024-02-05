<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    //
    protected $table = 'gurus';

    protected $fillable = ['nip', 'nama_guru', 'no_telepon', 'alamat', 'jenis_kelamin','tempat_lahir','tanggal_lahir','status_guru','status_pegawai','foto','mapels_id'];

    public function mapel()
    {
        return $this->belongsTo('App\Mapel','mapels_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','users_id');
    }
}
