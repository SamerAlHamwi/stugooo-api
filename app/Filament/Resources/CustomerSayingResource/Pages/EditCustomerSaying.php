<?php

namespace App\Filament\Resources\CustomerSayingResource\Pages;

use App\Filament\Resources\CustomerSayingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerSaying extends EditRecord
{
    protected static string $resource = CustomerSayingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
