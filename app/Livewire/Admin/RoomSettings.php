<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;

class RoomSettings extends Component
{
    public $price_daily;
    public $price_weekly;
    public $whatsapp_number;
    public $status;
    public $room_description;

    public function mount()
    {
        $setting = Setting::first();
        if ($setting) {
            $this->price_daily = $setting->price_daily;
            $this->price_weekly = $setting->price_weekly;
            $this->whatsapp_number = $setting->whatsapp_number;
            $this->status = $setting->status;
            $this->room_description = $setting->room_description;
        }
    }

    public function save()
    {
        $this->validate([
            'price_daily' => 'required|numeric|min:0',
            'price_weekly' => 'required|numeric|min:0',
            'whatsapp_number' => 'required|string|max:20',
            'status' => 'required|in:available,maintenance',
            'room_description' => 'nullable|string',
        ]);

        $setting = Setting::first();
        $setting->update([
            'price_daily' => $this->price_daily,
            'price_weekly' => $this->price_weekly,
            'whatsapp_number' => $this->whatsapp_number,
            'status' => $this->status,
            'room_description' => $this->room_description,
        ]);

        session()->flash('success', 'Pengaturan berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.admin.room-settings')->layout('layouts.admin');
    }
}
