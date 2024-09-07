<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Address;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Grouping\Group;
use App\Http\Controllers\FormAddress;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AddressResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AddressResource\RelationManagers;

class AddressResource extends Resource
{
    protected static ?string $model = Address::class;
    protected static ?string $navigationGroup = 'Data Customer / Vendor';

    protected static?string $navigationLabel = 'Alamat';
    protected static?string $navigationIcon = 'heroicon-o-map';
    protected static?string $pluralModelLabel = 'Data Alamat';


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
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListAddresses::route('/'),
            'create' => Pages\CreateAddress::route('/create'),
            'view' => Pages\ViewAddress::route('/{record}'),
            'edit' => Pages\EditAddress::route('/{record}/edit'),
        ];
    }
}
