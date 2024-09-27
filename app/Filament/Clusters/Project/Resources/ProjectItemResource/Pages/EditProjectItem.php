<?php

namespace App\Filament\Clusters\Project\Resources\ProjectItemResource\Pages;

use App\Filament\Clusters\Project\Resources\ProjectItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectItem extends EditRecord
{
    protected static string $resource = ProjectItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
