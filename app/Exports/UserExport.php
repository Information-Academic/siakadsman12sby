<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        $user = User::select('nama_depan','nama_belakang','nama_pengguna','email')->get();
        return $user;
    }
}
