<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::truncate();
        $faker = Faker::create('id_ID');

        User::create([
            'name' => 'Tasya',
            'email' => 'tasya@atro.com' ?: $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$12$a1MmQnOtO/mo6vr25oT7BOfK2W5k1U6VcIDULB00tnxvR9ytG6sQG' ?: Hash::make('password'),
            'remember_token' => \Illuminate\Support\Str::random(10),
        ]);

        User::create([
            'name' => 'Tazkiyah Salsabila asd',
            'email' => 'tazkiyah@atro.id' ?: $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$12$gDUyyXPh5vrzKNDIrK6Ry.YfjEqQ0VIv5JANXx3MRLcAfOWMlICEu' ?: Hash::make('password'),
            'remember_token' => \Illuminate\Support\Str::random(10),
        ]);

        User::create([
            'name' => 'Admin Atro',
            'email' => 'admin@admin.com' ?: $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$12$NkMy3C9wBVmgRR2Pmkzf2.3bYc6XY7Xd96mi39qouZb9w/PK543K.' ?: Hash::make('password'),
            'remember_token' => \Illuminate\Support\Str::random(10),
        ]);
    }
}
