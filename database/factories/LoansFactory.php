<?php

namespace Database\Factories;

use App\Models\Loans;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoansFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Loans::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'rider_id' => $this->faker->randomDigitNotNull,
        'amount' => $this->faker->word,
        'purpose' => $this->faker->word,
        'terms' => $this->faker->word,
        'issue_date' => $this->faker->word,
        'due_date' => $this->faker->word,
        'paid' => $this->faker->word,
        'balance' => $this->faker->word,
        'status' => $this->faker->word,
        'created_by' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
