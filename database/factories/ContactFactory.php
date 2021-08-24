<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'company' => $this->faker->company(),
            'birthday' => $this->faker->date('m/d/Y'),
            'user_id' => User::factory()
        ];
    }
}
