<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\Property;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ExpenseSeeder extends Seeder
{
    public function run(): void
    {
        $harmoni = Property::where('name', 'Kost Harmoni Residence')->first();
        $cendana = Property::where('name', 'Kost Cendana House')->first();

        $expenses = [
            [
                'property_id' => $harmoni?->id,
                'date' => '2026-02-01',
                'title' => 'Gaji Pak Budi - Penjaga',
                'description' => 'Gaji bulan Februari',
                'category' => 'staff_salary',
                'amount' => 2500000,
            ],
            [
                'property_id' => $harmoni?->id,
                'date' => '2026-02-05',
                'title' => 'PDAM Februari',
                'description' => 'Tagihan air bulanan',
                'category' => 'water_bill',
                'amount' => 850000,
            ],
            [
                'property_id' => $harmoni?->id,
                'date' => '2026-02-05',
                'title' => 'PLN Februari',
                'description' => 'Tagihan listrik area umum',
                'category' => 'electricity_bill',
                'amount' => 1200000,
            ],
            [
                'property_id' => $harmoni?->id,
                'date' => '2026-02-10',
                'title' => 'Plastik Sampah & Sabun',
                'description' => 'Belanja bulanan',
                'category' => 'supplies',
                'amount' => 150000,
            ],
            [
                'property_id' => $cendana?->id,
                'date' => '2026-02-12',
                'title' => 'Tabung Gas 12kg x 2',
                'description' => 'Untuk dapur umum',
                'category' => 'gas',
                'amount' => 340000,
            ],
            [
                'property_id' => $harmoni?->id,
                'date' => '2026-02-20',
                'title' => 'Perbaikan pipa bocor kamar B-101',
                'description' => 'Pipa kamar mandi bocor',
                'category' => 'maintenance',
                'amount' => 350000,
            ],
        ];

        foreach ($expenses as $expense) {
            Expense::create($expense);
        }
    }
}
