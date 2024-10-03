<?php

namespace App\Filament\Clusters\Purchase\Resources\PaymentTermResource\Pages;

use App\Filament\Clusters\Purchase\Resources\PaymentTermResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaymentTerm extends EditRecord
{
    protected static string $resource = PaymentTermResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
