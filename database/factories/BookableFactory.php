<?php

namespace Database\Factories;

use App\Models\Bookable;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookableFactory extends Factory
{
    private $suffix = [
        'Villa',
        'House',
        'Cottage',
        'Room',
        'Cheap Room',
        'Apartment',
        'Condo',
        'Cabin'
    ];

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bookable::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->city . ' ' . Arr::random($this->suffix),
            'description' => $this->faker->text(),
            'price' => rand(99, 999) + rand(50, 99) / 100
        ];
    }
}
