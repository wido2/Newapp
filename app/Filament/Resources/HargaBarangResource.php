<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Produk;
use App\Models\Vendor;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\HargaBarang;
use Filament\Resources\Resource;
use Filament\Tables\Grouping\Group;
use App\Http\Controllers\ActionTable;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\HargaBarangController;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\HargaBarangResource\Pages;
use App\Filament\Resources\HargaBarangResource\RelationManagers;

class HargaBarangResource extends Resource
{
    protected static ?string $model = HargaBarang::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                HargaBarangController::getFormHargaBarang()
            );
    }

    public static function table(Table $table): Table
    {
        return $table
        ->defaultGroup('vendor.nama')   
        ->groups([
            Group::make('vendor.nama')
            
            // ->groupQueryUsing('')
            // ->groupQuery()
            
            ->collapsible()               
             ->orderQueryUsing(fn (Builder $query, string $direction) => $query->orderBy('tahun_terbaru', 'desc')->orderBy('id',$direction))

            ->label('Vendor')
            // ->getTitleFromRecordUsing('vendor.nama')
        ])
            ->columns(HargaBarangController::getTableHargaBarang()
            )
            ->filters(
                HargaBarangController::getFilterHargaBarang()
            )
            ->actions(
                ActionTable::getActionTable()
            )
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHargaBarangs::route('/'),
            'create' => Pages\CreateHargaBarang::route('/create'),
            'view' => Pages\ViewHargaBarang::route('/{record}'),
            'edit' => Pages\EditHargaBarang::route('/{record}/edit'),
        ];
    }
}
