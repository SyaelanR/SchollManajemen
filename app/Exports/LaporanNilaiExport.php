<?php

namespace App\Exports;

use App\Models\DaftarNilaiSiswa;
use Maatwebsite\Excel\Concerns\FromCollection;

class LaporanNilaiExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DaftarNilaiSiswa::all();
    }
}
