<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_kecamatans', function (Blueprint $table) {
            $table->id('id_kecamatan');
            $table->unsignedBigInteger('id_kota_kabupaten');
            $table->string('kecamatan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_kecamatans');
    }
};
