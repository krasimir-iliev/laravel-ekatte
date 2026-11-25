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
        Schema::create('municipalities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('district_id');
            $table->string('code', 5)->unique();
            $table->timestamps();
            $table->foreign('district_id')->references('id')->on('districts')
                ->onUpdate('restrict')
                ->onDelete('restrict');
        });

        Schema::create('municipality_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('municipality_id');
            $table->string('locale', 10);
            $table->string('name', 64);
            $table->unique(['municipality_id', 'locale']);
            $table->index(['locale', 'name']);
            $table->foreign('municipality_id')->references('id')->on('municipalities')
                ->onUpdate('restrict')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('municipality_translations');
        Schema::dropIfExists('municipalities');
    }
};
