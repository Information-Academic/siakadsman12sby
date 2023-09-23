<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ulangan extends Model
{
    //
    protected $table = 'nilais';

    protected $fillable = ['siswas_id','kelas_id','gurus_id','mapels_id','ulha_1','ulha_2','uts','ulha_3','uas'];
}
