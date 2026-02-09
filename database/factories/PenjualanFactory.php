<?php

namespace Database\Factories;

use App\Models\Penjualan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PenjualanFactory extends Factory
{
    protected $model = Penjualan::class;

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->value('id'),
            'total_pembayaran' => 0,
            'metode_pembayaran' => $this->faker->randomElement([
                'CASH', 'TRANSFER', 'QRIS'
            ]),
            'status' => $this->faker->randomElement([
                'OPEN', 'COMPLETED'
            ]),
        ];
    }
}
