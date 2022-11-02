<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name,
            'author' => $this->faker->name,
            'synopsis' => $this->faker->paragraph,
            'prix' => rand(1, 100),
            'type' => 'sell',
            'likes' => rand(1, 100),
            'categories' =>'action',
            'user_id' => rand(1, 10),

        ];
    }
}
