<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Kontak;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Http\Controllers\FormKontak;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\KontakResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KontakResource\RelationManagers;
use App\Http\Controllers\ActionTable;

class KontakResource extends Resource
{
    protected static ?string $model = Kontak::class;
    protected static ?string $navigationGroup = 'Data Customer / Vendor';
    protected static?string $navigationLabel = 'Kontak Person';
    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static?string $pluralModelLabel = 'Contact Person Customer';


    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                FormKontak::getFormKontak()
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(
                FormKontak::getTableKontak()
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
            'index' => Pages\ListKontaks::route('/'),
            'create' => Pages\CreateKontak::route('/create'),
            'view' => Pages\ViewKontak::route('/{record}'),
            'edit' => Pages\EditKontak::route('/{record}/edit'),
        ];
    }
}
