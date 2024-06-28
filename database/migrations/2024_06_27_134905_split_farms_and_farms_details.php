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

        DB::statement('CREATE TABLE farms_details LIKE farms');

        DB::statement('INSERT INTO farms_details SELECT * FROM farms');

        Schema::table('farms_details', function (Blueprint $table) {
            $table->unsignedBigInteger('farm_id')->after('id');
        });

        DB::statement('UPDATE farms_details SET farm_id = id');

        Schema::table('farms_details', function (Blueprint $table) {
            $table->foreign('farm_id')->references('id')->on('farms')->onDelete('cascade');
        });

        DB::statement('SET @count = 0');
        DB::statement('UPDATE farms_details SET id = @count := @count + 1');
        DB::statement('ALTER TABLE farms_details AUTO_INCREMENT = 1');

        Schema::table('farms', function (Blueprint $table) {
            $table->dropColumn(['year',
                                'chef_upa',
                                'chef_travaux',
                                'neo_alphabete',
                                'activite_primaire',
                                'activite_secondaire',
                                'cereales_favoris_1',
                                'cereales_favoris_2',
                                'cereales_favoris_3',
                                'superficie_possede_upa', 
                                'superficie_cultive_upa'
                            ]);
        });

        Schema::table('farms_details', function (Blueprint $table) {
            $table->dropColumn(['code', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
