<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
    protected $table = 'settings';

    protected $fillable = ['nama_sekolah','alamat_sekolah','latitude','longitude'];
}
