<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailSoalEssay extends Model
{
    //
    protected $table = 'detailsoalessays';
    protected $fillable = ['soal','status','ulangans_id'];

    public function getJawab()
  {
    return $this->hasOne(JawabanEssay::class, 'detailsoalessays_id', 'id');
  }

  public function userJawab()
  {
    return $this->hasOne(JawabanEssay::class, 'detailsoalessays_id', 'id')->where('users_id', auth()->user()->id);
  }

  public function saveEssay($request)
  {
    $save = new DetailSoalEssay;
    $save->ulangans_id = $request->ulangans_id;
    $save->soal = $request->soal;
    $save->status = $request->status;
    $save->save();
  }

  public function updateEssay($request, $essay)
  {
    $essay->soal = $request->soal;
    $essay->status = $request->status;
    $essay->save();
  }
}
