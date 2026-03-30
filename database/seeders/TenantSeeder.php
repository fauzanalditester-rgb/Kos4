<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        $harmoni = Property::where('name', 'Kost Harmoni Residence')->first();
        $cendana = Property::where('name', 'Kost Cendana House')->first();

        if ($harmoni) {
            $tenants = [
                [
                    'name' => 'Ahmad Fauzi',
                    'room_code' => 'A-101',
                    'phone' => '081234567890',
                    'email' => 'ahmad@email.com',
                    'id_card_number' => '3171023456789012',
                    'move_in_date' => '2025-01-15',
                    'duration' => '14 bulan 18 hari',
                ],
                [
                    'name' => 'Siti Nurhaliza',
                    'room_code' => 'A-102',
                    'phone' => '081345678901',
                    'email' => 'siti@email.com',
                    'id_card_number' => '3171024567890123',
                    'move_in_date' => '2025-02-01',
                    'duration' => '13 bulan 1 hari',
                ],
                [
                    'name' => 'Budi Santoso',
                    'room_code' => 'A-103',
                    'phone' => '081456789012',
                    'email' => 'budi@email.com',
                    'id_card_number' => '3171025678901234',
                    'move_in_date' => '2024-11-01',
                    'duration' => '16 bulan 1 hari',
                ],
                [
                    'name' => 'Dewi Lestari',
                    'room_code' => 'A-201',
                    'phone' => '081567890123',
                    'email' => 'dewi@email.com',
                    'id_card_number' => '3171026789012345',
                    'move_in_date' => '2024-12-01',
                    'duration' => '15 bulan 1 hari',
                ],
                [
                    'name' => 'Rizky Pratama',
                    'room_code' => 'A-203',
                    'phone' => '081678901234',
                    'email' => 'rizky@email.com',
                    'id_card_number' => '3171027890123456',
                    'move_in_date' => '2025-01-01',
                    'duration' => '14 bulan 2 hari',
                ],
                [
                    'name' => 'Maya Putri',
                    'room_code' => 'B-101',
                    'phone' => '081789012345',
                    'email' => 'maya@email.com',
                    'id_card_number' => '3171028901234567',
                    'move_in_date' => '2025-01-10',
                    'duration' => '14 bulan 22 hari',
                ],
            ];

            foreach ($tenants as $data) {
                $room = Room::where('property_id', $harmoni->id)
                    ->where('code', $data['room_code'])
                    ->first();
                
                if ($room) {
                    Tenant::create([
                        'property_id' => $harmoni->id,
                        'room_id' => $room->id,
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'phone' => $data['phone'],
                        'id_card_number' => $data['id_card_number'],
                        'address' => 'Jl. Contoh Alamat No. 123, Jakarta',
                        'move_in_date' => $data['move_in_date'],
                        'move_out_date' => null,
                        'status' => 'active',
                        'deposit' => 1500000,
                        'emergency_contact' => 'Keluarga - 081000000000',
                    ]);

                    // Update room status to occupied
                    $room->update(['status' => 'occupied']);
                }
            }

            // Add one completed tenant
            $room = Room::where('property_id', $harmoni->id)
                ->where('code', 'B-102')
                ->first();
            
            if ($room) {
                Tenant::create([
                    'property_id' => $harmoni->id,
                    'room_id' => $room->id,
                    'name' => 'Rina Susanti',
                    'email' => 'rina@email.com',
                    'phone' => '081901234567',
                    'id_card_number' => '3171029012345678',
                    'address' => 'Jl. Contoh Alamat No. 456, Jakarta',
                    'move_in_date' => '2024-06-01',
                    'move_out_date' => '2024-12-01',
                    'status' => 'completed',
                    'deposit' => 1500000,
                    'emergency_contact' => 'Keluarga - 081000000001',
                ]);
            }
        }

        if ($cendana) {
            $tenants = [
                [
                    'name' => 'Andi Wijaya',
                    'room_code' => 'C-101',
                    'phone' => '081890123456',
                    'email' => 'andi@email.com',
                    'id_card_number' => '3271021234567890',
                    'move_in_date' => '2025-02-01',
                    'duration' => '13 bulan 1 hari',
                ],
            ];

            foreach ($tenants as $data) {
                $room = Room::where('property_id', $cendana->id)
                    ->where('code', $data['room_code'])
                    ->first();
                
                if ($room) {
                    Tenant::create([
                        'property_id' => $cendana->id,
                        'room_id' => $room->id,
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'phone' => $data['phone'],
                        'id_card_number' => $data['id_card_number'],
                        'address' => 'Jl. Contoh Alamat No. 789, Bandung',
                        'move_in_date' => $data['move_in_date'],
                        'move_out_date' => null,
                        'status' => 'active',
                        'deposit' => 1200000,
                        'emergency_contact' => 'Keluarga - 081000000002',
                    ]);

                    $room->update(['status' => 'occupied']);
                }
            }
        }
    }
}
