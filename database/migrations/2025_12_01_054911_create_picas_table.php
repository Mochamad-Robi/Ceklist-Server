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
    Schema::create('picas', function (Blueprint $table) {
        $table->id();
        $table->date('tanggal');
        $table->text('masalah');
        $table->text('screen')->nullable(); // atau bisa pakai string untuk path file
        $table->text('akar_penyebab');
        $table->text('tindakan_perbaikan');
        $table->text('screen_2')->nullable(); // screen kedua
        $table->date('waktu_penyelesaian');
        $table->text('pencegahan');
        $table->string('pic'); // Person In Charge
        $table->string('status')->default('Open'); // Open/Close
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('picas');
    }

};
