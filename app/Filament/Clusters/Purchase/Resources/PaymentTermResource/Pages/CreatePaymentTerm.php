<?php

namespace App\Filament\Clusters\Purchase\Resources\PaymentTermResource\Pages;

use App\Filament\Clusters\Purchase\Resources\PaymentTermResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePaymentTerm extends CreateRecord
{

    protected static string $resource = PaymentTermResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
