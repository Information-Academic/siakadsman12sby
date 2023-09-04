<?php

namespace App\Imports;
use App\DetailSoal;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class FormatSoalImport implements ToModel
{
    public function model(array $row)
    {
        return new DetailSoal([
            'ulangans_id' => intval($row[0]),
            'soal' => $row[1],
            'pila' => $row[2],
            'pilb' => $row[3],
            'pilc' => $row[4],
            'pild' => $row[5],
            'pile' => $row[6],
            'kunci' => $row[7],
            'nilai' => round($row[8],2),
            'status' => $row[9]
        ]);
    }
}
