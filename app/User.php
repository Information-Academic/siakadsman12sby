<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_depan', 'nama_belakang', 'nama_pengguna', 'email', 'password','nip','nis','roles'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function guru($id)
    {
        $guru = Guru::where('nip', $id)->first();
        return $guru;
    }

    public function siswa($id)
    {
        $siswa = Siswa::where('nis', $id)->first();
        return $siswa;
    }

    public function getKelas()
    {
        return $this->belongsTo('App\Siswa', 'kelas_id');
    }
}
