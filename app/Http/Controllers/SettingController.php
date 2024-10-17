<?php

namespace App\Http\Controllers;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    
    public static function getFormSetting():array{
        return[
            TextInput::make('nama')
            ->required(),
            TextInput::make('npwp')
            ->label('NPWP / Nomow Pokok Wajib Pajak')
            ->mask('99.999.999.9-999.999')
            ->placeholder('99.999.999.9-999.999'),
            Textarea::make('alamat')->columnSpanFull(),
            FileUpload::make('logo')
            ->image()
            ->directory('setting')
            ->storeFileNamesIn('logo_file_names')
            ->visibility('public')
            ->maxFiles(1),

            TextInput::make('telepon')->maxLength(14),
            TextInput::make('email')->email(),
            TextInput::make('website')->url(),
            TextInput::make('alamat_pengiriman'),
            TextInput::make('nama_approver'),
            TextInput::make('nama_penerima'),
            TextInput::make('nomor_telepon_penerima')->maxLength(14),
        ];
    }
    public static function getTableSetting():array{
        return[
            TextColumn::make('nama'),
            TextColumn::make('npwp'),
            TextColumn::make('alamat'),
            ImageColumn::make('logo')->square(),
            TextColumn::make('telepon'),
            TextColumn::make('email'),
            TextColumn::make('website'),
            TextColumn::make('alamat_pengiriman'),
            TextColumn::make('nama_penerima'),
            TextColumn::make('nomor_telepon_penerima'),
            ];
    }
}
