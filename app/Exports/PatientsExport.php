<?php

namespace App\Exports;

use App\Models\Patient;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PatientsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Retrieve the patients' data from the database
        return Patient::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'First Name',
            'Middle Name',
            'Last Name',
            'Maiden Name',
            'Place of Birth',
            'Birthday',
            'Age',
            'Civil Status',
            'Contact Number',
            'Religion',
            'Occupation',
            'Nationality',
            'Husband First Name',
            'Husband Middle Name',
            'Husband Last Name',
            'Husband Occupation',
            'Husband Birthday',
            'Husband Age',
            'Husband Contact Number',
            'Husband Religion',
            'Province',
            'City',
            'Barangay',
            'Gravida',
            'Para',
            'T',
            'P',
            'A',
            'L',
            'Pregnancy No.',
            'Pregnancy Date',
            'AOG',
            'Manner of Delivery',
            'BW',
            'Sex',
            'Present Status',
            'Complications',
            'Medical History',
            'Tetanus Toxoid'
        ];
    }
}
