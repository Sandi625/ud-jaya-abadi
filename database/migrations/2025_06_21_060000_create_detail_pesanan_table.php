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
    Schema::create('detail_pesanan', function (Blueprint $table) {
        $table->id();

        $table->foreignId('pesanan_id')->constrained('pesanans')->onDelete('cascade');
        $table->foreignId('kriteria_id')->constrained('kriterias')->onDelete('cascade');
        $table->foreignId('guide_id')->nullable()->constrained('guides')->onDelete('cascade');
        $table->integer('prioritas')->nullable();


        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan');
    }
};
