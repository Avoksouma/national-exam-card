<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Combination;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CombinationFactory extends Factory
{
    protected $model = Combination::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userIds = User::where('role', '!=', 'student')->pluck('id')->toArray();

        return [
            'name' => Str::random(1),
            'description' => $this->faker->text,
            'user_id' => $this->faker->randomElement($userIds),
        ];
    }
}
