<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Lola Civiles',
            'email'    => 'lola.civiles@bulletin.test',
            'password' => Hash::make('bulletin2026'),
        ]);

        $kagawadUser = User::create([
            'name'     => 'Kagawad Christian Civiles',
            'email'    => 'kagawad.civiles@bulletin.test',
            'password' => Hash::make('bulletin2026'),
        ]);

        // Link the login account to the existing Kagawad author profile from AuthorSeeder
        $kagawadAuthor = Author::where('email', 'kagawad.civiles@bulletin.test')->first()
            ?? Author::first();

        if ($kagawadAuthor) {
            $kagawadAuthor->update([
                'email'   => 'kagawad.civiles@bulletin.test',
                'user_id' => $kagawadUser->id,
            ]);
        }

        User::factory()->count(8)->create();
    }
}