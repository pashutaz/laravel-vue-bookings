<?php

namespace Database\Factories;

use App\Models\Bookable;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookableFactory extends Factory
{
    private $suffix = [
        'villa',
        'House',
        'Cottage',
        'Rooms',
        'Cheap Rooms'
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
    public function definition()
    {
        return [
            'title' => $this->faker->city . ' ' . Arr::random($this->suffix),
            'description' => $this->faker->text()
        ];
    }
}
