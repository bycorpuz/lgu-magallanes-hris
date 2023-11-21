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
        Schema::create('hr_leaves', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('tracking_code');
            $table->uuid('leave_type_id');
            $table->uuid('user_id');
            $table->decimal('days', 12, 3)->default('0.000');
            $table->date('date_from');
            $table->date('date_to');
            $table->enum('is_with_pay', ['Yes', 'No'])->default('Yes');
            $table->enum('status', ['Approved', 'Disapproved', 'Cancelled', 'Processing', 'Pending'])->default('Pending');
            $table->text('remarks')->nullable();
            $table->date('date_approved')->nullable();
            $table->date('date_disapproved')->nullable();
            $table->date('date_cancelled')->nullable();
            $table->date('date_processing')->nullable();
            $table->enum('details_b1', ['Yes', 'No', 'N/A'])->default('N/A');
            $table->string('details_b1_name')->nullable();
            $table->enum('details_b2', ['Yes', 'No', 'N/A'])->default('N/A');
            $table->string('details_b2_name')->nullable();
            $table->string('details_b3_name')->nullable();
            $table->enum('details_b4', ['Yes', 'No', 'N/A'])->default('N/A');
            $table->enum('details_b5', ['Yes', 'No', 'N/A'])->default('N/A');
            $table->enum('details_d1', ['Yes', 'No', 'N/A'])->default('No');
            $table->timestamps();

            // Define 'leave_type_id' as a foreign key referencing the 'id' column of the 'users' table
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
        Schema::dropIfExists('hr_leaves');
    }
};
