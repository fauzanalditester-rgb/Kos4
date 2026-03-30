<?php

namespace App\Livewire\Admin;

use App\Models\Invoice;
use App\Models\Tenant;
use App\Models\Room;
use Livewire\Component;

class InvoiceManager extends Component
{
    public $search = '';
    public $filterStatus = '';
    public $showModal = false;
    public $isEditing = false;
    public $invoiceId = null;

    // Form fields
    public $tenant_id = '';
    public $room_id = '';
    public $issue_date = '';
    public $due_date = '';
    public $rent_amount = '';
    public $additional_amount = 0;
    public $description = '';
    public $notes = '';
    public $status = 'draft';

    protected $rules = [
        'tenant_id' => 'required|exists:tenants,id',
        'room_id' => 'required|exists:rooms,id',
        'issue_date' => 'required|date',
        'due_date' => 'required|date|after_or_equal:issue_date',
        'rent_amount' => 'required|numeric|min:0',
        'additional_amount' => 'nullable|numeric|min:0',
        'description' => 'nullable|string',
        'notes' => 'nullable|string',
        'status' => 'required|in:draft,sent,paid,overdue,cancelled',
    ];

    public function render()
    {
        $invoices = Invoice::with(['tenant', 'room'])
            ->when($this->search, function ($query) {
                $query->where('invoice_number', 'like', '%' . $this->search . '%')
                      ->orWhereHas('tenant', function ($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      });
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->orderBy('issue_date', 'desc')
            ->get();

        $tenants = Tenant::where('status', 'active')->with('room')->get();

        return view('livewire.admin.invoice-manager', [
            'invoices' => $invoices,
            'tenants' => $tenants,
        ])->layout('layouts.admin', ['title' => 'Tagihan']);
    }

    public function updatedTenantId($value)
    {
        $tenant = Tenant::find($value);
        if ($tenant) {
            $this->room_id = $tenant->room_id;
            $this->rent_amount = $tenant->room->price_monthly ?? '';
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

    public function editInvoice($id)
    {
        $invoice = Invoice::findOrFail($id);
        $this->invoiceId = $id;
        $this->tenant_id = $invoice->tenant_id;
        $this->room_id = $invoice->room_id;
        $this->issue_date = $invoice->issue_date->format('Y-m-d');
        $this->due_date = $invoice->due_date->format('Y-m-d');
        $this->rent_amount = $invoice->rent_amount;
        $this->additional_amount = $invoice->additional_amount;
        $this->description = $invoice->description;
        $this->notes = $invoice->notes;
        $this->status = $invoice->status;
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function saveInvoice()
    {
        $this->validate();

        $totalAmount = $this->rent_amount + $this->additional_amount;

        $data = [
            'tenant_id' => $this->tenant_id,
            'room_id' => $this->room_id,
            'issue_date' => $this->issue_date,
            'due_date' => $this->due_date,
            'rent_amount' => $this->rent_amount,
            'additional_amount' => $this->additional_amount,
            'total_amount' => $totalAmount,
            'description' => $this->description,
            'notes' => $this->notes,
            'status' => $this->status,
        ];

        if ($this->isEditing) {
            $invoice = Invoice::findOrFail($this->invoiceId);
            $invoice->update($data);
            session()->flash('message', 'Invoice berhasil diperbarui!');
        } else {
            $invoiceNumber = $this->generateInvoiceNumber();
            $data['invoice_number'] = $invoiceNumber;
            Invoice::create($data);
            session()->flash('message', 'Invoice berhasil dibuat!');
        }

        $this->closeModal();
    }

    public function deleteInvoice($id)
    {
        Invoice::findOrFail($id)->delete();
        session()->flash('message', 'Invoice berhasil dihapus!');
    }

    public function markAsPaid($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->update([
            'status' => 'paid',
            'paid_amount' => $invoice->total_amount,
        ]);
        session()->flash('message', 'Invoice ditandai sebagai lunas!');
    }

    public function sendInvoice($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->update(['status' => 'sent']);
        session()->flash('message', 'Invoice berhasil dikirim!');
    }

    public function exportInvoices()
    {
        $invoices = Invoice::with(['tenant', 'room'])->get();
        $filename = "tagihan_" . date('Y-m-d') . ".csv";
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate",
            "Expires" => "0"
        ];

        $callback = function() use($invoices) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No Invoice', 'Penyewa', 'Kamar', 'Tanggal', 'Jatuh Tempo', 'Total', 'Status']);
            foreach ($invoices as $invoice) {
                fputcsv($file, [
                    $invoice->invoice_number,
                    $invoice->tenant->name,
                    $invoice->room->code,
                    $invoice->issue_date->format('Y-m-d'),
                    $invoice->due_date->format('Y-m-d'),
                    $invoice->total_amount,
                    $invoice->status_label
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function generateInvoiceNumber(): string
    {
        $prefix = 'INV-' . date('Ymd');
        $lastInvoice = Invoice::where('invoice_number', 'like', $prefix . '%')
            ->orderBy('invoice_number', 'desc')
            ->first();
        
        if ($lastInvoice) {
            $lastNumber = intval(substr($lastInvoice->invoice_number, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    private function resetForm()
    {
        $this->invoiceId = null;
        $this->tenant_id = '';
        $this->room_id = '';
        $this->issue_date = date('Y-m-d');
        $this->due_date = date('Y-m-d', strtotime('+7 days'));
        $this->rent_amount = '';
        $this->additional_amount = 0;
        $this->description = '';
        $this->notes = '';
        $this->status = 'draft';
        $this->isEditing = false;
    }
}
