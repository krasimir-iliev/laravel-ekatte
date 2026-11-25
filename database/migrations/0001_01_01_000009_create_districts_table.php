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
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('region_id');
            $table->string('code', 4)->unique();
            $table->timestamps();
            $table->foreign('region_id')->references('id')->on('regions')
                ->onUpdate('restrict')
                ->onDelete('restrict');
        });

        Schema::create('district_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('district_id');
            $table->string('locale', 10);
            $table->string('name', 64);
            $table->unique(['district_id', 'locale']);
            $table->index(['locale', 'name']);
            $table->foreign('district_id')->references('id')->on('districts')
                ->onUpdate('restrict')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('district_translations');
        Schema::dropIfExists('districts');
    }
};
