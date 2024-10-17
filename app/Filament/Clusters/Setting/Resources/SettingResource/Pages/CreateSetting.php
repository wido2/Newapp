<?php

namespace App\Filament\Clusters\Setting\Resources\SettingResource\Pages;

use App\Filament\Clusters\Setting\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSetting extends CreateRecord
{
    protected static string $resource = SettingResource::class;
}
