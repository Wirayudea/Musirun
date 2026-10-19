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
            $table->timestamp('approved_at')->nullable()->after('status');
            $table->string('rpc_status')->default('belum_diambil')->after('approved_at');
            $table->timestamp('rpc_collected_at')->nullable()->after('rpc_status');
        });

        DB::table('registrants')
            ->where('status', 'approved')
            ->whereNull('approved_at')
            ->update(['approved_at' => DB::raw('updated_at')]);
    }

    public function down(): void
    {
        Schema::table('registrants', function (Blueprint $table) {
            $table->dropColumn(['approved_at', 'rpc_status', 'rpc_collected_at']);
        });
    }
};
