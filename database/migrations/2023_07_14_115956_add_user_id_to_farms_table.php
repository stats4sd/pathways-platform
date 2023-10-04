<?php

use App\Models\Farm;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $farms = Farm::all();

        foreach($farms as $farm) {
            User::updateOrCreate(
                [
                    'name' => 'UPA '.$farm->id,
                    'email' => 'farm_'.$farm->id,
                    'email_verified_at' => now(),
                    'password' => bcrypt(rand(10000,99999))
                ]
            );
        }

        Schema::table('farms', function (Blueprint $table) {
            $table->foreignId('user_id');
        });

        foreach($farms as $farm) {
            $farm->user_id = User::firstWhere('email', 'farm_'.$farm->id)->id;
            $farm->save();
        }

        Schema::table('farms', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farms', function (Blueprint $table) {

        });
    }
};
