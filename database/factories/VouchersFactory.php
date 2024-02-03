<?php

namespace Database\Factories;

use App\Models\Vouchers;
use Illuminate\Database\Eloquent\Factories\Factory;

class VouchersFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vouchers::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'trans_date' => $this->faker->word,
        'trans_code' => $this->faker->word,
        'posting_date' => $this->faker->word,
        'billing_month' => $this->faker->word,
        'payment_to' => $this->faker->word,
        'payment_from' => $this->faker->word,
        'payment_type' => $this->faker->word,
        'voucher_type' => $this->faker->word,
        'reason' => $this->faker->word,
        'amount' => $this->faker->word,
        'remarks' => $this->faker->word,
        'ref_id' => $this->faker->word,
        'rider_id' => $this->faker->word,
        'vendor_id' => $this->faker->word,
        'status' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
