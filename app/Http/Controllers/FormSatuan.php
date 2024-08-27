<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;

class FormSatuan extends Controller
{
    static function getFormSatuan():array{
            return [

                TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                TextInput::make('deskripsi')
                    ->required()
                    ->maxLength(255),
                Toggle::make('is_active')
                    ->default(true),
        
            ];
    }
}
