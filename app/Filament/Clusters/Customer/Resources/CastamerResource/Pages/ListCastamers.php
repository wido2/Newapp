<?php

namespace App\Filament\Clusters\Customer\Resources\CastamerResource\Pages;

use App\Filament\Clusters\Customer\Resources\CastamerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCastamers extends ListRecords
{
    protected static string $resource = CastamerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
