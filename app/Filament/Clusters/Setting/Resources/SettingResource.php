<?php

namespace App\Filament\Clusters\Setting\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Clusters\Setting;
use App\Models\Setting as pengaturan;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\SettingController;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Setting\Resources\SettingResource\Pages;
use App\Filament\Clusters\Setting\Resources\SettingResource\RelationManagers;

class SettingResource extends Resource
{
    protected static ?string $model = pengaturan::class;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    protected static ?int $navigationSort = 7;
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $cluster = Setting::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema(SettingController::getFormSetting());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(SettingController::getTableSetting())
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
