<?php

namespace App\Livewire\Admin;

use App\Models\Payment;
use App\Models\Tenant;
use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithFileUploads;

class PaymentManager extends Component
{
    use WithFileUploads;

    public $search = '';
    public $showModal = false;
    public $isEditing = false;
    public $paymentId = null;

    // Form fields
    public $tenant_id = '';
    public $invoice_id = '';
    public $payment_date = '';
    public $amount = '';
    public $method = 'transfer';
    public $reference_number = '';
    public $notes = '';
    public $status = 'verified';
    public $proofFile = null;

    protected $rules = [
        'tenant_id' => 'required|exists:tenants,id',
        'invoice_id' => 'required|exists:invoices,id',
        'payment_date' => 'required|date',
        'amount' => 'required|numeric|min:0',
        'method' => 'required|in:transfer,e-wallet,tunai,debit,kredit',
        'reference_number' => 'nullable|string|max:100',
        'notes' => 'nullable|string',
        'status' => 'required|in:pending,verified,rejected',
        'proofFile' => 'nullable|image|max:2048',
    ];

    public function render()
    {
        $payments = Payment::with(['tenant', 'invoice'])
            ->when($this->search, function ($query) {
                $query->whereHas('tenant', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })->orWhereHas('invoice', function ($q) {
                    $q->where('invoice_number', 'like', '%' . $this->search . '%');
                })->orWhere('reference_number', 'like', '%' . $this->search . '%');
            })
            ->orderBy('payment_date', 'desc')
            ->get();

        $tenants = Tenant::where('status', 'active')->get();
        $invoices = Invoice::where('tenant_id', $this->tenant_id)
            ->whereIn('status', ['sent', 'overdue', 'paid'])
            ->get();

        return view('livewire.admin.payment-manager', [
            'payments' => $payments,
            'tenants' => $tenants,
            'invoices' => $invoices,
        ])->layout('layouts.admin', ['title' => 'Pembayaran']);
    }

    public function updatedTenantId($value)
    {
        $this->invoice_id = '';
        $this->amount = '';
    }

    public function updatedInvoiceId($value)
    {
        $invoice = Invoice::find($value);
        if ($invoice) {
            $this->amount = $invoice->remaining_amount;
        }
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
        $this->isEditing = false;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function editPayment($id)
    {
        $payment = Payment::findOrFail($id);
        $this->paymentId = $id;
        $this->tenant_id = $payment->tenant_id;
        $this->invoice_id = $payment->invoice_id;
        $this->payment_date = $payment->payment_date->format('Y-m-d');
        $this->amount = $payment->amount;
        $this->method = $payment->method;
        $this->reference_number = $payment->reference_number;
        $this->notes = $payment->notes;
        $this->status = $payment->status;
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function savePayment()
    {
        $this->validate();

        $data = [
            'tenant_id' => $this->tenant_id,
            'invoice_id' => $this->invoice_id,
            'payment_date' => $this->payment_date,
            'amount' => $this->amount,
            'method' => $this->method,
            'reference_number' => $this->reference_number,
            'notes' => $this->notes,
            'status' => $this->status,
        ];

        if ($this->proofFile) {
            $data['proof_photo'] = $this->proofFile->store('payment-proofs', 'public');
        }

        if ($this->isEditing) {
            $payment = Payment::findOrFail($this->paymentId);
            $payment->update($data);
            session()->flash('message', 'Pembayaran berhasil diperbarui!');
        } else {
            Payment::create($data);
            
            // Update invoice paid amount and status
            $invoice = Invoice::find($this->invoice_id);
            if ($invoice) {
                $newPaidAmount = $invoice->paid_amount + $this->amount;
                $newStatus = $newPaidAmount >= $invoice->total_amount ? 'paid' : 'sent';
                $invoice->update([
                    'paid_amount' => $newPaidAmount,
                    'status' => $newStatus,
                ]);
            }
            
            session()->flash('message', 'Pembayaran berhasil dicatat!');
        }

        $this->closeModal();
    }

    public function deletePayment($id)
    {
        $payment = Payment::findOrFail($id);
        
        // Revert invoice paid amount
        $invoice = $payment->invoice;
        if ($invoice) {
            $newPaidAmount = max(0, $invoice->paid_amount - $payment->amount);
            $newStatus = $newPaidAmount >= $invoice->total_amount ? 'paid' : 'sent';
            $invoice->update([
                'paid_amount' => $newPaidAmount,
                'status' => $newStatus,
            ]);
        }
        
        $payment->delete();
        session()->flash('message', 'Pembayaran berhasil dihapus!');
    }

    private function resetForm()
    {
        $this->paymentId = null;
        $this->tenant_id = '';
        $this->invoice_id = '';
        $this->payment_date = date('Y-m-d');
        $this->amount = '';
        $this->method = 'transfer';
        $this->reference_number = '';
        $this->notes = '';
        $this->status = 'verified';
        $this->proofFile = null;
        $this->isEditing = false;
    }
}
