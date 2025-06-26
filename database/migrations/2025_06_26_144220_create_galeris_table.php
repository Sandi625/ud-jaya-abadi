<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('galeris', function (Blueprint $table) {
            $table->id();
            $table->string('judul'); // Judul galeri
            $table->text('deskripsi')->nullable(); // Deskripsi galeri
            $table->string('videolokal')->nullable(); // Lokasi video lokal (path file video)
            $table->string('videoyoutube')->nullable(); // URL YouTube (video YouTube)
            $table->string('foto')->nullable(); // Foto galeri (opsional)
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeris');
    }
};
