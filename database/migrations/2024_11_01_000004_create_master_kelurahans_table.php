<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_kelurahans', function (Blueprint $table) {
            $table->id('id_kelurahan');
            $table->unsignedBigInteger('id_kecamatan');
            $table->string('kelurahan');
            $table->timestamps();

            $table->foreign('id_kecamatan')->references('id_kecamatan')->on('master_kecamatans')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_kelurahans');
    }
};
