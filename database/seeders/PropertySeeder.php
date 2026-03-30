<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $properties = [
            [
                'name' => 'Kost Harmoni Residence',
                'address' => 'Jl. Harmoni No. 42, Menteng, Jakarta Pusat',
                'total_rooms' => 20,
                'occupied_rooms' => 16,
                'description' => 'Kost eksklusif di pusat kota dengan fasilitas lengkap',
                'contact_phone' => '0812-3456-7890',
                'contact_email' => 'harmoni@kost.com',
                'is_active' => true,
            ],
            [
                'name' => 'Kost Cendana House',
                'address' => 'Jl. Cendana Raya No. 15, Bandung',
                'total_rooms' => 12,
                'occupied_rooms' => 10,
                'description' => 'Kost nyaman dengan suasana asri di Bandung',
                'contact_phone' => '0821-8765-4321',
                'contact_email' => 'cendana@kost.com',
                'is_active' => true,
            ],
        ];

        foreach ($properties as $property) {
            Property::create($property);
        }
    }
}
