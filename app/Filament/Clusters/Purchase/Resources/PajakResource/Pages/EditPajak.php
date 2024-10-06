<?php

namespace App\Filament\Clusters\Purchase\Resources\PajakResource\Pages;

use App\Filament\Clusters\Purchase\Resources\PajakResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPajak extends EditRecord
{
    protected static string $resource = PajakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
