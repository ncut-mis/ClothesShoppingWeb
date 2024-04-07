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
        Schema::create('combinations_detail',function (Blueprint $table) {
            $table->id();
            $table->integer('combinations_id');
            $table->foreign('combinations_id')->references('id')->on('combinations');
            $table->integer('producted_id');
            $table->foreign('producted_id')->references('id')->on('product');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
