<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Redirect;

class VendorController extends Controller
{
    static function getFormVendor(): array {
        return [
            Section::make('Vendor')
            ->description('Data vendor')
            ->columns(4)
            ->schema([
                Fieldset::make('Create Data Vendor')
                ->columnSpan(3)
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
                Select::make('vendor_category_id')
                ->columnSpan(1)
                ->required()
                ->editOptionForm(VendorCategoryController::getformcategoryvendor())
                ->createOptionForm(VendorCategoryController::getformcategoryvendor())
                ->relationship('vendor_category','nama')
                ->preload()
                ->searchable()
                ->label('Kategori Vendor'),
            ]),
            
            
            // Select::make('kontak_id')
            // ->label('Kontak Person')
            // ->relationship('kontak','nama')

        ];
    }

    static function getTableVendor():array{
        return [
            TextColumn::make('nama')
            ->searchable()
            ->copyable()->label('Nama Vendor'),
            TextColumn::make('vendor_category.nama')->label('Kategori')->searchable(),
            Textcolumn::make('npwp')->searchable()
            ->copyable()->label('NPWP'),
            Textcolumn::make('alamat')->searchable()
            ->copyable()
            ->copyMessage('Berhasil di Copy')->label('Alamat'),
            Textcolumn::make('telepon')->searchable()
            ->url(
                function (TextColumn $column, $record) {
                    return 'https://wa.me/'.Str::replaceFirst('0', '62', $record->telepon);
                }
            )
            ->label('Telepon'),
            Textcolumn::make('email')->label('Email'),
            Textcolumn::make('website')->label('Website')->toggleable(
                isToggledHiddenByDefault: true
            ),
            // TextInput::make('kontak.nama')->label('Kontak Person'),
        ];
    }
}
