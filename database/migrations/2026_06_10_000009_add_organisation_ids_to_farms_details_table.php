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
        Schema::table('farms_details', function (Blueprint $table) {
            $table->foreignId('union_cereale_id')->nullable()->constrained('union_cereales')->nullOnDelete();
            $table->foreignId('cooperative_cereale_id')->nullable()->constrained('cooperative_cereales')->nullOnDelete();
            $table->foreignId('federation_scpc_id')->nullable()->constrained('federation_scpcs')->nullOnDelete();
            $table->foreignId('union_scpc_id')->nullable()->constrained('union_scpcs')->nullOnDelete();
            $table->foreignId('base_scpc_id')->nullable()->constrained('base_scpcs')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farms_details', function (Blueprint $table) {
            $table->dropForeign(['union_cereale_id']);
            $table->dropColumn('union_cereale_id');
            $table->dropForeign(['cooperative_cereale_id']);
            $table->dropColumn('cooperative_cereale_id');
            $table->dropForeign(['federation_scpc_id']);
            $table->dropColumn('federation_scpc_id');
            $table->dropForeign(['union_scpc_id']);
            $table->dropColumn('union_scpc_id');
            $table->dropForeign(['base_scpc_id']);
            $table->dropColumn('base_scpc_id');
        });
    }
};
