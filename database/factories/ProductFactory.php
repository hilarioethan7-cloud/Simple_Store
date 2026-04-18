<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $products = [
            // Food
            ['name' => 'Chocolate Cake', 'category' => 'Food', 'price' => 15.99, 'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=500'],
            ['name' => 'Strawberry Cheesecake', 'category' => 'Food', 'price' => 18.99, 'image' => 'https://images.unsplash.com/photo-1567327613485-fbc7bf196198?w=500'],
            ['name' => 'Pepperoni Pizza', 'category' => 'Food', 'price' => 12.99, 'image' => 'https://images.unsplash.com/photo-1628840042765-356cda07504e?w=500'],
            ['name' => 'Sushi Platter', 'category' => 'Food', 'price' => 24.99, 'image' => 'https://images.unsplash.com/photo-1553621042-f6e147245754?w=500'],
            ['name' => 'Beef Burger', 'category' => 'Food', 'price' => 9.99, 'image' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=500'],
            ['name' => 'Caesar Salad', 'category' => 'Food', 'price' => 8.99, 'image' => 'https://images.unsplash.com/photo-1546793665-c74683f339c1?w=500'],
            ['name' => 'Fried Chicken', 'category' => 'Food', 'price' => 11.99, 'image' => 'https://images.unsplash.com/photo-1626645738196-c2a7c87a8f58?w=500'],
            ['name' => 'Pancakes with Syrup', 'category' => 'Food', 'price' => 7.99, 'image' => 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=500'],

            // Shoes
            ['name' => 'White Running Sneakers', 'category' => 'Shoes', 'price' => 89.99, 'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500'],
            ['name' => 'Black Leather Boots', 'category' => 'Shoes', 'price' => 129.99, 'image' => 'https://images.unsplash.com/photo-1608256246200-53e635b5b65f?w=500'],
            ['name' => 'Classic Canvas Shoes', 'category' => 'Shoes', 'price' => 59.99, 'image' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=500'],
            ['name' => 'Sports Training Shoes', 'category' => 'Shoes', 'price' => 99.99, 'image' => 'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=500'],
            ['name' => 'Slip-On Loafers', 'category' => 'Shoes', 'price' => 69.99, 'image' => 'https://images.unsplash.com/photo-1614252369475-531eba835eb1?w=500'],
            ['name' => 'High Top Sneakers', 'category' => 'Shoes', 'price' => 109.99, 'image' => 'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?w=500'],

            // Clothing
            ['name' => 'Classic White T-Shirt', 'category' => 'Clothing', 'price' => 19.99, 'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500'],
            ['name' => 'Blue Denim Jeans', 'category' => 'Clothing', 'price' => 49.99, 'image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=500'],
            ['name' => 'Cozy Hoodie', 'category' => 'Clothing', 'price' => 39.99, 'image' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=500'],
            ['name' => 'Summer Dress', 'category' => 'Clothing', 'price' => 34.99, 'image' => 'https://images.unsplash.com/photo-1496747611176-843222e1e57c?w=500'],

            // Accessories
            ['name' => 'Leather Wallet', 'category' => 'Accessories', 'price' => 29.99, 'image' => 'https://images.unsplash.com/photo-1627123424574-724758594e93?w=500'],
            ['name' => 'Aviator Sunglasses', 'category' => 'Accessories', 'price' => 24.99, 'image' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=500'],
            ['name' => 'Canvas Backpack', 'category' => 'Accessories', 'price' => 44.99, 'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500'],
            ['name' => 'Silver Watch', 'category' => 'Accessories', 'price' => 199.99, 'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500'],
        ];

        $product = fake()->randomElement($products);

        return [
            'category_id' => Category::where('name', $product['category'])->first()?->id
                ?? Category::inRandomOrder()->first()->id,
            'name'        => $product['name'],
            'slug'        => Str::slug($product['name']) . '-' . fake()->unique()->randomNumber(4),
            'description' => fake()->sentence(12),
            'price'       => $product['price'],
            'stock'       => fake()->numberBetween(5, 100),
            'image'       => $product['image'],
        ];
    }
}