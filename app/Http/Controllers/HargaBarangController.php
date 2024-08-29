<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\HargaBarang;
use Illuminate\Http\Request;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use Pelmered\FilamentMoneyField\Tables\Columns\MoneyColumn;

class HargaBarangController extends Controller
{
    static function getFormHargaBarang(): array
    {
        return [
            Fieldset::make('Form Harga Barang')
                // ->collapsible()
                // ->description('Harga Beli / Perubahan Harga  ')
                ->columns(3)
                ->schema([
                    Select::make('produk_id')->columnSpan(2)->label('Nama Produk')->relationship('produk', 'nama')->preload()->live()->searchable()->editOptionForm(FormProduk::getFormProduk())->createOptionForm(FormProduk::getFormProduk()),

                    Select::make('vendor_id')
                        ->label('Vendor')
                        ->relationship('vendor', 'nama')
                        ->preload()
                        ->hidden(fn(Get $get): bool => !$get('produk_id'))
                        // ->live()
                        ->afterStateUpdated(function (Set $set, Get $get) {
                            $a = Produk::find($get('produk_id'));
                            $b = HargaBarang::where('produk_id', $get('produk_id'))->where('vendor_id', $get('vendor_id'))->latest()->first();

                            if ($a and $b) {
                                $set('harga_kemarin', $b->harga_terbaru);
                            } else {
                                $set('harga_kemarin', $a->harga_beli);
                            }
                        })

                        ->editOptionForm(VendorController::getFormVendor())
                        ->createOptionForm(VendorController::getFormVendor())
                        ->searchable(),
                    TextInput::make('harga_kemarin')
                        ->numeric()
                        ->prefix('Rp')
                        ->readOnly(),
                    DatePicker::make('tahun_kemarin')
                        ->default(function (Get $get): string {
                            return HargaBarang::where('produk_id', $get('produk_id'))->where('vendor_id', $get('vendor_id'))->orderBy('created_at', 'desc')->first()->tahun_kemarin ?? date('Y');
                        })
                        ->label('Tahun Kemarin'),

                    TextInput::make('harga_terbaru')->numeric()->prefix('Rp')// ->live()
                    ->label('Harga Terbaru')
                    // ->live()
                    ->live(onBlur:true)
                    ->afterStateUpdated(
                        function(Set $set,Get $get){
                            $a=$get('harga_kemarin');
                            $perubahanharga=$get('harga_terbaru')-$a;
                            $set('perubahan',$perubahanharga);
                        }
                    )
                    ->afterStateUpdated(
                        function(Set $set,Get $get){
                            $a=$get('harga_kemarin');
                            $b=$get('harga_terbaru');
                            $perubahanharga=($b-$a)/$a*100;
                            $set('status_perubahan',round($perubahanharga,2));
                        }
                    )
                    ,
                    DatePicker::make('tahun_terbaru')
                        ->label('Tahun Terbaru')
                        // ->live()
                        ->default(date(now()))
                     ,
                    TextInput::make('perubahan')
                    ->numeric()
                    ->live(onBlur:true)
                    ->prefix('Rp')
                    ->label('Perubahan Harga')
                    ->readOnly()
                    ,
                    TextInput::make('status_perubahan')
                    ->suffix('% ')
                    ->label('Status Perubahan %')->readOnly(),
                ]),
        ];
    }
    static function getTableHargaBarang(): array {
        return [
            TextColumn::make('produk.nama')
            ->searchable()
            ->label('Produk'),
            TextColumn::make('vendor.nama')
            ->searchable(),
            TextColumn::make('tahun_kemarin')
            ->sortable(),
            MoneyColumn::make('harga_kemarin')
            ->currency('idr')
            ->sortable(),
            MoneyColumn::make('harga_terbaru')
            ->currency('idr')
            ->sortable(),
            MoneyColumn::make('perubahan')
            ->currency('idr')
            ->sortable(),
            TextColumn::make('status_perubahan')
            ->label('Change %')
            ->suffix('%')
            ->numeric()
            ->sortable(),
        ];
    }
}
