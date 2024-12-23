<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Category;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $category = Category::first();
        if (!$category) {
            $category = Category::factory()->create();
        }

        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'password' => Hash::make('password'),
            'gender' => $this->faker->randomElement(['Homme', 'Femme']),
            'birth_date' => $this->faker->date('Y-m-d'),
            'email' => $this->faker->unique()->safeEmail,
            'experience' => $this->faker->randomElement(['debutant', 'intermediaire', 'avancé']),
            'address' => $this->faker->address,
            'phone' => $this->faker->numerify('0#########'),
            'profile_status' => 'en attente',
            'created_at' => now(),
            'updated_at' => now(),
            'category_id' => $category->id,
        ];
    }
}
