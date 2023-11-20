<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = $this->getAdmin();
        $customer = $this->getCustomer();

        Transaction::factory()->count(20)->create(['payer_id' => $customer->id]);
        Transaction::factory()->overdue()->count(20)->create(['payer_id' => $customer->id]);
        Transaction::factory()->paid()->count(20)->create(['payer_id' => $customer->id]);

        Transaction::factory()->count(50)->create();
        Transaction::factory()->overdue()->count(50)->create();
        Transaction::factory()->paid()->count(50)->create();
    }

    public function getAdmin()
    {
        $admin = User::whereEmail('admin@admin.com')->first();
        if (!$admin) {
            $admin = User::factory()->admin()->create(['email' => 'admin@admin.com']);
        }
        return $admin;
    }

    public function getCustomer()
    {
        $customer = User::whereEmail('user@user.com')->first();
        if (!$customer) {
            $customer = User::factory()->customer()->create(['email' => 'user@user.com']);
        }
        return $customer;
    }
}
