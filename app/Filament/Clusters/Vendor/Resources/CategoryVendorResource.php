<?php

namespace App\Filament\Clusters\Vendor\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CategoryVendor;
use App\Models\VendorCategory;
use Filament\Resources\Resource;
use App\Filament\Clusters\Vendor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SubNavigationPosition;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Vendor\Resources\CategoryVendorResource\Pages;
use App\Filament\Clusters\Vendor\Resources\CategoryVendorResource\RelationManagers;
use Filament\Forms\Components\Grid;

class CategoryVendorResource extends Resource
{
    protected static ?string $model = VendorCategory::class;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    protected static ?int $navigationSort = 2;
    protected static?string $pluralModelLabel = 'Ketegory Vendor'; 

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Vendor::class;
    public static function getNavigationBadge():?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
        ->columns(3)
            ->schema([
              Grid::make()
              ->schema([

                TextInput::make('nama')
                ->required(),
                Textarea::make('deskripsi'),
                Toggle::make('is_active')
                ->default(true)
              ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->searchable(),
                TextColumn::make('deskripsi')->searchable(),
                ToggleColumn::make('is_active')->label('Aktif')
            ])
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
            'index' => Pages\ListCategoryVendors::route('/'),
            'create' => Pages\CreateCategoryVendor::route('/create'),
            'edit' => Pages\EditCategoryVendor::route('/{record}/edit'),
        ];
    }
}
