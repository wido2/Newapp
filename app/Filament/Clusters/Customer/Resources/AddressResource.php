<?php

namespace App\Filament\Clusters\Customer\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Address;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Clusters\Customer;
use Filament\Tables\Grouping\Group;
use App\Http\Controllers\FormAddress;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Customer\Resources\AddressResource\Pages;
use App\Filament\Clusters\Customer\Resources\AddressResource\RelationManagers;
use App\Http\Controllers\ActionTable;

class AddressResource extends Resource
{
    protected static ?string $model = Address::class;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static?string $navigationLabel = 'Alamat';

    protected static ?string $cluster = Customer::class;

    public static function form(Form $form): Form
    {
        return $form
        ->schema(
            FormAddress::getFormAddress()
        );
    }

    public static function table(Table $table): Table
    {
        return $table
        ->defaultGroup('customer.nama')
        ->defaultSort('customer_id', 'desc')
        ->groups([
            Group::make('customer.nama')
            ->collapsible()               
             ->orderQueryUsing(fn (Builder $query, string $direction) => $query->orderBy('is_primary', $direction))

            ->label('Customer')
            // ->getTitleFromRecordUsing('customer.nama')
        ])
            ->columns(
                FormAddress::getTableAddress()
            )
            ->filters([
                //
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
            'index' => Pages\ListAddresses::route('/'),
            'create' => Pages\CreateAddress::route('/create'),
            'edit' => Pages\EditAddress::route('/{record}/edit'),
        ];
    }
}
