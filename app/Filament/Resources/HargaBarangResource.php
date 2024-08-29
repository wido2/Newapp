<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HargaBarangResource\Pages;
use App\Filament\Resources\HargaBarangResource\RelationManagers;
use App\Http\Controllers\ActionTable;
use App\Http\Controllers\HargaBarangController;
use App\Models\HargaBarang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HargaBarangResource extends Resource
{
    protected static ?string $model = HargaBarang::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
            ->columns(HargaBarangController::getTableHargaBarang())
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
            'index' => Pages\ListHargaBarangs::route('/'),
            'create' => Pages\CreateHargaBarang::route('/create'),
            'view' => Pages\ViewHargaBarang::route('/{record}'),
            'edit' => Pages\EditHargaBarang::route('/{record}/edit'),
        ];
    }
}
