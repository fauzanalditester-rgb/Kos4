<?php

namespace App\Livewire\Admin;

use App\Models\Expense;
use App\Models\Inventory;
use App\Models\Property;
use App\Models\Room;
use Livewire\Component;
use Livewire\WithFileUploads;

class ExpenseManager extends Component
{
    use WithFileUploads;

    public $activeTab = 'expense'; // 'expense' or 'inventory'
    public $search = '';
    public $filterCategory = '';
    public $showModal = false;
    public $isEditing = false;
    public $itemId = null;
    public $modalType = 'expense'; // 'expense' or 'inventory'

    // Expense form fields
    public $property_id = '';
    public $date = '';
    public $title = '';
    public $description = '';
    public $category = '';
    public $amount = '';
    public $expense_notes = '';
    public $receiptFile = null;

    // Inventory form fields
    public $inventory_property_id = '';
    public $room_id = '';
    public $item_name = '';
    public $inventory_category = '';
    public $quantity = 1;
    public $unit = 'pcs';
    public $price = '';
    public $purchase_date = '';
    public $condition = 'good';
    public $inventory_notes = '';

    protected $rules = [
        'property_id' => 'nullable|exists:properties,id',
        'date' => 'required|date',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category' => 'required|string',
        'amount' => 'required|numeric|min:0',
        'expense_notes' => 'nullable|string',
        'receiptFile' => 'nullable|image|max:2048',
    ];

    public function render()
    {
        $expenses = Expense::with('property')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterCategory, function ($query) {
                $query->where('category', $this->filterCategory);
            })
            ->orderBy('date', 'desc')
            ->get();

        $inventories = Inventory::with(['property', 'room'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('purchase_date', 'desc')
            ->get();

        $properties = Property::all();
        $rooms = Room::where('property_id', $this->inventory_property_id)->get();
        $totalExpense = $expenses->sum('amount');

        $categories = [
            'staff_salary' => 'Gaji Staff / Penjaga Kost',
            'water_bill' => 'Pembayaran Air Bulanan',
            'electricity_bill' => 'Pembayaran Listrik Bulanan',
            'supplies' => 'Alat-alat Kost (Plastik Sampah, dll)',
            'gas' => 'Tabung Gas Dapur',
            'maintenance' => 'Renovasi / Perbaikan',
            'internet' => 'Internet / WiFi',
            'cleaning' => 'Kebersihan',
            'other' => 'Lainnya',
        ];

        return view('livewire.admin.expense-manager', [
            'expenses' => $expenses,
            'inventories' => $inventories,
            'properties' => $properties,
            'rooms' => $rooms,
            'totalExpense' => $totalExpense,
            'categories' => $categories,
        ])->layout('layouts.admin', ['title' => 'Pengeluaran & Inventaris']);
    }

    public function openModal($type = 'expense')
    {
        $this->modalType = $type;
        $this->resetForm();
        $this->showModal = true;
        $this->isEditing = false;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function editExpense($id)
    {
        $expense = Expense::findOrFail($id);
        $this->itemId = $id;
        $this->property_id = $expense->property_id;
        $this->date = $expense->date->format('Y-m-d');
        $this->title = $expense->title;
        $this->description = $expense->description;
        $this->category = $expense->category;
        $this->amount = $expense->amount;
        $this->expense_notes = $expense->notes;
        $this->modalType = 'expense';
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function editInventory($id)
    {
        $inventory = Inventory::findOrFail($id);
        $this->itemId = $id;
        $this->inventory_property_id = $inventory->property_id;
        $this->room_id = $inventory->room_id;
        $this->item_name = $inventory->name;
        $this->inventory_category = $inventory->category;
        $this->quantity = $inventory->quantity;
        $this->unit = $inventory->unit;
        $this->price = $inventory->price;
        $this->purchase_date = $inventory->purchase_date?->format('Y-m-d');
        $this->condition = $inventory->condition;
        $this->inventory_notes = $inventory->notes;
        $this->modalType = 'inventory';
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function saveExpense()
    {
        $this->modalType = 'expense';
        $this->validate();

        $data = [
            'property_id' => $this->property_id ?: null,
            'date' => $this->date,
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'amount' => $this->amount,
            'notes' => $this->expense_notes,
        ];

        if ($this->receiptFile) {
            $data['receipt_photo'] = $this->receiptFile->store('receipts', 'public');
        }

        if ($this->isEditing) {
            $expense = Expense::findOrFail($this->itemId);
            $expense->update($data);
            session()->flash('message', 'Pengeluaran berhasil diperbarui!');
        } else {
            Expense::create($data);
            session()->flash('message', 'Pengeluaran berhasil ditambahkan!');
        }

        $this->closeModal();
    }

    public function saveInventory()
    {
        $validated = $this->validate([
            'inventory_property_id' => 'nullable|exists:properties,id',
            'room_id' => 'nullable|exists:rooms,id',
            'item_name' => 'required|string|max:255',
            'inventory_category' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'unit' => 'required|string|max:20',
            'price' => 'nullable|numeric|min:0',
            'purchase_date' => 'nullable|date',
            'condition' => 'required|in:new,good,fair,poor,broken',
            'inventory_notes' => 'nullable|string',
        ]);

        $data = [
            'property_id' => $this->inventory_property_id ?: null,
            'room_id' => $this->room_id ?: null,
            'name' => $this->item_name,
            'category' => $this->inventory_category,
            'quantity' => $this->quantity,
            'unit' => $this->unit,
            'price' => $this->price ?: 0,
            'purchase_date' => $this->purchase_date,
            'condition' => $this->condition,
            'notes' => $this->inventory_notes,
        ];

        if ($this->isEditing) {
            $inventory = Inventory::findOrFail($this->itemId);
            $inventory->update($data);
            session()->flash('message', 'Inventaris berhasil diperbarui!');
        } else {
            Inventory::create($data);
            session()->flash('message', 'Inventaris berhasil ditambahkan!');
        }

        $this->closeModal();
    }

    public function deleteExpense($id)
    {
        Expense::findOrFail($id)->delete();
        session()->flash('message', 'Pengeluaran berhasil dihapus!');
    }

    public function deleteInventory($id)
    {
        Inventory::findOrFail($id)->delete();
        session()->flash('message', 'Inventaris berhasil dihapus!');
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->search = '';
        $this->filterCategory = '';
    }

    private function resetForm()
    {
        // Expense fields
        $this->property_id = '';
        $this->date = date('Y-m-d');
        $this->title = '';
        $this->description = '';
        $this->category = '';
        $this->amount = '';
        $this->expense_notes = '';
        $this->receiptFile = null;

        // Inventory fields
        $this->inventory_property_id = '';
        $this->room_id = '';
        $this->item_name = '';
        $this->inventory_category = '';
        $this->quantity = 1;
        $this->unit = 'pcs';
        $this->price = '';
        $this->purchase_date = '';
        $this->condition = 'good';
        $this->inventory_notes = '';

        $this->itemId = null;
        $this->isEditing = false;
    }
}
