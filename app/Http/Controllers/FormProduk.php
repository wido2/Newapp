<?php

namespace App\Http\Controllers;

use App\Models\Pajak;
use Filament\Forms\Components\Section;
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
            Section::make('Form Data Produks')
            ->collapsible()
            ->description('Detail Produk ')
            ->columns(4)
            ->schema([
                TextInput::make('nama')
                ->columnSpan(2)
                ->placeholder('Plat Ms 4\'x8\'')
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
                TextInput::make('harga_beli')
                ->live()
                ->numeric(
                )
                ,
                Select::make('pajak_id')
                ->relationship('pajak','nama')
                ->preload()
                ->searchable()
                ->createOptionForm(
                    PajakController::getFormPajak()
                )
                ->editOptionForm(PajakController::getFormpajak())
                ,
                Toggle::make('is_active')
                ->default(true),
                Textarea::make('deskripsi')
                ->columnSpanFull(),
    

            ]),
            // Add form components for the produk form
           
        ];
    }

    static function getTableProduk():array {
        return [
            // Add table columns for the produk table
            TextColumn::make('nama')->searchable()->sortable(),
            TextColumn::make('satuan.nama')
                ->searchable(),
            TextColumn::make('kategori.nama')
                ->searchable(),
            TextColumn::make('stok'),
            TextColumn::make('harga_beli')
            ->money('idr')
                ->sortable(),
            TextColumn::make('pajak.persentase')
            ->numeric()
            ->suffix(' %'),
            ToggleColumn::make('is_active')
                ->label('Aktif')
                ->sortable()
        ];
    }
}
