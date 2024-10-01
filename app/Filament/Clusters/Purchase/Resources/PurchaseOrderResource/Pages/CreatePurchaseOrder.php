<?php

namespace App\Filament\Clusters\Purchase\Resources\PurchaseOrderResource\Pages;

use Filament\Actions;
use Filament\Support\Enums\Alignment;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Clusters\Purchase\Resources\PurchaseOrderResource;

class CreatePurchaseOrder extends CreateRecord
{
    protected static string $resource = PurchaseOrderResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
    public function getFormActionsAlignment(): string|Alignment
    {
        return Alignment::Right;
    }
}
