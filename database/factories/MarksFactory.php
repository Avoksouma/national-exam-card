<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Marks;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

class MarksFactory extends Factory
{
    protected $model = Marks::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userIds = User::where('role', '!=', 'student')->pluck('id')->toArray();
        $studentIds = User::where('role', 'student')->pluck('id')->toArray();
        $subjectIds = Subject::pluck('id')->toArray();

        return [
            'marks' => $this->faker->numberBetween(10, 20),
            'year' => 2024,
            'subject_id' => $this->faker->randomElement($subjectIds),
            'student_id' => $this->faker->randomElement($studentIds),
            'user_id' => $this->faker->randomElement($userIds),
        ];
    }
}
