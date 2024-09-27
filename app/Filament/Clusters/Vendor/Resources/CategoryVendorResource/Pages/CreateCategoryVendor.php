<?php

namespace App\Filament\Clusters\Vendor\Resources\CategoryVendorResource\Pages;

use auth;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Clusters\Vendor\Resources\CategoryVendorResource;

class CreateCategoryVendor extends CreateRecord
{
    protected static string $resource = CategoryVendorResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
    public function toDatabase( $notifiable): array
    {
        return Notification::make()
            ->title('Saved successfully')
            ->getDatabaseMessage();
    }
}
