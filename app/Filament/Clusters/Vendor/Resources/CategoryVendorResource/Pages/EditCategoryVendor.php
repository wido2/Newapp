<?php

namespace App\Filament\Clusters\Vendor\Resources\CategoryVendorResource\Pages;

use App\Filament\Clusters\Vendor\Resources\CategoryVendorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategoryVendor extends EditRecord
{
    protected static string $resource = CategoryVendorResource::class;

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
