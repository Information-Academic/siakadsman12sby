<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DetailSoal extends Model
{
    //
    protected $table = "detailulangans";
    protected $fillable = ['ulangans_id','soal','pila','pilb','pilc','pild','pile','kunci','nilai','status'];

    public function checkJawab()
	{
		return $this->belongsTo('App\Jawaban', 'id', 'ulangans_id')->where('users_id', Auth::user()->id);
	}
}
