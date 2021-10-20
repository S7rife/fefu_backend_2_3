<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = News::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->realTextBetween(5, 30),
            'text'=>$this->faker->realTextBetween(300, 600),
            'description'=>$this->faker->boolean(random_int(30, 100)) ? $this->faker->realTextBetween(100, 200) : null,
//            'description'=>$this->faker->realTextBetween(100, 200),
            'is_published'=>$this->faker->boolean(70),
            'published_at'=>$this->faker->dateTimeBetween('-2 months', '2 weeks'),
        ];
    }
}
