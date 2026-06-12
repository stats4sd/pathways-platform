<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('union_scpcs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->foreignId('commune_id')->nullable()->constrained('communes')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('union_scpcs');
    }
};
