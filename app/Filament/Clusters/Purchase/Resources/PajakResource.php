<?php

namespace App\Filament\Clusters\Purchase\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Pajak;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Clusters\Purchase;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Http\Controllers\PajakController;
use Filament\Pages\SubNavigationPosition;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Purchase\Resources\PajakResource\Pages;
use App\Filament\Clusters\Purchase\Resources\PajakResource\RelationManagers;

class PajakResource extends Resource
{
    protected static ?string $model = Pajak::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Purchase::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                PajakController::getFormpajak()
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(
                PajakController::getTablePajak()
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
            'index' => Pages\ListPajaks::route('/'),
            'create' => Pages\CreatePajak::route('/create'),
            'edit' => Pages\EditPajak::route('/{record}/edit'),
        ];
    }
}
