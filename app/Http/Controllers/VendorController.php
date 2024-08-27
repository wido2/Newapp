<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Http\Request;


class VendorController extends Controller
{
    static function getFormVendor(): array {
        return [
            Fieldset::make('Create Data Vendor')
            // ->description('data vendor')
            ->schema([
                TextInput::make('nama')
            ->required()
            ->placeholder('Nama Vendor / Perusahaan')
            ->label('Nama Vendor'),
            TextInput::make('npwp')
            ->label('NPWP / Nomow Pokok Wajib Pajak')
            ->mask('99.999.999.9-999.999')
            ->placeholder('99.999.999.9-999.999'),
            Textarea::make('alamat'),
            TextInput::make('telepon')
            ->label('Telepon')
            ->placeholder('081234567890'),
            TextInput::make('email')
            ->email()
            ->placeholder('email@example.com'),
            TextInput::make('website')
            ->placeholder('https://example.com')
            ->url()
            ->label('Website'),

            ])->columns(2),

            // Select::make('kontak_id')
            // ->label('Kontak Person')
            // ->relationship('kontak','nama')

        ];
    }

    static function getTableVendor():array{
        return [
            TextColumn::make('nama')->label('Nama Vendor'),
            Textcolumn::make('npwp')->label('NPWP'),
            Textcolumn::make('alamat')->label('Alamat'),
            Textcolumn::make('telepon')->label('Telepon'),
            Textcolumn::make('email')->label('Email'),
            Textcolumn::make('website')->label('Website'),
            // TextInput::make('kontak.nama')->label('Kontak Person'),
        ];
    }
}
