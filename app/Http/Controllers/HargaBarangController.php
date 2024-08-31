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
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
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
                    MoneyInput::make('perubahan')
                    // ->numeric()
                    
                    ->live(onBlur:true)
                    ->prefix('Rp')
                    ->label('Perubahan Harga')
                    ->readOnly()
                    ->prefixIconColor(
                        function($state){
                            if ($state>1){
                                return 'danger';
                            } elseif ($state<1){
                                return 'success';
                            } else {
                                return 'info';
                            }
                        }
                    )
                    ->prefixIcon(
                        function($state){
                            if ($state>1){
                                return 'heroicon-o-arrow-trending-up';
                            } elseif ($state<1){
                                return 'heroicon-o-arrow-trending-down';
                            } else {
                                return 'heroicon-o-check-circle';
                            }
                        }
                    ),
                    TextInput::make('status_perubahan')
                    ->suffix('% ')
                    ->label('Status Perubahan %')->readOnly(),
                    TextInput::make('keterangan')
                    ->maxLength(255)
                    ->columnSpanFull(),
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
            ->sortable()
            ->toggleable(
                isToggledHiddenByDefault: true
            ),
            TextColumn::make('tahun_terbaru')
            ->sortable()
            ->toggleable(
                isToggledHiddenByDefault: true
            ),
            TextColumn::make('harga_kemarin')
            // ->currency('idr')
            ->money('idr',0,'id')
            ->sortable(),
            TextColumn::make('harga_terbaru')
            // ->currency('idr')
            ->money('idr',0,'id')

            ->sortable(),
            TextColumn  ::make('perubahan')
            // ->currency('idr')
            ->money('idr',0,'id')

            ->color(
                function ($state){
                    if ($state>1){
                        return 'danger';
                    } elseif ($state<1){
                        return'success';
                    } else {
                        return 'info';
                    }
                }
            )
            ->icon(
                function ($state ){
                    if ($state>1){
                        return 'heroicon-o-arrow-trending-up';
                    }else
                    if ($state<0){
                        return 'heroicon-o-arrow-trending-down';
                    }
                }
            )
            ->sortable(),
            TextColumn::make('status_perubahan')
            ->label('Change %')
            ->suffix('%')
            ->numeric()
            ->color(
                function ($state){
                    if ($state>1){
                        return 'danger';
                    } elseif ($state<1){
                        return'success';
                    } else {
                        return 'info';
                    }
                }
            )
            ->sortable(),
            TextColumn::make('keterangan')
            ->limit(50)
            ->toggleable(
                isToggledHiddenByDefault: true
            ),
        ];
    }
    static function getFilterHargaBarang(): array{
        return [
            SelectFilter::make('produk_id')
                ->label('Produk')
                ->relationship('produk', 'nama')
                ->preload()
                ->searchable(),
            SelectFilter::make('vendor_id')
                ->label('Vendor')
                ->relationship('vendor', 'nama')
                ->preload()
                ->searchable(),
           
        ];
    }
}
