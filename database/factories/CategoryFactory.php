<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected static array $categories = [
        'Food', 'Shoes', 'Clothing', 'Accessories'
    ];

    protected static int $index = 0;

    public function definition(): array
    {
        $name = self::$categories[self::$index % count(self::$categories)];
        self::$index++;

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}