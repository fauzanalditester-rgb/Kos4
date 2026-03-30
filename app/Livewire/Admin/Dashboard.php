<?php

namespace App\Livewire\Admin;

use App\Models\Finance;
use App\Models\Booking;
use Livewire\Component;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function render()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $todayIncome = Finance::where('type', 'income')
            ->whereDate('transaction_date', $today)
            ->sum('amount');

        $monthIncome = Finance::where('type', 'income')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $totalIncome = Finance::where('type', 'income')->sum('amount');
        $totalExpense = Finance::where('type', 'expense')->sum('amount');
        $netProfit = $totalIncome - $totalExpense;

        $recentBookings = Booking::latest()->take(5)->get();
        $activeBookings = Booking::where('status', 'confirmed')
            ->where('end_date', '>=', $today)
            ->count();

        return view('livewire.admin.dashboard', [
            'todayIncome' => $todayIncome,
            'monthIncome' => $monthIncome,
            'totalIncome' => $totalIncome,
            'netProfit' => $netProfit,
            'recentBookings' => $recentBookings,
            'activeBookings' => $activeBookings,
        ])->layout('layouts.admin');
    }
}
