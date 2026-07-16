<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pindah_gereja', function (Blueprint $table) {
            $table->id('id_pindah_gereja');
            $table->unsignedBigInteger('id_jemaat');
            $table->date('tanggal')->nullable();
            $table->string('dari')->nullable();
            $table->string('ke')->nullable();
            $table->string('gereja')->nullable();
            $table->boolean('setuju')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('id_jemaat')->references('id_jemaat')->on('jemaat')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pindah_gereja');
    }
};
