<?php

namespace App\Exports;

use App\Models\Registrant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AcceptedRegistrantsExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private readonly string $distance)
    {
    }

    public function collection()
    {
        return Registrant::query()
            ->where('status', 'approved')
            ->where('kategori_jarak', 'like', $this->distance . ' Kilometer%')
            ->orderByRaw('CAST(SUBSTRING(race_number, -4) AS UNSIGNED) ASC')
            ->orderBy('approved_at')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No. BIB',
            'Nama Lengkap',
            'NIK',
            'Email',
            'HP',
            'Ukuran Jersey',
            'Kategori Jarak',
            'Kategori Peserta',
            'Jenis Kelamin',
            'Tanggal Approve',
            'Status RPC',
            'Waktu Ambil RPC',
        ];
    }

    public function map($registrant): array
    {
        return [
            $registrant->race_number,
            $registrant->name,
            $registrant->nik,
            $registrant->email,
            $registrant->whatsapp ?: $registrant->phone,
            $registrant->jersey_size,
            $registrant->kategori_jarak,
            ucfirst($registrant->kategori ?: '-'),
            $registrant->gender,
            optional($registrant->approved_at)->format('d/m/Y H:i'),
            $registrant->rpc_status === 'sudah_diambil' ? 'Sudah Diambil' : 'Belum Diambil',
            optional($registrant->rpc_collected_at)->format('d/m/Y H:i'),
        ];
    }
}
