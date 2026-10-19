<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('registrants', 'rejection_reason')) {
            Schema::table('registrants', function (Blueprint $table) {
                $table->text('rejection_reason')->nullable()->after('approved_at');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('registrants', 'rejection_reason')) {
            Schema::table('registrants', function (Blueprint $table) {
                $table->dropColumn('rejection_reason');
            });
        }
    }
};
