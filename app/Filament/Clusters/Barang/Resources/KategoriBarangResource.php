<?php

namespace App\Filament\Clusters\Barang\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Kategori;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Clusters\Barang;
use Filament\Tables\Columns\TextColumn;
use Filament\Pages\SubNavigationPosition;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Barang\Resources\KategoriBarangResource\Pages;
use App\Filament\Clusters\Barang\Resources\KategoriBarangResource\RelationManagers;
use App\Http\Controllers\ActionTable;
use App\Http\Controllers\FormKategori;
use Filament\Forms\Components\TextInput;

class KategoriBarangResource extends Resource
{
    protected static ?string $model = Kategori::class;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    protected static ?int $navigationSort = 3;
    protected static ?string $pluralModelLabel = 'Kategori Barang';
    
    protected static ?string $navigationIcon = 'heroicon-o-swatch';

    protected static ?string $cluster = Barang::class;

    public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}
    public static function form(Form $form): Form
    {
        return $form
            ->schema(FormKategori::getFormKategori());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('deskripsi')
                    ->searchable()
                    ->limit(50),
                ToggleColumn::make('is_active')->label('Aktif')
            ])
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
            'index' => Pages\ListKategoriBarangs::route('/'),
            'create' => Pages\CreateKategoriBarang::route('/create'),
            'edit' => Pages\EditKategoriBarang::route('/{record}/edit'),
        ];
    }
}
