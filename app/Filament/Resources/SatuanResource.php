<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Satuan;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Http\Controllers\FormSatuan;
use App\Http\Controllers\ActionTable;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SatuanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SatuanResource\RelationManagers;

class SatuanResource extends Resource
{
    protected static ?string $model = Satuan::class;
    protected static ?string $navigationGroup = 'Data Barang';
    protected static?string $navigationLabel = 'Satuan Barang';
    protected static?string $pluralModelLabel = 'List Satuan Barang';

    protected static ?string $navigationIcon = 'heroicon-o-scale';

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
            TextColumn::make('nama'),
            TextColumn::make('deskripsi'),
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
            'index' => Pages\ListSatuans::route('/'),
            'create' => Pages\CreateSatuan::route('/create'),
            'view' => Pages\ViewSatuan::route('/{record}'),
            'edit' => Pages\EditSatuan::route('/{record}/edit'),
        ];
    }
}
