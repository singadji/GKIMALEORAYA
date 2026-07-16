<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jemaat', function (Blueprint $table) {
            $table->id('id_jemaat');
            $table->string('nia');
            $table->string('nama_jemaat');
            $table->string('gender');
            $table->string('telepon')->nullable();
            $table->string('asal_gereja')->nullable();
            $table->date('tanggal_terdaftar')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->date('tanggal_baptis')->nullable();
            $table->date('tanggal_sidi')->nullable();
            $table->date('tanggal_nikah')->nullable();
            $table->string('status_aktif')->nullable();
            $table->string('status_menikah')->nullable();
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jemaat');
    }
};
