<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JawabanEssay extends Model
{
    //
    protected $table = 'jawabanessays';

    protected $fillable = ['jawab','nilai','detailsoalessays_id','users_id'];
}
