<?php

namespace App\Http\Controllers;

use Filament\Forms\Set;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Filament\Forms\Components\Toggle;
use function Laravel\Prompts\textarea;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class FormKategori extends Controller
{
    static function getFormKategori():array{
            return [
                TextInput::make('nama')
                ->required()
                ->afterStateUpdated(
                    function (Set $set, $state){
                        $set('slug',Str::slug($state));
                    }
                )
                ->live(onBlur:true)
                ->maxLength(50),
                TextInput::make('slug')
                ->required()
                ->readOnly()
                ->maxLength(50)
                ->unique(),
                Textarea::make('deskripsi')
                ->columnSpanFull()
                // ->required()
                ->maxLength(255),
                Toggle::make('is_active')
                ->default(true),
            ];
    }
}
