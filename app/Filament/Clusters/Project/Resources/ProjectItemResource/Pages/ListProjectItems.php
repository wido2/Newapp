<?php

namespace App\Filament\Clusters\Project\Resources\ProjectItemResource\Pages;

use App\Filament\Clusters\Project\Resources\ProjectItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectItems extends ListRecords
{
    protected static string $resource = ProjectItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
