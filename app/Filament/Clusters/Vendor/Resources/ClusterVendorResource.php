<?php

namespace App\Filament\Clusters\Vendor\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ClusterVendor;
use Filament\Resources\Resource;
use App\Filament\Clusters\Vendor;
use App\Models\Vendor as ModelsVendor;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Vendor\Resources\ClusterVendorResource\Pages;
use App\Filament\Clusters\Vendor\Resources\ClusterVendorResource\RelationManagers;
use App\Http\Controllers\ActionTable;
use App\Http\Controllers\VendorController;
use Filament\Tables\Filters\SelectFilter;

class ClusterVendorResource extends Resource
{
    protected static ?string $model = ModelsVendor::class;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    protected static ?int $navigationSort = 1;
    protected static?string $pluralModelLabel = 'Vendor'; 
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Vendor::class;

    public static function getNavigationBadge():?string
    {
        return static::getModel()::count();
    }
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

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
                SelectFilter::make('Kategory')
                ->searchable()
                ->preload()
                ->relationship('vendor_category','nama')
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
            'index' => Pages\ListClusterVendors::route('/'),
            'create' => Pages\CreateClusterVendor::route('/create'),
            'edit' => Pages\EditClusterVendor::route('/{record}/edit'),
        ];
    }
}
