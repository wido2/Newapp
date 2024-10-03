<?php

namespace App\Filament\Clusters\Purchase\Resources\PaymentTermResource\Pages;

use App\Filament\Clusters\Purchase\Resources\PaymentTermResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPaymentTerms extends ListRecords
{
    protected static string $resource = PaymentTermResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
