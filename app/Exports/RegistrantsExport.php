<?php

namespace App\Exports;

use App\Models\Registrant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RegistrantsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Registrant::all();
    }

    public function headings(): array
    {
        return [
            'No. Peserta',
            'Nama',
            'NIK',
            'Email',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Golongan Darah',
            'No. HP',
            'No. HP Darurat',
            'Ukuran Jersey',
            'Komunitas',
            'Kategori Jarak',
            'Status',
            'Tanggal Daftar'
        ];
    }

    public function map($registrant): array
    {
        return [
            $registrant->race_number,
            $registrant->name,
            $registrant->nik,
            $registrant->email,
            $registrant->dob,
            $registrant->gender,
            $registrant->blood_type,
            $registrant->phone,
            $registrant->emergency_phone,
            $registrant->jersey_size,
            $registrant->community,
            $registrant->kategori_jarak,
            $registrant->status,
            $registrant->created_at->format('d/m/Y H:i')
        ];
    }
}
