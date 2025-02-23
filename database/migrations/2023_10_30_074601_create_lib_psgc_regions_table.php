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
        Schema::create('lib_psgc_regions', function (Blueprint $table) {
            $table->char('region_code', 9)->primary()->unique();
            $table->string('region_name', 60);
            $table->char('region_nick', 25);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lib_psgc_regions');
    }
};
