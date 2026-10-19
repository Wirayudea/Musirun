<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('registrants', function (Blueprint $table) {
            // Rename or add WhatsApp field
            if (!Schema::hasColumn('registrants', 'whatsapp')) {
                $table->string('whatsapp')->nullable()->after('phone');
            }

            // Add new fields
            if (!Schema::hasColumn('registrants', 'kategori')) {
                $table->string('kategori')->default('umum')->after('whatsapp'); // pelajar/umum
            }
            if (!Schema::hasColumn('registrants', 'id_type')) {
                $table->string('id_type')->default('KTP')->after('kategori'); // KTP, KK, SIM, KIA, etc
            }
            if (!Schema::hasColumn('registrants', 'kewarganegaraan')) {
                $table->string('kewarganegaraan')->default('Indonesia')->after('id_type');
            }
            if (!Schema::hasColumn('registrants', 'negara')) {
                $table->string('negara')->default('Indonesia')->after('kewarganegaraan');
            }
            if (!Schema::hasColumn('registrants', 'provinsi')) {
                $table->string('provinsi')->nullable()->after('negara');
            }
            if (!Schema::hasColumn('registrants', 'kota')) {
                $table->string('kota')->nullable()->after('provinsi');
            }
            if (!Schema::hasColumn('registrants', 'alamat')) {
                $table->text('alamat')->nullable()->after('kota');
            }
            if (!Schema::hasColumn('registrants', 'emergency_name')) {
                $table->string('emergency_name')->nullable()->after('emergency_phone');
            }
            if (!Schema::hasColumn('registrants', 'emergency_relation')) {
                $table->string('emergency_relation')->nullable()->after('emergency_name');
            }
            if (!Schema::hasColumn('registrants', 'medical_history')) {
                $table->text('medical_history')->nullable()->after('community');
            }
        });
    }

    public function down()
    {
        Schema::table('registrants', function (Blueprint $table) {
            $columns = ['whatsapp', 'kategori', 'id_type', 'kewarganegaraan', 'negara', 'provinsi', 'kota', 'alamat', 'emergency_name', 'emergency_relation', 'medical_history'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('registrants', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
