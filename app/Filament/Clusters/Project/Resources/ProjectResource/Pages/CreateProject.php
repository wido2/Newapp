<?php

namespace App\Filament\Clusters\Project\Resources\ProjectResource\Pages;

use Filament\Actions;
use Filament\Support\Enums\Alignment;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Clusters\Project\Resources\ProjectResource;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl?? $this->getResource()::getUrl('index');
    }
    public function getFormActionsAlignment(): string|Alignment
    {
        return Alignment::Right;
    }
}
