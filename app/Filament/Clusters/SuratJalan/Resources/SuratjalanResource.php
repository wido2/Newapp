<?php

namespace App\Filament\Clusters\SuratJalan\Resources;

use App\Filament\Clusters\SuratJalan;
use App\Filament\Clusters\SuratJalan\Resources\SuratjalanResource\Pages;
use App\Filament\Clusters\SuratJalan\Resources\SuratjalanResource\RelationManagers;
use App\Models\Suratjalan as newSuratjalan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SuratjalanResource extends Resource
{
    protected static ?string $model = newSuratjalan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = SuratJalan::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
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
            'index' => Pages\ListSuratjalans::route('/'),
            'create' => Pages\CreateSuratjalan::route('/create'),
            'edit' => Pages\EditSuratjalan::route('/{record}/edit'),
        ];
    }
}
