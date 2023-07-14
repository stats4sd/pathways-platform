<?php

namespace App\Http\database\factories;

use App\Models\Crop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Farm>
 */
class FarmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->name;

        return [
            'user_id' => User::factory(['name' => $name]),
            'code' => 'TEST_00' . $this->faker->randomNumber(4),
            'year' => '2023',
            'chef_upa' => $name,
            'chef_travaux' => $this->faker->name,
            'neo_alphabete' => $this->faker->word,
            'activite_primaire' => $this->faker->jobTitle,
            'activite_secondaire' => $this->faker->jobTitle,
            'cereales_favoris_1' => Crop::inRandomOrder()->first()->id,
            'cereales_favoris_2' => Crop::inRandomOrder()->first()->id,
            'cereales_favoris_3' => Crop::inRandomOrder()->first()->id,
            'superficie_possede_upa' => $this->faker->numberBetween(1, 200) / 10,
            'superficie_cultive_upa' => $this->faker->numberBetween(1, 200) / 10,
        ];
    }
}
