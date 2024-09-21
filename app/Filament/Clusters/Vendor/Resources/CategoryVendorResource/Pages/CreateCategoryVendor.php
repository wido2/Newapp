<?php

namespace App\Filament\Clusters\Vendor\Resources\CategoryVendorResource\Pages;

use App\Filament\Clusters\Vendor\Resources\CategoryVendorResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateCategoryVendor extends CreateRecord
{
    protected static string $resource = CategoryVendorResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
    public function getCreatedNotification(): ?Notification{
        return
        Notification::make('Category Vendor has been created successfully.')
        ->success()
        ->title('Add Kategory')
        ->body('Tambah Kategory Berhasil ');
    }
}
