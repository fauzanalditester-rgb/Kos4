<?php

namespace App\Livewire;

use App\Models\Booking;
use Livewire\Component;
use Carbon\Carbon;

class AvailabilityCalendar extends Component
{
    public $currentMonth;
    public $currentYear;
    public $calendarDays = [];
    public $bookedDates = [];

    public function mount()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->loadCalendar();
    }

    public function previousMonth()
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->loadCalendar();
    }

    public function nextMonth()
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->loadCalendar();
    }

    public function loadCalendar()
    {
        $start = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1);
        $end = $start->copy()->endOfMonth();

        $bookings = Booking::whereIn('status', ['confirmed', 'completed'])
            ->where('start_date', '<=', $end)
            ->where('end_date', '>=', $start)
            ->get();

        $this->bookedDates = [];
        foreach ($bookings as $booking) {
            $bookStart = Carbon::parse($booking->start_date);
            $bookEnd = Carbon::parse($booking->end_date);
            $current = $bookStart->copy();
            while ($current->lte($bookEnd)) {
                $this->bookedDates[] = $current->format('Y-m-d');
                $current->addDay();
            }
        }
        $this->bookedDates = array_unique($this->bookedDates);

        $this->calendarDays = [];
        $dayOfWeek = $start->dayOfWeek; // 0=Sunday

        // Add empty days for padding
        for ($i = 0; $i < $dayOfWeek; $i++) {
            $this->calendarDays[] = ['date' => null, 'booked' => false];
        }

        for ($day = 1; $day <= $end->day; $day++) {
            $dateStr = sprintf('%04d-%02d-%02d', $this->currentYear, $this->currentMonth, $day);
            $this->calendarDays[] = [
                'date' => $dateStr,
                'day' => $day,
                'booked' => in_array($dateStr, $this->bookedDates),
                'isPast' => Carbon::parse($dateStr)->lt(Carbon::today()),
            ];
        }
    }

    public function getMonthNameProperty()
    {
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $months[$this->currentMonth] . ' ' . $this->currentYear;
    }

    public function render()
    {
        return view('livewire.availability-calendar');
    }
}
