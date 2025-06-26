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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('guide_id')->nullable();
            $table->unsignedBigInteger('pesanan_id')->nullable();

            $table->string('name', 100);
            $table->string('email', 100);
            $table->integer('rating')->check('rating >= 1 AND rating <= 5');
            $table->text('isi_testimoni');
            $table->string('photo')->nullable();
            $table->boolean('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('guide_id')->references('id')->on('guides')->onDelete('cascade');
            $table->foreign('pesanan_id')->references('id')->on('pesanans')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review');
    }
};
