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
        Schema::create('lib_salaries', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->integer('tranche');
            $table->integer('grade');
            $table->integer('step');
            $table->decimal('basic', 12, 2)->default('0.00');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lib_salaries');
    }
};
