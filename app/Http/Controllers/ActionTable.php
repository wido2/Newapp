<?php

namespace App\Http\Controllers;

use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Http\Request;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;

class ActionTable extends Controller
{
    static function getActionTable():array{
        return[
            ActionGroup::make([

                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
                ->label('Hapus'),
            ])
        ];
    }
}
