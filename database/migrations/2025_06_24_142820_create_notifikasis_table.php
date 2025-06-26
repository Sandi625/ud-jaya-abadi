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
    Schema::create('notifikasis', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('guide_id');
        $table->text('isi');
        $table->dateTime('tanggal_kirim')->nullable();
        $table->enum('status', ['notif belum terkirim', 'notif pending masih di proses', 'notif sudah terkirim']);
        $table->timestamps();

        $table->foreign('guide_id')->references('id')->on('guides')->onDelete('cascade');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasis');
    }
};
