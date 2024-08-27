<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Produk;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Http\Controllers\FormProduk;
use App\Http\Controllers\ActionTable;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProdukResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProdukResource\RelationManagers;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;
    protected static ?string $navigationGroup = 'Data Barang';
    protected static?string $navigationLabel = 'Nama Produk';
    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';
    protected static?string $pluralModelLabel = 'Data Produk';


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
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'view' => Pages\ViewProduk::route('/{record}'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}
