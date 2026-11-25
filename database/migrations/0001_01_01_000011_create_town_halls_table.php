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
        Schema::create('town_halls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('municipality_id');
            $table->string('code', 8)->unique();
            $table->timestamps();
            $table->foreign('municipality_id')->references('id')->on('municipalities')
                ->onUpdate('restrict')
                ->onDelete('restrict');
        });

        Schema::create('town_hall_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('town_hall_id');
            $table->string('locale', 10);
            $table->string('name', 64);
            $table->unique(['town_hall_id', 'locale']);
            $table->index(['locale', 'name']);
            $table->foreign('town_hall_id')->references('id')->on('town_halls')
                ->onUpdate('restrict')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('town_hall_translations');
        Schema::dropIfExists('town_halls');
    }
};
