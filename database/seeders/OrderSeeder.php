<?php

namespace Database\Seeders;

use App\Models\Concession;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = User::first(); // Get any existing user

        if ($user) {
            $order = Order::create([
                'user_id' => $user->id,
                'send_to_kitchen_time' => now()->addMinutes(30),
                'status' => 'Pending',
            ]);

            // Attach random concessions to the order
            $concessions = Concession::inRandomOrder()->take(2)->pluck('id');
            $order->concessions()->attach($concessions);
        }
    }
}
