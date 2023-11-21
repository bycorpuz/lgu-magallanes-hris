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
        Schema::create('lib_signatories', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('user_id');
            $table->string('for');
            $table->uuid('param1_signatory')->nullable();
            $table->uuid('param1_designation')->nullable();
            $table->uuid('param2_signatory')->nullable();
            $table->uuid('param2_designation')->nullable();
            $table->uuid('param3_signatory')->nullable();
            $table->uuid('param3_designation')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('lib_signatories');
    }
};
