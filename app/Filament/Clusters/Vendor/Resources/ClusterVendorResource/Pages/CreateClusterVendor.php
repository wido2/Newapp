<?php

namespace App\Filament\Clusters\Vendor\Resources\ClusterVendorResource\Pages;

use App\Filament\Clusters\Vendor\Resources\ClusterVendorResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateClusterVendor extends CreateRecord
{
    protected static string $resource = ClusterVendorResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
