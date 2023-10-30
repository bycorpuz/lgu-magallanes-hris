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
        Schema::create('user_personal_informations', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('user_id');
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->string('char', 10)->nullable();
            $table->date('date_of_birth')
                ->nullable()
                ->default('1900-01-01')
                ->where('date_of_birth', '>=', '1900-01-01')
                ->where('date_of_birth', '<=', now());
            $table->string('place_of_birth')->nullable();
            $table->enum('sex', ['male', 'female', 'other'])->default('Male');
            $table->enum('civil_status', ['single', 'married', 'divorced', 'widowed', 'other'])->default('single');
            $table->string('ra_house_no')->nullable();
            $table->string('ra_street')->nullable();
            $table->string('ra_subdivision')->nullable();
            $table->string('ra_brgy_code')->nullable();
            $table->string('ra_zip_code')->nullable();
            $table->string('tel_no')->nullable();
            $table->string('mobile_no')->nullable();
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
        Schema::dropIfExists('user_personal_informations');
    }
};
