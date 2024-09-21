<?php

namespace App\Filament\Widgets;

use App\Models\HargaBarang;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TableHargaBarangWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    public function table(Table $table): Table
    
    {
        // $table=HargaBarang::all();
        return $table
        ->heading('Update Harga Terbaru ')
        ->striped()
        ->paginated(false)
            ->query(
                HargaBarang::query()->with('produk')->with('vendor')->orderBy('created_at','desc')->take(3)
                )
            ->columns([
                TextColumn::make('produk.nama')
                ->wrap(),
                TextColumn::make('vendor.nama'),
                // TextColumn::make('tahun_kemarin'),
                TextColumn::make('tahun_terbaru')
                ->label('Update')
                ->date('d F y')
                ->sinceTooltip(),
                // ->dateTooltip(),
                TextColumn::make('harga_kemarin')
                ->money('IDR',0,'id'),
                TextColumn::make('harga_terbaru')
                ->money('IDR',0,'id'),
                TextColumn::make('perubahan')
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
                ->sortable()
                ->numeric(null)
                ->money('IDR',0,'id'),

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

            ])
            ;
    }
}
