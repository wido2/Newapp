<?php

namespace App\Filament\Resources\VendorResource\RelationManagers;

use App\Http\Controllers\FormKendaraan;
use App\Http\Controllers\VendorController;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KendaraanRelationManager extends RelationManager
{
    protected static string $relationship = 'kendaraan';

    public function form(Form $form): Form
    {
        return $form
            ->schema(FormKendaraan::getFormKendaraan());
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns(
                FormKendaraan::getTableKendaraan()
            )
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
