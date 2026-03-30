<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin SewaVIP',
            'email' => 'admin@sewavip.com',
            'password' => Hash::make('password'),
        ]);

        // Create default room settings
        Setting::create([
            'price_daily' => 350000,
            'price_weekly' => 2000000,
            'whatsapp_number' => '6281234567890',
            'status' => 'available',
            'room_description' => 'Kamar VIP eksklusif dengan fasilitas lengkap: AC, WiFi kencang, TV LED 43", kamar mandi dalam dengan water heater, lemari pakaian, meja kerja, dan parkir luas. Lokasi strategis di pusat kota Pekanbaru, dekat dengan pusat perbelanjaan dan kuliner.',
        ]);

        // Create sample properties
        $this->call(PropertySeeder::class);

        // Create sample rooms
        $this->call(RoomSeeder::class);

        // Create sample tenants
        $this->call(TenantSeeder::class);

        // Create sample invoices
        $this->call(InvoiceSeeder::class);

        // Create sample payments
        $this->call(PaymentSeeder::class);

        // Create sample expenses
        $this->call(ExpenseSeeder::class);

        // Create sample template inventories
        $this->call(TemplateInventorySeeder::class);
    }
}
