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
        Schema::create('interest_points', function (Blueprint $table) {
            $table->id();
            $table->string('farm_id')->constrained('farms');
            $table->string('nom')->nullable();
            $table->decimal('longitude', 25,20)->nullable();
            $table->decimal('latitude', 25,20)->nullable();
            $table->decimal('altitude', 25,20)->nullable();
            $table->decimal('accuracy', 25,20)->nullable();
            $table->text('description_audio')->nullable();
            $table->text('description_videos')->nullable();
            $table->text('description_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interest_points');
    }
};
