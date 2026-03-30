<?php

namespace App\Livewire\Admin;

use App\Models\Finance;
use Livewire\Component;
use Livewire\WithPagination;

class FinanceManager extends Component
{
    use WithPagination;

    public $type = 'expense';
    public $amount = '';
    public $description = '';
    public $transaction_date = '';
    public $showForm = false;
    public $filterType = 'all';

    protected $rules = [
        'type' => 'required|in:income,expense',
        'amount' => 'required|numeric|min:1',
        'description' => 'required|string|max:255',
        'transaction_date' => 'required|date',
    ];

    public function mount()
    {
        $this->transaction_date = now()->toDateString();
    }

    public function save()
    {
        $this->validate();

        Finance::create([
            'type' => $this->type,
            'amount' => $this->amount,
            'description' => $this->description,
            'transaction_date' => $this->transaction_date,
        ]);

        $this->reset(['type', 'amount', 'description', 'showForm']);
        $this->type = 'expense';
        $this->transaction_date = now()->toDateString();
    }

    public function delete($id)
    {
        Finance::findOrFail($id)->delete();
    }

    public function render()
    {
        // Get data for last 6 months
        $startDate = now()->subMonths(5)->startOfMonth();
        $endDate = now()->endOfMonth();

        $query = Finance::latest();
        if ($this->filterType !== 'all') {
            $query->where('type', $this->filterType);
        }

        // Calculate summary for last 6 months
        $sixMonthsFinances = Finance::whereBetween('transaction_date', [$startDate, $endDate])->get();
        $totalIncome = $sixMonthsFinances->where('type', 'income')->sum('amount');
        $totalExpense = $sixMonthsFinances->where('type', 'expense')->sum('amount');
        $netProfit = $totalIncome - $totalExpense;

        // Get monthly data for chart (last 6 months)
        $cashflowData = [];
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();

            $monthIncome = Finance::where('type', 'income')
                ->whereBetween('transaction_date', [$monthStart, $monthEnd])
                ->sum('amount');
            $monthExpense = Finance::where('type', 'expense')
                ->whereBetween('transaction_date', [$monthStart, $monthEnd])
                ->sum('amount');

            $months[] = $month->format('M');
            $cashflowData[] = [
                'income' => $monthIncome,
                'expense' => $monthExpense,
            ];
        }

        return view('livewire.admin.finance-manager', [
            'finances' => $query->paginate(15),
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'netProfit' => $netProfit,
            'months' => $months,
            'cashflowData' => $cashflowData,
        ])->layout('layouts.admin', ['title' => 'Laporan']);
    }
}
