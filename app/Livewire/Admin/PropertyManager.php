<?php

namespace App\Livewire\Admin;

use App\Models\Property;
use Livewire\Component;
use Livewire\WithPagination;

class PropertyManager extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $isEditing = false;
    public $propertyId = null;

    // Form fields
    public $name = '';
    public $address = '';
    public $total_rooms = 0;
    public $occupied_rooms = 0;
    public $description = '';
    public $contact_phone = '';
    public $contact_email = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'address' => 'required|string',
        'total_rooms' => 'required|integer|min:0',
        'occupied_rooms' => 'required|integer|min:0',
        'description' => 'nullable|string',
        'contact_phone' => 'nullable|string|max:20',
        'contact_email' => 'nullable|email|max:255',
    ];

    public function render()
    {
        $properties = Property::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('address', 'like', '%' . $this->search . '%');
        })
        ->orderBy('created_at', 'desc')
        ->get();

        return view('livewire.admin.property-manager', [
            'properties' => $properties
        ])->layout('layouts.admin', ['title' => 'Properti']);
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

    public function editProperty($id)
    {
        $property = Property::findOrFail($id);
        $this->propertyId = $id;
        $this->name = $property->name;
        $this->address = $property->address;
        $this->total_rooms = $property->total_rooms;
        $this->occupied_rooms = $property->occupied_rooms;
        $this->description = $property->description;
        $this->contact_phone = $property->contact_phone;
        $this->contact_email = $property->contact_email;
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function saveProperty()
    {
        $this->validate();

        if ($this->isEditing) {
            $property = Property::findOrFail($this->propertyId);
            $property->update([
                'name' => $this->name,
                'address' => $this->address,
                'total_rooms' => $this->total_rooms,
                'occupied_rooms' => $this->occupied_rooms,
                'description' => $this->description,
                'contact_phone' => $this->contact_phone,
                'contact_email' => $this->contact_email,
            ]);
            session()->flash('message', 'Properti berhasil diperbarui!');
        } else {
            Property::create([
                'name' => $this->name,
                'address' => $this->address,
                'total_rooms' => $this->total_rooms,
                'occupied_rooms' => $this->occupied_rooms,
                'description' => $this->description,
                'contact_phone' => $this->contact_phone,
                'contact_email' => $this->contact_email,
            ]);
            session()->flash('message', 'Properti berhasil ditambahkan!');
        }

        $this->closeModal();
    }

    public function deleteProperty($id)
    {
        Property::findOrFail($id)->delete();
        session()->flash('message', 'Properti berhasil dihapus!');
    }

    private function resetForm()
    {
        $this->propertyId = null;
        $this->name = '';
        $this->address = '';
        $this->total_rooms = 0;
        $this->occupied_rooms = 0;
        $this->description = '';
        $this->contact_phone = '';
        $this->contact_email = '';
        $this->isEditing = false;
    }
}
