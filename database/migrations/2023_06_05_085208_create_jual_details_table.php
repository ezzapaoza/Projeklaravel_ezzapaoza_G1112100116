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
        Schema::create('jual_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('jual_id');
            $table->integer('pizza_id');
            $table->string('nama_pizza');
            $table->integer('qty');
            $table->decimal('harga_satuan');
            $table->decimal('sub_total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jual_details');
    }
};
