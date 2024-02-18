<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userIds = User::where('role', '!=', 'student')->pluck('id')->toArray();
        $subjects =  ['English', 'French', 'Biology', 'Math', 'Geography', 'Physics', 'History', 'Religion', 'Swahili', 'Chemistry', 'Agriculture', 'Business'];

        return [
            'name' => $this->faker->randomElement($subjects),
            'description' => $this->faker->text,
            'user_id' => $this->faker->randomElement($userIds),
        ];
    }
}
