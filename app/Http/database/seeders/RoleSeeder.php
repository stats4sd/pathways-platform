<?php

namespace App\Http\database\seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::updateOrCreate(['name' => 'Research Team']);
        Role::updateOrCreate(['name' => 'Farmer']);
    }
}
