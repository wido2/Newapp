<?php

namespace App\Filament\Clusters\Purchase\Resources\PurchaseOrderResource\Pages;

use Filament\Actions;
use Filament\Support\Enums\Alignment;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Clusters\Purchase\Resources\PurchaseOrderResource;
use App\Http\Controllers\nomorPO;
use App\Models\PurchaseOrder;

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
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['nomor_po']=nomorPO::generate(PurchaseOrder::count()+1);
        return $data;
    }
}
