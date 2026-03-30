<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $payments = [
            [
                'tenant_name' => 'Ahmad Fauzi',
                'invoice_number' => 'INV-20260201-0001',
                'date' => '2026-02-03',
                'amount' => 1500000,
                'method' => 'transfer',
            ],
            [
                'tenant_name' => 'Siti Nurhaliza',
                'invoice_number' => 'INV-20260201-0002',
                'date' => '2026-02-04',
                'amount' => 1575000,
                'method' => 'e-wallet',
            ],
            [
                'tenant_name' => 'Rizky Pratama',
                'invoice_number' => 'INV-20260201-0005',
                'date' => '2026-02-05',
                'amount' => 1500000,
                'method' => 'tunai',
            ],
        ];

        foreach ($payments as $data) {
            $tenant = Tenant::where('name', $data['tenant_name'])->first();
            $invoice = Invoice::where('invoice_number', $data['invoice_number'])->first();

            if ($tenant && $invoice) {
                Payment::create([
                    'tenant_id' => $tenant->id,
                    'invoice_id' => $invoice->id,
                    'payment_date' => $data['date'],
                    'amount' => $data['amount'],
                    'method' => $data['method'],
                    'reference_number' => 'PAY-' . date('Ymd') . rand(1000, 9999),
                    'status' => 'verified',
                ]);

                // Update invoice paid amount
                $newPaidAmount = $invoice->paid_amount + $data['amount'];
                $newStatus = $newPaidAmount >= $invoice->total_amount ? 'paid' : 'sent';
                $invoice->update([
                    'paid_amount' => $newPaidAmount,
                    'status' => $newStatus,
                ]);
            }
        }
    }
}
