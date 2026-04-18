<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake('en_US')->unique()->words(3, true);
        $imageId = fake()->numberBetween(1, 1000);
        $imageUrl = "https://picsum.photos/seed/{$imageId}/600/600";
        $imageContents = file_get_contents($imageUrl);
        $imageName = 'products/' . Str::uuid() . '.jpg';
        \Illuminate\Support\Facades\Storage::disk('public')->put($imageName, $imageContents);

        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'description' => fake('en_US')->paragraph(),
            'price' => fake()->randomFloat(2, 10, 500),
            'stock' => fake()->numberBetween(0, 100),
            'image' => $imageName,
        ];
    }
}