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
        Schema::create('lib_psgc_brgies', function (Blueprint $table) {
            $table->char('brgy_code', 9)->primary()->unique();
            $table->string('brgy_name', 60);
            $table->char('city_code', 9);
            $table->tinyInteger('urb_rur')->default(0);
            $table->timestamps();

            $table->foreign('city_code')
                ->references('city_code')
                ->on('lib_psgc_cities')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lib_psgc_brgies');
    }
};
