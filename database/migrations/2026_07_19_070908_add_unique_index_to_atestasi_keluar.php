<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('atestasi', function (Blueprint $table) {
            $table->unique(['id_jemaat', 'keluar'], 'unique_jemaat_keluar');
        });
    }

    public function down(): void
    {
        Schema::table('atestasi', function (Blueprint $table) {
            $table->dropUnique('unique_jemaat_keluar');
        }
        );
    }
};