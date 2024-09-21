<?php

namespace App\Filament\Clusters\Vendor\Resources\CategoryVendorResource\Pages;

use App\Filament\Clusters\Vendor\Resources\CategoryVendorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategoryVendors extends ListRecords
{
    protected static string $resource = CategoryVendorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make('s')->label('Tambah Kategory Vendor'),
        ];
    }
}
