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
        Schema::create('hr_leave_credits_available', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('leave_type_id');
            $table->uuid('user_id');
            $table->decimal('available', 12, 2);
            $table->decimal('used', 12, 2);
            $table->decimal('balance', 12, 2);
            $table->timestamps();

            // Define 'leave_type_id' as a foreign key referencing the 'id' column of the 'lib_leave_types' table
            $table->foreign('leave_type_id')
                ->references('id')
                ->on('lib_leave_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // Define 'user_id' as a foreign key referencing the 'id' column of the 'users' table
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_leave_credits_available');
    }
};
