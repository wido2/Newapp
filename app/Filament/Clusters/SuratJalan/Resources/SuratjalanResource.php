<?php

namespace App\Filament\Clusters\SuratJalan\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Clusters\SuratJalan;
use App\Filament\Clusters\SuratJalan\Resources\SuratjalanResource\infoSuratJalan;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Database\Eloquent\Builder;
use App\Models\SuratJalan as newSuratjalan;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Http\Controllers\SuratJalan as ControllersSuratJalan;
use App\Filament\Clusters\SuratJalan\Resources\SuratjalanResource\Pages;
use App\Filament\Clusters\SuratJalan\Resources\SuratjalanResource\RelationManagers;
use Illuminate\Database\Eloquent\Model;

class SuratjalanResource extends Resource
{
    protected static ?string $model = newSuratjalan::class;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    protected static ?int $navigationSort = 1;
    protected static?string $pluralModelLabel = 'Surat Jalan'; 
    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    protected static ?string $cluster = SuratJalan::class;

    public static function getNavigationBadge():?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                ControllersSuratJalan::getFormSuratJalan()
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(fn (Model $record):string=>infoSuratJalan::getUrl([$record->id]))
            ->columns(
                ControllersSuratJalan::getTableSuratJalan()
            )
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
            'view'=>infoSuratJalan::route('/{record}'),
            'create' => Pages\CreateSuratjalan::route('/create'),
            'edit' => Pages\EditSuratjalan::route('/{record}/edit'),
        ];
    }
}
