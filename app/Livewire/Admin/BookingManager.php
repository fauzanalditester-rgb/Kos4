<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\Finance;
use App\Models\Setting;
use Livewire\Component;
use Carbon\Carbon;

class BookingManager extends Component
{
    public $guest_name = '';
    public $phone = '';
    public $start_date = '';
    public $end_date = '';
    public $total_price = 0;
    public $status = 'confirmed';
    public $editingId = null;
    public $showForm = false;

    protected $rules = [
        'guest_name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'status' => 'required|in:pending,confirmed,completed',
    ];

    public function calculatePrice()
    {
        if ($this->start_date && $this->end_date) {
            $start = Carbon::parse($this->start_date);
            $end = Carbon::parse($this->end_date);
            $days = $start->diffInDays($end);
            if ($days < 1) $days = 1;

            $setting = Setting::first();
            if ($setting) {
                $weeks = intdiv($days, 7);
                $remainingDays = $days % 7;
                $this->total_price = ($weeks * $setting->price_weekly) + ($remainingDays * $setting->price_daily);
            }
        }
    }

    public function updated($property)
    {
        if (in_array($property, ['start_date', 'end_date'])) {
            $this->calculatePrice();
        }
    }

    public function save()
    {
        $this->validate();
        $this->calculatePrice();

        $data = [
            'guest_name' => $this->guest_name,
            'phone' => $this->phone,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'total_price' => $this->total_price,
            'status' => $this->status,
        ];

        if ($this->editingId) {
            Booking::find($this->editingId)->update($data);
        } else {
            $booking = Booking::create($data);
            // Auto-create income finance record for confirmed bookings
            if ($this->status === 'confirmed') {
                Finance::create([
                    'type' => 'income',
                    'amount' => $this->total_price,
                    'description' => 'Booking: ' . $this->guest_name,
                    'transaction_date' => now()->toDateString(),
                ]);
            }
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        $this->editingId = $booking->id;
        $this->guest_name = $booking->guest_name;
        $this->phone = $booking->phone;
        $this->start_date = $booking->start_date->format('Y-m-d');
        $this->end_date = $booking->end_date->format('Y-m-d');
        $this->total_price = $booking->total_price;
        $this->status = $booking->status;
        $this->showForm = true;
    }

    public function delete($id)
    {
        Booking::findOrFail($id)->delete();
    }

    public function resetForm()
    {
        $this->reset(['guest_name', 'phone', 'start_date', 'end_date', 'total_price', 'status', 'editingId', 'showForm']);
        $this->status = 'confirmed';
    }

    public function render()
    {
        return view('livewire.admin.booking-manager', [
            'bookings' => Booking::latest()->paginate(10),
        ])->layout('layouts.admin');
    }
}
