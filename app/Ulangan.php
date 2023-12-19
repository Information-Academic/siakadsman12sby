<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ulangan extends Model
{
    //
    protected $table = 'nilais';

    protected $fillable = ['users_id','kelas_id','ulha_1','ulha_2','uts','ulha_3','uas'];

    public function mapel(){
        return $this->belongsTo('App\Mapel','mapels_id');
    }
}
