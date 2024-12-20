<x-filament-panels::page>
    {{ $this->form }}
    {{ $this->table }}
    <x-filament::button type="primary" wire:click="sendMessage">
        Send Message
    </x-filament::button>
</x-filament-panels::page>
