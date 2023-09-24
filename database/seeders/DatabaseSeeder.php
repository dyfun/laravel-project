<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //\App\Models\User::factory(10)->create();

        $user = \App\Models\User::factory()->create([
            'name' => 'Tayfun Güler',
            'email' => 'gulertayfun@outlook.com',
            'password' => 'helloworld'
        ]);

        $subscription = $user->subscriptions()->create(['renewed_at' =>  "2023-09-24 09:39:58", 'expired_at' => '2023-10-24 09:39:58']);
        $subscription->transactions()->create(['price' => 150, 'status' => true]);
    }
}
