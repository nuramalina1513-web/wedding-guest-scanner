<?php

namespace Database\Seeders;

use App\Models\Guest;
use Illuminate\Database\Seeder;

class GuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Guest::updateOrCreate(
            [
                'code' => 'WED-ARIFA-001',
            ],
            [
            'name' => 'Nur Amalina',
            'invitation_limit' => 2,
            'attended_count' => 0,
            'scanned_at' => null,
            ]
        );
    }
}
