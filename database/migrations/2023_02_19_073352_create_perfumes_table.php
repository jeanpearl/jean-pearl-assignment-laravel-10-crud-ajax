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
        Schema::create('perfumes', function (Blueprint $table) {
            $table->id();
            $table->string('perfume_name');
            $table->string('perfume_flavor');
            $table->string('perfume_country');
            $table->string('perfume_price');
            $table->string('perfume_image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfumes');
    }
};
