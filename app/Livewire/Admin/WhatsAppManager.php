<?php

namespace App\Livewire\Admin;

use App\Models\Tenant;
use App\Models\WhatsAppMessage;
use App\Models\WhatsAppSetting;
use Livewire\Component;

class WhatsAppManager extends Component
{
    public $activeTab = 'pesan';
    public $selectedTenant = null;
    public $search = '';
    public $message = '';
    public $isConfigured = false;

    public function mount()
    {
        $setting = WhatsAppSetting::first();
        $this->isConfigured = $setting && $setting->is_connected;
    }

    public function render()
    {
        $tenants = Tenant::with(['room', 'property'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhereHas('room', function ($q) {
                          $q->where('room_number', 'like', '%' . $this->search . '%');
                      });
            })
            ->orderBy('name')
            ->get();

        $selectedTenantData = null;
        $messages = [];

        if ($this->selectedTenant) {
            $selectedTenantData = Tenant::with(['room', 'property'])->find($this->selectedTenant);
            $messages = WhatsAppMessage::where('tenant_id', $this->selectedTenant)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('livewire.admin.whatsapp-manager', [
            'tenants' => $tenants,
            'selectedTenantData' => $selectedTenantData,
            'messages' => $messages,
        ])->layout('layouts.admin', ['title' => 'WhatsApp']);
    }

    public function selectTenant($tenantId)
    {
        $this->selectedTenant = $tenantId;
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function sendMessage()
    {
        if (!$this->message || !$this->selectedTenant) {
            return;
        }

        WhatsAppMessage::create([
            'tenant_id' => $this->selectedTenant,
            'message' => $this->message,
            'status' => 'sent',
            'direction' => 'out',
            'sent_at' => now(),
        ]);

        $this->message = '';
        session()->flash('message', 'Pesan berhasil dikirim!');
    }
}
