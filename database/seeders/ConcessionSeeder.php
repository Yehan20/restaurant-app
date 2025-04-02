<?php

namespace Database\Seeders;

use App\Models\Concession;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConcessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        Concession::insert([


            [
                'name' => 'Burger',
                'description' => 'Juicy grilled beef patty with cheese',
                'image' => 'images/burger.jpg',
                'price' => 5.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pizza',
                'description' => 'Pepperoni pizza with melted cheese',
                'image' => 'images/pizza.jpg',
                'price' => 8.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'French Fries',
                'description' => 'Crispy golden fries with ketchup',
                'image' => 'images/fries.jpg',
                'price' => 2.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Coke',
                'description' => 'Classic Coke',
                'image' => 'images/fries.jpg',
                'price' => 1.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
