<?php

namespace App\Filament\Clusters\Barang\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Satuan;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Clusters\Barang;
use App\Http\Controllers\FormSatuan;
use Filament\Tables\Columns\TextColumn;
use Filament\Pages\SubNavigationPosition;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Barang\Resources\SatuanResource\Pages;
use App\Filament\Clusters\Barang\Resources\SatuanResource\RelationManagers;
use App\Http\Controllers\ActionTable;
use Filament\Actions\ActionGroup;

class SatuanResource extends Resource
{
    protected static ?string $model = Satuan::class;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $pluralModelLabel = 'Satuan';

    protected static ?string $cluster = Barang::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                FormSatuan::getFormSatuan()
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                ->searchable(),
                TextColumn::make('deskripsi')
                ->searchable()
                ->wrap(),
                ToggleColumn::make('is_active')->label('Aktif')
    
            ])
            ->filters([
                //
            ])
            ->actions(
            ActionTable::getActionTable())
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
            'index' => Pages\ListSatuans::route('/'),
            'create' => Pages\CreateSatuan::route('/create'),
            'edit' => Pages\EditSatuan::route('/{record}/edit'),
        ];
    }
}
