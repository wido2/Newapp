<?php

namespace App\Filament\Clusters\SuratJalan\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Kendaraan;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Clusters\SuratJalan;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\SuratJalan\Resources\KendaraanResource\Pages;
use App\Filament\Clusters\SuratJalan\Resources\KendaraanResource\RelationManagers;
use App\Http\Controllers\FormKendaraan;

class KendaraanResource extends Resource
{
    protected static ?string $model = Kendaraan::class;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $cluster = SuratJalan::class;

    public static function getNavigationBadge():?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                FormKendaraan::getFormKendaraan()
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(
                FormKendaraan::getTableKendaraan()
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
            'index' => Pages\ListKendaraans::route('/'),
            'create' => Pages\CreateKendaraan::route('/create'),
            'edit' => Pages\EditKendaraan::route('/{record}/edit'),
        ];
    }
}
