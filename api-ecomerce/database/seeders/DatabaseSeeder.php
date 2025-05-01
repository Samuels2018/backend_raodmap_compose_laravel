<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true
        ]);

        // Create regular user
        $user = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'is_admin' => false
        ]);

        // Create cart for user
        $user->cart()->create();

        // Create sample products
        Product::create([
            'name' => 'Laptop',
            'description' => 'Powerful laptop with 16GB RAM and 512GB SSD',
            'price' => 999.99,
            'stock' => 10
        ]);

        Product::create([
            'name' => 'Smartphone',
            'description' => 'Latest smartphone with 128GB storage',
            'price' => 699.99,
            'stock' => 20
        ]);

        Product::create([
            'name' => 'Headphones',
            'description' => 'Noise cancelling wireless headphones',
            'price' => 199.99,
            'stock' => 30
        ]);
    }
}
