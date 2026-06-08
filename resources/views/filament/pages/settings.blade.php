<x-filament-panels::page>

    {{-- adding form to page  calling save() from sittings.php--}}
    <x-filament-panels::form wire:submit='save'>
        {{$this->form}}
        {{-- adding action  --}}
        <x-filament-panels::form.actions :actions="$this->getFormActions()"/>
    </x-filament-panels::form>
    
</x-filament-panels::page>

