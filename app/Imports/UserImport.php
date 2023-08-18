<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class UserImport implements ToModel
{
    public function model(array $row)
    {
        return new User([
            'nama_depan' => $row[0],
            'nama_belakang' => $row[1],
            'nama_pengguna' => $row[2],
            'email' => $row[3],
            'password' => Hash::make($row[4]),
            'roles' => $row[5],
            'nis' => $row[6],
            'nip' => $row[7]
        ]);       
    }
}
