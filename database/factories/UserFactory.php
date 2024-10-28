<?php

namespace Database\Factories;

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
            'password' => $this->faker->lexify('1???@???A???'),
            'gender' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'birth_date' => $this->faker->date('Y-m-d'),
            'email' => $this->faker->email,
            'experience' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'address' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'phone' => $this->faker->numerify('0##########'),
            'profile_status' => $this->faker->boolean,
            'is_admin' => $this->faker->boolean,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'category_id' => $this->faker->word
        ];
    }
}
