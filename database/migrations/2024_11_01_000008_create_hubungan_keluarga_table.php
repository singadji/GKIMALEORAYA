<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hubungan_keluarga', function (Blueprint $table) {
            $table->id('id_hub_kel');
            $table->unsignedBigInteger('id_kk_jemaat');
            $table->unsignedBigInteger('id_jemaat');
            $table->string('hubungan_keluarga');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('id_kk_jemaat')->references('id_kk_jemaat')->on('kk_jemaat')->nullOnDelete();
            $table->foreign('id_jemaat')->references('id_jemaat')->on('jemaat')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hubungan_keluarga');
    }
};
