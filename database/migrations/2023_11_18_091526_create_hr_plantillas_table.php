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
        Schema::create('hr_plantillas', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('user_id')->nullable();
            $table->string('item_number');
            $table->uuid('position_id');
            $table->uuid('salary_id');
            $table->string('status');
            $table->text('remarks')->nullable();
            $table->enum('is_plantilla', ['Yes', 'No'])->default('Yes');
            $table->timestamps();

            // Define 'user_id' as a foreign key referencing the 'id' column of the 'users' table
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // Define 'position_id' as a foreign key referencing the 'id' column of the 'lib_positions' table
            $table->foreign('position_id')
                ->references('id')
                ->on('lib_positions')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // Define 'salary_id' as a foreign key referencing the 'id' column of the 'lib_salaries' table
            $table->foreign('salary_id')
                ->references('id')
                ->on('lib_salaries')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_plantillas');
    }
};
