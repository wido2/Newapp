<?php

namespace App\Filament\Clusters\Customer\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Kontak;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Clusters\Customer;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Customer\Resources\KontakResource\Pages;
use App\Filament\Clusters\Customer\Resources\KontakResource\RelationManagers;
use App\Http\Controllers\ActionTable;
use App\Http\Controllers\FormKontak;

class KontakResource extends Resource
{
    protected static?string $navigationLabel = 'Kontak';

    protected static ?string $model = Kontak::class;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $cluster = Customer::class;
    public static function getNavigationBadge():?string
    {
        return static::getModel()::count();
    }

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
            ->columns(FormKontak::getTableKontak())
            ->filters([
                
            ])
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
            'index' => Pages\ListKontaks::route('/'),
            'create' => Pages\CreateKontak::route('/create'),
            'edit' => Pages\EditKontak::route('/{record}/edit'),
        ];
    }
}
