<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cooperative_cereales', function (Blueprint $table) {
            $table->dropForeign(['village_id']);
            $table->dropColumn('village_id');
            $table->foreignId('union_cereale_id')->nullable()->constrained('union_cereales')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('cooperative_cereales', function (Blueprint $table) {
            $table->dropForeign(['union_cereale_id']);
            $table->dropColumn('union_cereale_id');
            $table->foreignId('village_id')->nullable()->constrained('villages')->nullOnDelete();
        });
    }
};
