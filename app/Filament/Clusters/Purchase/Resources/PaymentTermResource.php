<?php

namespace App\Filament\Clusters\Purchase\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\PaymetTerm;
use Filament\Tables\Table;
use App\Models\PaymentTerm;
use Filament\Resources\Resource;
use App\Filament\Clusters\Purchase;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Purchase\Resources\PaymentTermResource\Pages;
use App\Filament\Clusters\Purchase\Resources\PaymentTermResource\RelationManagers;
use App\Http\Controllers\PaymetTermController;
use Filament\Tables\Columns\TextColumn;

class PaymentTermResource extends Resource
{
    protected static ?string $model = PaymetTerm::class;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Purchase::class;
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                PaymetTermController::getForm()
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                ->searchable(),
                TextColumn::make('day')
                ->sortable()
                ->numeric(),
                TextColumn::make('deskripsi')
                ->limit(90)
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
            'index' => Pages\ListPaymentTerms::route('/'),
            'create' => Pages\CreatePaymentTerm::route('/create'),
            'edit' => Pages\EditPaymentTerm::route('/{record}/edit'),
        ];
    }
}
