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
        Schema::create('jurnals', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_transaksi');
            $table->foreignId('akun_id')->constrained()->cascadeOnDelete();
            $table->integer('nominal');
            $table->string('keterangan', 30);
            $table->enum('tipe_transaksi', ['d', 'k']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnals');
    }
};
