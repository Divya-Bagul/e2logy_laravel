<?php

namespace Database\Seeders;

use App\Models\Manager;
use Illuminate\Database\Seeder;

class ManagerSeeder extends Seeder
{
    public function run(): void
    {
        $managers = [
            'Michael Lee',
            'Sarah Miller',
            'David Chen',
            'Lisa Anderson',
        ];

        foreach ($managers as $name) {
            Manager::create(['name' => $name]);
        }
    }
}
