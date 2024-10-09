<?php

namespace App\Filament\Clusters\Purchase\Resources\PurchaseOrderResource\Pages;

use Filament\Actions;
use Filament\Actions\EditAction;
use Filament\Infolists\Infolist;
use Illuminate\Contracts\View\View;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Clusters\Purchase\Resources\PurchaseOrderResource;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\ViewEntry;

class infoPO extends ViewRecord
{
    protected static string $resource = PurchaseOrderResource::class;
    
protected static ?string $title = 'Lihat Purchase Order ';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
        ->schema([
            Section::make('Purchase Order')
            ->icon('heroicon-o-shopping-bag')
            ->description('Lihat Detail Item Purchase Order')
            ->schema([
                // RepeatableEntry::make('items')
                // ->label('')
                
                // ->columnSpanFull()
                // ->schema([
                //     TextEntry::make('produk.nama'),
                //     TextEntry::make('quantity'),
                //     TextEntry::make('satuan.nama'),
                //     TextEntry::make('price')
                //     ->money('idr',0,'id'),
                //     // ->prefix('Rp.'),
                //     TextEntry::make('discount')
    
                // ])->columns(6)


                ViewEntry::make('')
                ->columnSpanFull()
                ->view('infolists.components.tabel-items') ,
                TextEntry::make('note')
                
                ])
            
        ]);
    }
}
