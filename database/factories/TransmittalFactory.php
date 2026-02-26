<?php

namespace Database\Factories;

use App\Models\Transmittal;
use App\Models\User;
use App\Models\Office;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransmittalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transmittal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reference_number' => 'T-' . $this->faker->unique()->year() . '-' . $this->faker->unique()->numerify('####'),
            'transmittal_date' => now(),
            'sender_user_id' => User::factory(),
            'sender_office_id' => Office::factory(),
            'receiver_office_id' => Office::factory(),
            'receiver_user_id' => null, // Typically null until received?
            'remarks' => $this->faker->sentence(),
            'status' => 'Pending', // Default status
            'received_at' => null,
            'verification_token' => \Illuminate\Support\Str::random(32),
            'qr_token' => \Illuminate\Support\Str::random(12),
        ];
    }
    
    public function received()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'Received',
                'received_at' => now(),
                'receiver_user_id' => User::factory(),
            ];
        });
    }
}
