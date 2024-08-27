<?php

namespace App\Http\Controllers;

use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\HargaBarang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;

class HargaBarangController extends Controller
{
    static function getFormHargaBarang():array{
        return[
            Fieldset::make('Form Harga Barang')
            // ->collapsible()
            // ->description('Harga Beli / Perubahan Harga  ')
            ->columns(3)
            ->schema([
                
            Select::make('produk_id')
            ->columnSpan(2)
            ->label('Nama Produk')
            ->relationship('produk','nama')
            ->preload()
            ->searchable()
            ->editOptionForm(FormProduk::getFormProduk())
            ->createOptionForm(FormProduk::getFormProduk()),

            Select::make('vendor_id')
            ->label('Vendor')
            ->relationship('vendor','nama')
            ->preload()
            ->editOptionForm(VendorController::getFormVendor())
            ->createOptionForm(VendorController::getFormVendor())
            ->searchable(),
            MoneyInput::make('harga_kemarin')
            ->currency('IDR')
            ->label('Harga Kemarin')
            ->default(
                
                // Produk::all()->last()

            )
            ->readOnly(),
            DatePicker::make('tahun_kemarin')
            ->default(
                function (Get $get): string{
                    return HargaBarang::where('produk_id', $get('produk_id'))
                        ->where('vendor_id', $get('vendor_id'))
                        ->orderBy('created_at', 'desc')
                        ->first()
                        ->tahun_kemarin?? date('Y');
                }
            )
            ->label('Tahun Kemarin'),
            MoneyInput::make('harga_terbaru')
            ->currency('IDR')
            ->live()
            ->label('Harga Terbaru')
            ->afterStateUpdated(
                function (Get $get, Set $set,$state) {
                    $perubahan = $state - $get('harga_kemarin');
                    $set('status_perubahan', ($perubahan / $get('harga_kemarin')) * 100);
                }
            ),
            
            DatePicker::make('tahun_terbaru')
            ->label('Tahun Terbaru')
            ->live()
            ->default(date(now())),
            MoneyInput::make('perubahan')
            ->reactive()
            ->live()
            ->currency('IDR')
            ->label('Selisih Harga')
           ,
            TextInput::make('status_perubahan')
            ->label('Status Perubahan %')
            ->readOnly()
          

            
        ]),

        ];
    }
}
