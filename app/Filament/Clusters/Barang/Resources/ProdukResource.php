<?php

namespace App\Filament\Clusters\Barang\Resources;

use layout;
use Filament\Forms;
use Filament\Tables;
use App\Models\Produk;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Clusters\Barang;
use Filament\Tables\Grouping\Group;
use App\Http\Controllers\FormProduk;
use App\Http\Controllers\ActionTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Pages\SubNavigationPosition;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Barang\Resources\ProdukResource\Pages;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use App\Filament\Clusters\Barang\Resources\ProdukResource\RelationManagers;
use Filament\Support\Enums\MaxWidth;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    protected static ?int $navigationSort = 2;
    protected static?string $pluralModelLabel = 'Data Produk';

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';

    protected static ?string $cluster = Barang::class;
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
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
        ->defaultSort('created_at','desc')
        ->groups([
            Group::make('nama'),
            Group::make('kategori.nama')
        ])
            ->columns(
                FormProduk::getTableProduk()
            )
            ->filtersFormWidth(MaxWidth::Medium)
            ->filtersFormMaxHeight('350px')
            ->filters([
                SelectFilter::make('kategori')
                ->relationship('kategori','nama')
                ->searchable()
                ->preload(),
                QueryBuilder::make()
                ->constraints([
                    TextConstraint::make('nama'),
                    TextConstraint::make('harga_beli')
                ],)
            ],layout: FiltersLayout::Modal)
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
