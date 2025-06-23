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
        Schema::create('subkriterias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kriteria_id')->index('subkriterias_kriteria_id_foreign');
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->integer('profil_standar');
            $table->boolean('is_core_factor')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subkriterias');
    }
};
