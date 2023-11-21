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
        Schema::create('hr_leave_credits_available_list', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('leave_credits_available_id');
            $table->integer('month')->nullable();
            $table->year('year')->nullable();
            $table->decimal('value', 12, 3)->default('0.000');
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            // Define 'leave_credits_available_id' as a foreign key referencing the 'id' column of the 'hr_leave_credits_available' table
            $table->foreign('leave_credits_available_id')
                ->references('id')
                ->on('hr_leave_credits_available')
                ->onDelete('cascade')
                ->onUpdate('cascade')
                ->name('fk_leave_credits_available_list');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_leave_credits_available_list');
    }
};
