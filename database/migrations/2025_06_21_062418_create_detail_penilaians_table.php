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
        Schema::create('detail_penilaians', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('penilaian_id')->index('detail_penilaians_penilaian_id_foreign');
            $table->unsignedBigInteger('subkriteria_id')->index('detail_penilaians_subkriteria_id_foreign');
            $table->integer('nilai');
            $table->unsignedBigInteger('detail_pesanan_id')->nullable();
            $table->foreign('detail_pesanan_id')->references('id')->on('detail_pesanan')->onDelete('set null');
            $table->string('sumber')->default('admin'); // atau bisa pakai boolean 'is_from_customer'



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penilaians');
    }
};
