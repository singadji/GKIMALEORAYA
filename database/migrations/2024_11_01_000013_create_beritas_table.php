<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beritas', function (Blueprint $table) {
            $table->id('id_berita');
            $table->unsignedBigInteger('id_kategori')->nullable();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('judul');
            $table->text('isi');
            $table->string('gambar')->nullable();
            $table->string('publish')->nullable();
            $table->boolean('isslider')->nullable();
            $table->integer('baca')->nullable();
            $table->string('slug')->nullable();
            $table->string('link_youtube')->nullable();
            $table->string('uuid')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
