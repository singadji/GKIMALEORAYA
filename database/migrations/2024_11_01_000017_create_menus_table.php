<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_parent')->default(0);
            $table->string('nama_menu');
            $table->string('link_menu')->nullable();
            $table->string('slug')->nullable();
            $table->text('isi_menu')->nullable();
            $table->integer('posisi')->nullable();
            $table->string('publish')->nullable();
            $table->string('gambar')->nullable();
            $table->string('dokumen')->nullable();
            $table->string('video')->nullable();
            $table->string('highlight')->nullable();
            $table->string('uuid')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
