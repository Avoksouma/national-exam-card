<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

class SchoolFactory extends Factory
{
    protected $model = School::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userIds = User::where('role', '!=', 'student')->pluck('id')->toArray();
        $schools =  ['St Joseph', 'St Patrick', 'St Francis', 'St Bosco', 'GS Kacyiru', 'GS Kanombe', 'Apaper', 'Apade', 'IFAK', 'St Leon'];

        return [
            'name' => $this->faker->randomElement($schools),
            'contact' => $this->faker->phoneNumber,
            'description' => $this->faker->text,
            'user_id' => $this->faker->randomElement($userIds),
        ];
    }
}
