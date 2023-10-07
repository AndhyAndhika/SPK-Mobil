<?php

namespace App\Exports;

use App\Models\Survey;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SurveyExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return ["ID", "NAMA CUSTOMER", "NO HP CUSTOMER", "K1", "K2", "K3", "K4", "K5", "K6", "K7", "K8", "K9", "K10", "K11", "K12", "K13", "Total Nilai", "Hasil Rekomendasi", "Dibuat", "Dirubah"];
    }

    public function collection()
    {
        return Survey::all();
    }
}
