<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrants', function (Blueprint $table) {
            $table->string('race_number')->nullable()->change();
        });

        DB::table('registrants')
            ->where('status', '!=', 'approved')
            ->update(['race_number' => null]);
    }

    public function down(): void
    {
        Schema::table('registrants', function (Blueprint $table) {
            $table->string('race_number')->nullable(false)->change();
        });
    }
};
