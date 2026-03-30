<?php

namespace App\Livewire\Admin;

use App\Models\Property;
use App\Models\Room;
use Livewire\Component;
use Livewire\WithPagination;

class RoomManager extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $showModal = false;
    public $isEditing = false;
    public $roomId = null;

    // Form fields
    public $property_id = '';
    public $code = '';
    public $type = 'Standard';
    public $price_monthly = '';
    public $status = 'available';
    public $floor = 1;
    public $facilities = '';
    public $description = '';

    protected $rules = [
        'property_id' => 'required|exists:properties,id',
        'code' => 'required|string|max:50',
        'type' => 'required|string|max:50',
        'price_monthly' => 'required|numeric|min:0',
        'status' => 'required|in:available,occupied,maintenance',
        'floor' => 'required|integer|min:1',
        'facilities' => 'nullable|string',
        'description' => 'nullable|string',
    ];

    public function render()
    {
        $rooms = Room::with('property')
            ->when($this->search, function ($query) {
                $query->where('code', 'like', '%' . $this->search . '%')
                      ->orWhereHas('property', function ($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      });
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->orderBy('code')
            ->get();

        $properties = Property::all();

        return view('livewire.admin.room-manager', [
            'rooms' => $rooms,
            'properties' => $properties,
        ])->layout('layouts.admin', ['title' => 'Kamar']);
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

    public function editRoom($id)
    {
        $room = Room::findOrFail($id);
        $this->roomId = $id;
        $this->property_id = $room->property_id;
        $this->code = $room->code;
        $this->type = $room->type;
        $this->price_monthly = $room->price_monthly;
        $this->status = $room->status;
        $this->floor = $room->floor;
        $this->facilities = $room->facilities;
        $this->description = $room->description;
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function saveRoom()
    {
        $this->validate();

        if ($this->isEditing) {
            $room = Room::findOrFail($this->roomId);
            $room->update([
                'property_id' => $this->property_id,
                'code' => $this->code,
                'type' => $this->type,
                'price_monthly' => $this->price_monthly,
                'status' => $this->status,
                'floor' => $this->floor,
                'facilities' => $this->facilities,
                'description' => $this->description,
            ]);
            session()->flash('message', 'Kamar berhasil diperbarui!');
        } else {
            Room::create([
                'property_id' => $this->property_id,
                'code' => $this->code,
                'type' => $this->type,
                'price_monthly' => $this->price_monthly,
                'status' => $this->status,
                'floor' => $this->floor,
                'facilities' => $this->facilities,
                'description' => $this->description,
            ]);
            session()->flash('message', 'Kamar berhasil ditambahkan!');
        }

        $this->closeModal();
    }

    public function deleteRoom($id)
    {
        Room::findOrFail($id)->delete();
        session()->flash('message', 'Kamar berhasil dihapus!');
    }

    private function resetForm()
    {
        $this->roomId = null;
        $this->property_id = '';
        $this->code = '';
        $this->type = 'Standard';
        $this->price_monthly = '';
        $this->status = 'available';
        $this->floor = 1;
        $this->facilities = '';
        $this->description = '';
        $this->isEditing = false;
    }
}
