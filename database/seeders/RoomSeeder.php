<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        // Get properties
        $harmoni = Property::where('name', 'Kost Harmoni Residence')->first();
        $cendana = Property::where('name', 'Kost Cendana House')->first();

        if ($harmoni) {
            $rooms = [
                ['code' => 'A-101', 'type' => 'Standard', 'price_monthly' => 1500000, 'status' => 'occupied', 'floor' => 1],
                ['code' => 'A-102', 'type' => 'Standard', 'price_monthly' => 1500000, 'status' => 'occupied', 'floor' => 1],
                ['code' => 'A-103', 'type' => 'Deluxe', 'price_monthly' => 2000000, 'status' => 'available', 'floor' => 1],
                ['code' => 'A-201', 'type' => 'Deluxe', 'price_monthly' => 2000000, 'status' => 'occupied', 'floor' => 2],
                ['code' => 'A-202', 'type' => 'Standard', 'price_monthly' => 1500000, 'status' => 'maintenance', 'floor' => 2],
                ['code' => 'A-203', 'type' => 'Suite', 'price_monthly' => 3000000, 'status' => 'occupied', 'floor' => 2],
                ['code' => 'B-101', 'type' => 'Standard', 'price_monthly' => 1500000, 'status' => 'occupied', 'floor' => 1],
                ['code' => 'B-102', 'type' => 'Standard', 'price_monthly' => 1500000, 'status' => 'available', 'floor' => 1],
            ];

            foreach ($rooms as $room) {
                Room::create(array_merge($room, [
                    'property_id' => $harmoni->id,
                    'facilities' => 'AC, TV, WiFi, Kamar Mandi Dalam',
                ]));
            }
        }

        if ($cendana) {
            $rooms = [
                ['code' => 'C-101', 'type' => 'Standard', 'price_monthly' => 1200000, 'status' => 'occupied', 'floor' => 1],
                ['code' => 'C-102', 'type' => 'Standard', 'price_monthly' => 1200000, 'status' => 'occupied', 'floor' => 1],
            ];

            foreach ($rooms as $room) {
                Room::create(array_merge($room, [
                    'property_id' => $cendana->id,
                    'facilities' => 'AC, WiFi, Kamar Mandi Dalam',
                ]));
            }
        }
    }
}
