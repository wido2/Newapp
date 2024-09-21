<?php

namespace App\Filament\Clusters\Customer\Resources\AddressResource\Pages;

use App\Filament\Clusters\Customer\Resources\AddressResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAddresses extends ListRecords
{
    protected static string $resource = AddressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Tambah Alamat'),
        ];
    }
}
