<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Vendor;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;

use Filament\Resources\Resource;
use App\Http\Controllers\ActionTable;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\VendorController;
use App\Filament\Resources\VendorResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\VendorResource\RelationManagers;
use App\Filament\Resources\VendorResource\RelationManagers\BarangRelationManager;
use App\Filament\Resources\VendorResource\RelationManagers\KontakRelationManager;
use App\Filament\Resources\VendorResource\RelationManagers\KendaraanRelationManager;
use App\Filament\Resources\KendaraanResource\RelationManagers\SuratJalanRelationManager;

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
            BarangRelationManager::class,
            KontakRelationManager::class,
            KendaraanRelationManager::class,
            SuratJalanRelationManager::class
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
