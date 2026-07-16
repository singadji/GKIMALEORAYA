<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_wilayah', function (Blueprint $table) {
            $table->id('id_group_wilayah');
            $table->string('nama_group_wilayah');
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('koor_group_wilayah')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_wilayah');
    }
};
