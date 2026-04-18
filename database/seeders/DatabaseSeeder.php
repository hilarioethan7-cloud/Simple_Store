<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create admin user first
        $this->call(AdminSeeder::class);

        // 2. Create 10 regular customers
        User::factory(10)->create();

        // 3. Create fixed categories
        $categories = ['Food', 'Shoes', 'Clothing', 'Accessories'];
        foreach ($categories as $name) {
            Category::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($name)],
                ['name' => $name]
            );
        }

        // 4. Create 20 products
        Product::factory(20)->create();

        // 5. Create 10 orders
        Order::factory(10)->create();

        // 6. Create 30 order items
        OrderItem::factory(30)->create();
    }
}