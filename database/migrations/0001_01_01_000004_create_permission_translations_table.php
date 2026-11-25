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
        $tableNames = config('permission.table_names');

        Schema::create('permission_translations', function (Blueprint $table) use ($tableNames) {
            $table->id();
            $table->unsignedBigInteger('permission_id');
            $table->string('locale', 10);
            $table->string('display_name');
            $table->unique(['permission_id', 'locale']);
            $table->index(['locale', 'display_name']);
            $table->foreign('permission_id')->references('id')->on($tableNames['permissions'])
                ->onUpdate('restrict')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_translations');
    }
};
