<?php

namespace App\Filament\Clusters\Barang\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Produk;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Clusters\Barang;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Barang\Resources\ProdukResource\Pages;
use App\Filament\Clusters\Barang\Resources\ProdukResource\RelationManagers;
use App\Http\Controllers\ActionTable;
use App\Http\Controllers\FormProduk;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    protected static ?int $navigationSort = 2;
    protected static?string $pluralModelLabel = 'Data Produk';

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';

    protected static ?string $cluster = Barang::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
            FormProduk::getFormProduk()
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(
                FormProduk::getTableProduk()
            )
            ->filters([
                //
            ])
            ->actions(ActionTable::getActionTable())
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
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}
