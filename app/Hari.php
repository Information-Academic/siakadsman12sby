<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hari extends Model
{
    //
    protected $table = 'haris';
    protected $fillable = ['nama_hari'];

    public function guru(){
        return $this->hasMany('App\Guru','haris_id');
    }
}
