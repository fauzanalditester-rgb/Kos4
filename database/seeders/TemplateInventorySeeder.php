<?php

namespace Database\Seeders;

use App\Models\TemplateInventory;
use Illuminate\Database\Seeder;

class TemplateInventorySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'name' => 'AC',
                'quantity' => 1,
                'condition' => 'good',
                'price' => 2500000,
                'notes' => null,
            ],
            [
                'name' => 'Tempat Tidur',
                'quantity' => 1,
                'condition' => 'good',
                'price' => 1500000,
                'notes' => null,
            ],
            [
                'name' => 'Meja',
                'quantity' => 1,
                'condition' => 'good',
                'price' => 500000,
                'notes' => null,
            ],
        ];

        foreach ($items as $item) {
            TemplateInventory::create($item);
        }
    }
}
