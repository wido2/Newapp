<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;

class PajakController extends Controller
{
    public static function getFormpajak():array{
        return [
            Section::make('Form Pajak')
                ->columns(4)
                ->schema([

                    TextInput::make('nama')
                    ->required(),
                    TextInput::make('kode')
                    ->required(),
                    TextInput::make('persentase')
                    ->suffix('%')
                    ->required()
                    ->numeric(),
                    Toggle::make('is_active')->default(true)->label('Status Aktif')->inlineLabel()
                ])
        ];
    }
    
    public static function getTablePajak():array {
        return [
            
            TextColumn::make('nama')->searchable(),
            TextColumn::make('kode')->searchable(),
            TextColumn::make('persentase')->searchable(),
            ToggleColumn::make('is_active')
        ];
    }
}
