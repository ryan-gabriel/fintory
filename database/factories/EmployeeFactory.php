<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\User;
use App\Models\Outlet;
use App\Models\Lembaga;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->name(),
            'outlet_id' => Outlet::factory(),
            'lembaga_id' => Lembaga::factory(),
            'position' => fake()->randomElement(['Manager', 'Kasir', 'Staff', 'Supervisor', 'Assistant Manager']),
            'joined_at' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
        ];
    }
}