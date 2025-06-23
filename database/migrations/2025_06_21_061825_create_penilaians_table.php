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
        Schema::create('penilaians', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('guide_id'); // Foreign key ke tabel guides
            $table->unsignedBigInteger('id_pesanan')->nullable(); // <--- pastikan ini ada

            $table->timestamps();

            // Foreign key constraint
            $table->foreign('guide_id')->references('id')->on('guides')->onDelete('cascade');
            $table->foreign('id_pesanan')->references('id')->on('pesanans')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
