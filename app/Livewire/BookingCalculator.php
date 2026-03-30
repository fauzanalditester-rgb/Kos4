<?php

namespace App\Livewire;

use App\Models\Setting;
use App\Models\Booking;
use Livewire\Component;
use Carbon\Carbon;

class BookingCalculator extends Component
{
    public $start_date = '';
    public $end_date = '';
    public $total_price = 0;
    public $days = 0;
    public $priceBreakdown = '';

    public function updated($property)
    {
        if (in_array($property, ['start_date', 'end_date'])) {
            $this->calculate();
        }
    }

    public function calculate()
    {
        if (!$this->start_date || !$this->end_date) {
            $this->total_price = 0;
            $this->days = 0;
            $this->priceBreakdown = '';
            return;
        }

        $start = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->end_date);

        if ($end->lte($start)) {
            $this->total_price = 0;
            $this->days = 0;
            $this->priceBreakdown = '';
            return;
        }

        $this->days = $start->diffInDays($end);
        if ($this->days < 1) $this->days = 1;

        $setting = Setting::first();
        if (!$setting) return;

        $weeks = intdiv($this->days, 7);
        $remainingDays = $this->days % 7;
        $this->total_price = ($weeks * $setting->price_weekly) + ($remainingDays * $setting->price_daily);

        $parts = [];
        if ($weeks > 0) $parts[] = $weeks . ' minggu';
        if ($remainingDays > 0) $parts[] = $remainingDays . ' hari';
        $this->priceBreakdown = implode(' + ', $parts);
    }

    public function bookViaWhatsapp()
    {
        if (!$this->start_date || !$this->end_date || $this->total_price <= 0) return;

        $setting = Setting::first();
        $message = "Halo, saya ingin booking Kamar VIP:\n"
            . "📅 Check-in: " . Carbon::parse($this->start_date)->format('d/m/Y') . "\n"
            . "📅 Check-out: " . Carbon::parse($this->end_date)->format('d/m/Y') . "\n"
            . "⏰ Durasi: " . $this->days . " hari\n"
            . "💰 Total: Rp " . number_format($this->total_price, 0, ',', '.') . "\n\n"
            . "Mohon konfirmasinya. Terima kasih!";

        $waNumber = $setting->whatsapp_number ?? '6281234567890';
        $url = "https://wa.me/{$waNumber}?text=" . urlencode($message);

        $this->dispatch('redirect-wa', url: $url);
    }

    public function render()
    {
        return view('livewire.booking-calculator');
    }
}
