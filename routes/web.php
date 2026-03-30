<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\BookingManager;
use App\Livewire\Admin\FinanceManager;
use App\Livewire\Admin\CommentModerator;
use App\Livewire\Admin\RoomSettings;
use App\Livewire\Admin\PropertyManager;
use App\Livewire\Admin\RoomManager;
use App\Livewire\Admin\TenantManager;
use App\Livewire\Admin\InvoiceManager;
use App\Livewire\Admin\PaymentManager;
use App\Livewire\Admin\ExpenseManager;
use App\Livewire\Admin\TemplateInventoryManager;
use App\Livewire\Admin\WhatsAppManager;

Route::get('/', function () {
    return view('welcome');
});

// Admin Routes (requires authentication)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', Dashboard::class)->name('admin.dashboard');
    Route::get('/properties', PropertyManager::class)->name('admin.properties');
    Route::get('/kamar', RoomManager::class)->name('admin.kamar');
    Route::get('/penyewa', TenantManager::class)->name('admin.penyewa');
    Route::get('/tagihan', InvoiceManager::class)->name('admin.tagihan');
    Route::get('/pembayaran', PaymentManager::class)->name('admin.pembayaran');
    Route::get('/pengeluaran', ExpenseManager::class)->name('admin.pengeluaran');
    Route::get('/inventaris', TemplateInventoryManager::class)->name('admin.inventaris');
    Route::get('/bookings', BookingManager::class)->name('admin.bookings');
    Route::get('/finances', FinanceManager::class)->name('admin.finances');
    Route::get('/laporan', FinanceManager::class)->name('admin.laporan');
    Route::get('/whatsapp', WhatsAppManager::class)->name('admin.whatsapp');
    Route::get('/comments', CommentModerator::class)->name('admin.comments');
    Route::get('/settings', RoomSettings::class)->name('admin.settings');
    Route::get('/finances/export', function () {
        $finances = \App\Models\Finance::latest()->get();
        $filename = "laporan_keuangan_sewavip_" . date('Y-m-d') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
        $columns = ['Tanggal', 'Jenis', 'Nominal', 'Keterangan'];
        $callback = function() use($finances, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($finances as $row) {
                fputcsv($file, [
                    $row->transaction_date->format('Y-m-d'),
                    $row->type === 'income' ? 'Pemasukan' : 'Pengeluaran',
                    $row->amount,
                    $row->description
                ]);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    })->name('admin.finances.export');
});

Route::post('/logout', function () {
    Auth::guard('web')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

require __DIR__.'/auth.php';
