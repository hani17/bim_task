<?php

namespace Database\Factories;

use App\Enums\TransactionStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isVatInclusive = fake()->boolean();
        $vat = fake()->numberBetween(1, 80);
        $amount = fake()->numberBetween(1000, 10000);
        $originalAmount = $isVatInclusive ? ($amount / (1 + ($vat / 100))) : $amount;
        $vatAmount = $isVatInclusive ? ($amount - $originalAmount) : ($originalAmount * ($vat / 100));
        return [
            'amount' => $originalAmount,
            'payer_id' => User::factory(),
            'due_on' => now()->addDays(2),
            'vat_amount' => $vatAmount,
            'is_vat_inclusive' => $isVatInclusive,
            'status' => TransactionStatus::OUTSTANDING,
        ];
    }

    /**
     * Indicate that the model's status is overdue.
     */
    public function overdue(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TransactionStatus::OVERDUE,
            'due_on' => now()->subMonths(2)
        ]);
    }

    /**
     * Indicate that the model's status is overdue.
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TransactionStatus::PAID,
            'total_paid_amount' => $attributes['amount'] +  $attributes['vat_amount']
        ]);
    }
}
