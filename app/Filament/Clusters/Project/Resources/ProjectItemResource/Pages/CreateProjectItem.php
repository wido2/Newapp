<?php

namespace App\Filament\Clusters\Project\Resources\ProjectItemResource\Pages;

use App\Filament\Clusters\Project\Resources\ProjectItemResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Alignment;

class CreateProjectItem extends CreateRecord
{
    protected static string $resource = ProjectItemResource::class;
    public function getFormActionsAlignment(): string|Alignment
    {
        return Alignment::Right;
    }
}
