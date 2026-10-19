<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $approved = DB::table('registrants')
            ->where('status', 'approved')
            ->orderBy('approved_at')
            ->orderBy('id')
            ->get(['id', 'gender', 'kategori_jarak']);

        DB::table('registrants')
            ->where('status', 'approved')
            ->update(['race_number' => null]);

        $sequences = [];
        foreach ($approved as $registrant) {
            $distance = str_starts_with($registrant->kategori_jarak ?? '', '7 Kilometer') ? '7' : '12';
            $sequences[$distance] = ($sequences[$distance] ?? 0) + 1;
            $prefix = $registrant->gender === 'Laki-laki' ? 'M' : 'F';
            $raceNumber = $prefix . $distance . str_pad($sequences[$distance], 4, '0', STR_PAD_LEFT);

            DB::table('registrants')
                ->where('id', $registrant->id)
                ->update(['race_number' => $raceNumber]);
        }
    }

    public function down(): void
    {
        // BIB sebelumnya tidak dapat dipulihkan secara deterministik.
    }
};
