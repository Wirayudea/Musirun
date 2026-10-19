<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registrant extends Model
{
    use HasFactory;

    protected $table = 'registrants';

    public static function generateRaceNumber($gender, $kategori_jarak): string
    {
        $prefix = $gender === 'Laki-laki' ? 'M' : 'F';
        $distance = str_starts_with($kategori_jarak, '7 Kilometer') ? '7' : '12';

        // Gender has its own prefix, but sequence numbers are shared per distance.
        $usedNumbers = self::whereNotNull('race_number')
            ->where('kategori_jarak', 'like', $distance . ' Kilometer%')
            ->pluck('race_number')
            ->map(function (string $raceNumber) use ($distance): ?int {
                if (!preg_match('/^[MF]' . preg_quote($distance, '/') . '(\d{4})$/', $raceNumber, $matches)) {
                    return null;
                }

                return (int) $matches[1];
            })
            ->filter()
            ->flip();

        for ($sequence = 1; $sequence <= 9999; $sequence++) {
            if (!$usedNumbers->has($sequence)) {
                return $prefix . $distance . str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
            }
        }

        throw new \OverflowException("Nomor BIB untuk kategori {$distance} Kilometer sudah habis.");
    }

    protected static function boot()
    {
        parent::boot();
    }

    protected $fillable = [
        'race_number',
        'name',
        'nik',
        'email',
        'dob',
        'gender',
        'blood_type',
        'phone',
        'whatsapp',
        'emergency_phone',
        'emergency_name',
        'emergency_relation',
        'jersey_size',
        'community',
        'kategori_jarak',
        'kategori',
        'id_type',
        'kewarganegaraan',
        'negara',
        'provinsi',
        'kota',
        'alamat',
        'medical_history',
        'payment_proof_path',
        'agreed',
        'status',
        'approved_at',
        'rejection_reason',
        'rpc_status',
        'rpc_collected_at',
    ];

    protected $casts = [
        'agreed' => 'boolean',
        'dob' => 'date',
        'approved_at' => 'datetime',
        'rpc_collected_at' => 'datetime',
    ];
}
