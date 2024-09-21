<?php

namespace App\Filament\Clusters\Vendor\Resources\ClusterVendorResource\Pages;

use App\Filament\Clusters\Vendor\Resources\ClusterVendorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClusterVendors extends ListRecords
{
    protected static string $resource = ClusterVendorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Vendor'),
        ];
    }
}
