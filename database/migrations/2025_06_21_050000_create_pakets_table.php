<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pakets', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket', 150);
            $table->text('deskripsi_paket')->nullable();
            $table->integer('harga'); // Menggunakan integer tanpa desimal
            $table->string('durasi'); // dalam hari atau jam sesuai kebutuhan
            $table->string('destinasi', 255);
            $table->text('include')->nullable();
            $table->text('exclude')->nullable();
            $table->text('itinerary')->nullable(); // Tambahan kolom itenerary
            $table->text('information_trip')->nullable(); // Tambahan kolom informasi trip
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pakets');
    }
};
