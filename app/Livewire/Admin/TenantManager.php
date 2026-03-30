<?php

namespace App\Livewire\Admin;

use App\Models\Property;
use App\Models\Room;
use App\Models\Tenant;
use Livewire\Component;
use Livewire\WithFileUploads;

class TenantManager extends Component
{
    use WithFileUploads;

    public $search = '';
    public $showModal = false;
    public $isEditing = false;
    public $tenantId = null;
    public $showIdCardModal = false;
    public $viewingTenant = null;
    public $idCardFile = null;

    // Form fields
    public $property_id = '';
    public $room_id = '';
    public $name = '';
    public $email = '';
    public $phone = '';
    public $id_card_number = '';
    public $address = '';
    public $move_in_date = '';
    public $move_out_date = '';
    public $status = 'active';
    public $deposit = 0;
    public $emergency_contact = '';

    protected $rules = [
        'property_id' => 'required|exists:properties,id',
        'room_id' => 'required|exists:rooms,id',
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'phone' => 'required|string|max:20',
        'id_card_number' => 'nullable|string|max:50',
        'address' => 'nullable|string',
        'move_in_date' => 'required|date',
        'move_out_date' => 'nullable|date',
        'status' => 'required|in:active,completed,cancelled',
        'deposit' => 'nullable|numeric|min:0',
        'emergency_contact' => 'nullable|string',
    ];

    public function render()
    {
        $activeTenants = Tenant::with(['property', 'room'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%')
                      ->orWhereHas('room', function ($q) {
                          $q->where('code', 'like', '%' . $this->search . '%');
                      });
            })
            ->where('status', 'active')
            ->orderBy('move_in_date', 'desc')
            ->get();

        $completedTenants = Tenant::with(['property', 'room'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%')
                      ->orWhereHas('room', function ($q) {
                          $q->where('code', 'like', '%' . $this->search . '%');
                      });
            })
            ->whereIn('status', ['completed', 'cancelled'])
            ->orderBy('move_out_date', 'desc')
            ->get();

        $properties = Property::all();
        $rooms = Room::where('property_id', $this->property_id)->where('status', 'available')->get();

        return view('livewire.admin.tenant-manager', [
            'activeTenants' => $activeTenants,
            'completedTenants' => $completedTenants,
            'properties' => $properties,
            'availableRooms' => $rooms,
        ])->layout('layouts.admin', ['title' => 'Penyewa']);
    }

    public function updatedPropertyId($value)
    {
        $this->room_id = '';
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

    public function editTenant($id)
    {
        $tenant = Tenant::findOrFail($id);
        $this->tenantId = $id;
        $this->property_id = $tenant->property_id;
        $this->room_id = $tenant->room_id;
        $this->name = $tenant->name;
        $this->email = $tenant->email;
        $this->phone = $tenant->phone;
        $this->id_card_number = $tenant->id_card_number;
        $this->address = $tenant->address;
        $this->move_in_date = $tenant->move_in_date?->format('Y-m-d');
        $this->move_out_date = $tenant->move_out_date?->format('Y-m-d');
        $this->status = $tenant->status;
        $this->deposit = $tenant->deposit;
        $this->emergency_contact = $tenant->emergency_contact;
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function saveTenant()
    {
        $this->validate();

        $data = [
            'property_id' => $this->property_id,
            'room_id' => $this->room_id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'id_card_number' => $this->id_card_number,
            'address' => $this->address,
            'move_in_date' => $this->move_in_date,
            'move_out_date' => $this->move_out_date,
            'status' => $this->status,
            'deposit' => $this->deposit,
            'emergency_contact' => $this->emergency_contact,
        ];

        if ($this->isEditing) {
            $tenant = Tenant::findOrFail($this->tenantId);
            $tenant->update($data);
            session()->flash('message', 'Penyewa berhasil diperbarui!');
        } else {
            Tenant::create($data);
            
            // Update room status to occupied
            $room = Room::find($this->room_id);
            if ($room && $this->status === 'active') {
                $room->update(['status' => 'occupied']);
            }
            
            session()->flash('message', 'Penyewa berhasil ditambahkan!');
        }

        $this->closeModal();
    }

    public function deleteTenant($id)
    {
        $tenant = Tenant::findOrFail($id);
        $room = $tenant->room;
        
        $tenant->delete();
        
        // Update room status back to available
        if ($room) {
            $room->update(['status' => 'available']);
        }
        
        session()->flash('message', 'Penyewa berhasil dihapus!');
    }

    public function checkoutTenant($id)
    {
        $tenant = Tenant::findOrFail($id);
        $tenant->update([
            'status' => 'completed',
            'move_out_date' => now(),
        ]);
        
        // Update room status back to available
        $room = $tenant->room;
        if ($room) {
            $room->update(['status' => 'available']);
        }
        
        session()->flash('message', 'Penyewa berhasil checkout!');
    }

    public function openIdCardModal($id)
    {
        $this->viewingTenant = Tenant::findOrFail($id);
        $this->showIdCardModal = true;
        $this->idCardFile = null;
    }

    public function closeIdCardModal()
    {
        $this->showIdCardModal = false;
        $this->viewingTenant = null;
        $this->idCardFile = null;
    }

    public function uploadIdCard()
    {
        $this->validate([
            'idCardFile' => 'required|image|max:2048',
        ]);

        if ($this->viewingTenant) {
            $path = $this->idCardFile->store('id-cards', 'public');
            $this->viewingTenant->update(['id_card_photo' => $path]);
            $this->viewingTenant->refresh();
            $this->idCardFile = null;
            session()->flash('message', 'KTP berhasil diupload!');
        }
    }

    private function resetForm()
    {
        $this->tenantId = null;
        $this->property_id = '';
        $this->room_id = '';
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->id_card_number = '';
        $this->address = '';
        $this->move_in_date = '';
        $this->move_out_date = '';
        $this->status = 'active';
        $this->deposit = 0;
        $this->emergency_contact = '';
        $this->isEditing = false;
    }
}
