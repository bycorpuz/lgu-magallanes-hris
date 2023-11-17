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
        Schema::create('lib_leave_types', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('abbreviation', 10)->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->decimal('days', 12, 3);
            $table->string('unit')->nullable();
            $table->enum('is_with_pay', ['yes', 'no'])->default('yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lib_leave_types');
    }
};
