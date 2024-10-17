<?php

namespace App\Filament\Clusters\Setting\Resources\SettingResource\Pages;

use Filament\Actions;
use App\Models\Setting;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Clusters\Setting\Resources\SettingResource;

class ListSettings extends ListRecords
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->hidden(
                function (){
                    $checkrecordisExist=Setting::find(1);
                    if($checkrecordisExist){
                        return  true;
                    }
                }
            ),
        ];
    }
}
