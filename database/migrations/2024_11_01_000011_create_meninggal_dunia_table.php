<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meninggal_dunia', function (Blueprint $table) {
            $table->id('id_meninggal_dunia');
            $table->unsignedBigInteger('id_jemaat');
            $table->date('tanggal')->nullable();
            $table->text('alamat')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('id_jemaat')->references('id_jemaat')->on('jemaat')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meninggal_dunia');
    }
};
