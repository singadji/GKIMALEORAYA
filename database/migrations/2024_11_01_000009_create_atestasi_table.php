<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('atestasi', function (Blueprint $table) {
            $table->id('id_atestasi');
            $table->unsignedBigInteger('id_jemaat');
            $table->date('tanggal')->nullable();
            $table->boolean('masuk')->nullable();
            $table->boolean('keluar')->nullable();
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
        Schema::dropIfExists('atestasi');
    }
};
