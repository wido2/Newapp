<?php

namespace App\Filament\Clusters\Customer\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Clusters\Customer;
use App\Models\Customer as Kastamer;
use App\Http\Controllers\FormCustomer;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Customer\Resources\CastamerResource\Pages;
use App\Filament\Clusters\Customer\Resources\CastamerResource\RelationManagers;
use App\Filament\Resources\CustomerResource\RelationManagers\KontakRelationManager;
use App\Filament\Resources\CustomerResource\RelationManagers\AddressRelationManager;
use App\Filament\Resources\CustomerResource\RelationManagers\ProjectRelationManager;

class CastamerResource extends Resource
{
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $model = Kastamer::class;
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static?string $navigationLabel = 'Customer';

    protected static ?string $cluster = Customer::class;
    public static function getNavigationBadge():?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                FormCustomer::getFormCustomer()
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(FormCustomer::getTableCustomer())
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
            
            KontakRelationManager::class,
            AddressRelationManager::class,
            ProjectRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCastamers::route('/'),
            'create' => Pages\CreateCastamer::route('/create'),
            'edit' => Pages\EditCastamer::route('/{record}/edit'),
        ];
    }
}
