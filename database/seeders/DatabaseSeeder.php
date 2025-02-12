<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $users = collect([
            [
                'name' => 'Mario',
                'email' => 'mariomad2296@gmail.com',
            ],
            [
                'name' => 'Fitra',
                'email' => 'fitra@gmail.com',
            ],
            [
                'name' => 'Asdar',
                'email' => 'asdar@gmail.com',
            ],
        ]);

        $users->each(fn ($user) => User::factory()->create($user));

        $this->call([
            RolePermissionSeeder::class,
        ]);

        User::factory(100)->create()->each(fn ($user) => $user->assignRole('registrant'));
    }
}
