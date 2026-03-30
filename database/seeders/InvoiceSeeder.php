<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Tenant;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $tenants = Tenant::where('status', 'active')->get();
        $baseDate = Carbon::create(2026, 2, 1);

        $invoices = [
            [
                'tenant_name' => 'Ahmad Fauzi',
                'room_code' => 'A-101',
                'rent' => 1500000,
                'additional' => 0,
                'status' => 'paid',
            ],
            [
                'tenant_name' => 'Siti Nurhaliza',
                'room_code' => 'A-102',
                'rent' => 1500000,
                'additional' => 75000, // Listrik/air
                'status' => 'paid',
            ],
            [
                'tenant_name' => 'Budi Santoso',
                'room_code' => 'A-201',
                'rent' => 2000000,
                'additional' => 50000,
                'status' => 'overdue',
            ],
            [
                'tenant_name' => 'Dewi Lestari',
                'room_code' => 'A-203',
                'rent' => 3000000,
                'additional' => 0,
                'status' => 'sent',
            ],
            [
                'tenant_name' => 'Rizky Pratama',
                'room_code' => 'B-101',
                'rent' => 1500000,
                'additional' => 0,
                'status' => 'paid',
            ],
            [
                'tenant_name' => 'Maya Putri',
                'room_code' => 'C-101',
                'rent' => 1200000,
                'additional' => 0,
                'status' => 'sent',
            ],
        ];

        foreach ($invoices as $index => $data) {
            $tenant = Tenant::where('name', $data['tenant_name'])->first();
            $room = Room::where('code', $data['room_code'])->first();

            if ($tenant && $room) {
                $invoiceNumber = 'INV-' . $baseDate->format('Ymd') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);
                $totalAmount = $data['rent'] + $data['additional'];

                Invoice::create([
                    'tenant_id' => $tenant->id,
                    'room_id' => $room->id,
                    'invoice_number' => $invoiceNumber,
                    'issue_date' => $baseDate->copy(),
                    'due_date' => $baseDate->copy()->addDays(4), // 2026-02-05
                    'rent_amount' => $data['rent'],
                    'additional_amount' => $data['additional'],
                    'total_amount' => $totalAmount,
                    'paid_amount' => $data['status'] === 'paid' ? $totalAmount : 0,
                    'description' => 'Tagihan sewa kamar periode Februari 2026',
                    'status' => $data['status'],
                    'notes' => null,
                ]);
            }
        }
    }
}
