<?php

namespace App\Http\Controllers;

use Money\Money;
use Illuminate\Http\Request;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use Pelmered\FilamentMoneyField\Tables\Columns\MoneyColumn;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;

class FormProduk extends Controller
{
    static function getFormProduk():array{
        return [
            // Add form components for the produk form
            TextInput::make('nama')
            ->placeholder('Konsumable | Raw Material | Jasa ')
            ->required(),
            Select::make('satuan_id')
            ->searchable()
            ->createOptionForm(
                FormSatuan::getFormSatuan()
            )
            ->editOptionForm(FormSatuan::getFormSatuan())
            ->preload()
            ->placeholder('Pilih Satuan Barang')
            ->label('Satuan')
            ->relationship('satuan','nama'),
            Select::make('kategori_id')
            ->placeholder('Pilih Kategori ')
            ->searchable()
            ->preload()
            ->editOptionForm(FormKategori::getFormKategori())
            ->createOptionForm(FormKategori::getFormKategori())
            ->label('Kategori')
            ->relationship('kategori','nama'),
            TextInput::make('stok')
            ->numeric()
            ->default(1),
            MoneyInput::make('harga_beli')
            ->decimals(0),
            Toggle::make('is_active')
            ->default(true),
            Textarea::make('deskripsi')
            ->columnSpanFull(),

        ];
    }

    static function getTableProduk():array {
        return [
            // Add table columns for the produk table
            TextColumn::make('nama'),
            TextColumn::make('satuan.nama')
                ->searchable(),
            TextColumn::make('kategori.nama')
                ->searchable(),
            TextColumn::make('stok'),
            MoneyColumn::make('harga_beli')
                ->sortable(),
            ToggleColumn::make('is_active')
                ->label('Aktif')
                ->sortable()
        ];
    }
}
