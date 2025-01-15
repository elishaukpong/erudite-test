<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $creators = User::factory()->count(3)->create();

        Event::factory()
            ->count(20)
            ->recycle($creators)
            ->create();
    }
}
