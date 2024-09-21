<?php

namespace App\Filament\Clusters\Vendor\Resources\ClusterVendorResource\Pages;

use App\Filament\Clusters\Vendor\Resources\ClusterVendorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClusterVendor extends EditRecord
{
    protected static string $resource = ClusterVendorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
