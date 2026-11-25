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
        Schema::create('settlements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('settlement_kind_id');
            $table->unsignedBigInteger('town_hall_id');
            $table->string('ekatte', 5)->unique();
            $table->timestamps();
            $table->foreign('settlement_kind_id')->references('id')->on('settlement_kinds')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('town_hall_id')->references('id')->on('town_halls')
                ->onUpdate('restrict')
                ->onDelete('restrict');
        });

        Schema::create('settlement_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('settlement_id');
            $table->string('locale', 10);
            $table->string('name', 64);
            $table->unique(['settlement_id', 'locale']);
            $table->index(['locale', 'name']);
            $table->foreign('settlement_id')->references('id')->on('settlements')
                ->onUpdate('restrict')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settlement_translations');
        Schema::dropIfExists('settlements');
    }
};
