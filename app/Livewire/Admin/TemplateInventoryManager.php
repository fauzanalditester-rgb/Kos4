<?php

namespace App\Livewire\Admin;

use App\Models\TemplateInventory;
use Livewire\Component;

class TemplateInventoryManager extends Component
{
    public $showModal = false;
    public $isEditing = false;
    public $itemId = null;

    public $name = '';
    public $quantity = 1;
    public $condition = 'good';
    public $price = '';
    public $notes = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'condition' => 'required|in:new,good,fair,poor,broken',
            'price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ];
    }

    public function render()
    {
        $items = TemplateInventory::orderBy('name')->get();

        return view('livewire.admin.template-inventory-manager', [
            'items' => $items,
        ])->layout('layouts.admin', ['title' => 'Template Inventaris']);
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

    public function editItem($id)
    {
        $item = TemplateInventory::findOrFail($id);
        $this->itemId = $id;
        $this->name = $item->name;
        $this->quantity = $item->quantity;
        $this->condition = $item->condition;
        $this->price = $item->price;
        $this->notes = $item->notes;
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function saveItem()
    {
        $validated = $this->validate();

        $data = [
            'name' => $this->name,
            'quantity' => $this->quantity,
            'condition' => $this->condition,
            'price' => $this->price ?: 0,
            'notes' => $this->notes,
        ];

        if ($this->isEditing) {
            TemplateInventory::findOrFail($this->itemId)->update($data);
            session()->flash('message', 'Item berhasil diperbarui!');
        } else {
            TemplateInventory::create($data);
            session()->flash('message', 'Item berhasil ditambahkan!');
        }

        $this->closeModal();
    }

    public function deleteItem($id)
    {
        TemplateInventory::findOrFail($id)->delete();
        session()->flash('message', 'Item berhasil dihapus!');
    }

    private function resetForm()
    {
        $this->name = '';
        $this->quantity = 1;
        $this->condition = 'good';
        $this->price = '';
        $this->notes = '';
        $this->itemId = null;
        $this->isEditing = false;
    }
}
