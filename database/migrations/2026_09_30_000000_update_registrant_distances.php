<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $registrants = DB::table('registrants')
            ->where('kategori_jarak', 'like', '%Kilometer%')
            ->get(['id', 'kategori_jarak', 'race_number']);

        foreach ($registrants as $registrant) {
            $kategoriJarak = str_replace(
                ['5 Kilometer', '10 Kilometer'],
                ['7 Kilometer', '12 Kilometer'],
                $registrant->kategori_jarak
            );

            $raceNumber = preg_replace_callback(
                '/^([MF])(5|10)(\d{4})$/',
                static function (array $matches): string {
                    $distance = $matches[2] === '5' ? '7' : '12';

                    return $matches[1] . $distance . $matches[3];
                },
                $registrant->race_number
            );

            DB::table('registrants')
                ->where('id', $registrant->id)
                ->update([
                    'kategori_jarak' => $kategoriJarak,
                    'race_number' => $raceNumber,
                ]);
        }
    }

    public function down(): void
    {
        $registrants = DB::table('registrants')
            ->where('kategori_jarak', 'like', '%Kilometer%')
            ->get(['id', 'kategori_jarak', 'race_number']);

        foreach ($registrants as $registrant) {
            $kategoriJarak = str_replace(
                ['7 Kilometer', '12 Kilometer'],
                ['5 Kilometer', '10 Kilometer'],
                $registrant->kategori_jarak
            );

            $raceNumber = preg_replace_callback(
                '/^([MF])(7|12)(\d{4})$/',
                static function (array $matches): string {
                    $distance = $matches[2] === '7' ? '5' : '10';

                    return $matches[1] . $distance . $matches[3];
                },
                $registrant->race_number
            );

            DB::table('registrants')
                ->where('id', $registrant->id)
                ->update([
                    'kategori_jarak' => $kategoriJarak,
                    'race_number' => $raceNumber,
                ]);
        }
    }
};
