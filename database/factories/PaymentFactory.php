<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create();
        }

        return [
            'amount' => $this->faker->numberBetween(0, 9223372036854775807),
            'payment_method' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'status' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'transaction_id' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'date' => $this->faker->date('Y-m-d H:i:s'),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'user_id' => $this->faker->word
        ];
    }
}
