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
        Schema::create('lib_psgc_cities', function (Blueprint $table) {
            $table->char('city_code', 9)->primary()->unique();
            $table->string('city_name', 60);
            $table->char('prov_code', 9);
            $table->timestamps();

            $table->foreign('prov_code')
                ->references('prov_code')
                ->on('lib_psgc_provinces')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lib_psgc_cities');
    }
};
