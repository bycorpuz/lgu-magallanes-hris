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
        Schema::create('lib_psgc_provinces', function (Blueprint $table) {
            $table->char('prov_code', 9)->primary()->unique();
            $table->string('prov_name', 60);
            $table->char('region_code', 9);
            $table->timestamps();

            $table->foreign('region_code')
                ->references('region_code')
                ->on('lib_psgc_regions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lib_psgc_provinces');
    }
};
