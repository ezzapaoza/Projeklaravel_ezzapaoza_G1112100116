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
        Schema::create('alamat_kirims', function (Blueprint $table) {
            Schema::create('alamat_kirims', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->integer('konsumen_id');
                $table->string('nama_penerima');
                $table->string('alamat');
                $table->boolean('is_default');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alamat_kirims');
    }
};
