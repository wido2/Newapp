<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Vendor;
use Filament\Forms\Form;
use Filament\Tables\Table;

use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\VendorController;
use App\Filament\Resources\VendorResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\VendorResource\RelationManagers;
use App\Filament\Resources\VendorResource\RelationManagers\KendaraanRelationManager;
use App\Filament\Resources\VendorResource\RelationManagers\KontakRelationManager;

class VendorResource extends Resource
{
    protected static ?string $model = Vendor::class;
    protected static ?string $navigationGroup = 'Data Customer / Vendor';

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                VendorController::getFormVendor()
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(
                VendorController::getTableVendor()
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
            KontakRelationManager::class,
            KendaraanRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVendors::route('/'),
            'create' => Pages\CreateVendor::route('/create'),
            'view' => Pages\ViewVendor::route('/{record}'),
            'edit' => Pages\EditVendor::route('/{record}/edit'),
        ];
    }
}
