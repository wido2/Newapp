<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class FormCustomer extends Controller
{
    static function getFormCustomer():array{
        return [
            TextInput::make('nama')
            ->required()
            ->label('Nama Perusahaan')
            ->placeholder('PT. Maju Kita Bisa'),
            TextInput::make('npwp')
            ->label('NPWP / Nomow Pokok Wajib Pajak')
            ->mask('99.999.999.9-999.999')
            ->placeholder('99.999.999.9-999.999'),
            Textarea::make('deskripsi')
            ->columnSpanFull()

        ];
    }
    static function getTableCustomer():array {
        return [
            TextColumn::make('nama'),
            TextColumn::make('npwp'),
            TextColumn::make('deskripsi')
            ->limit(76)
        ];
    }
}
