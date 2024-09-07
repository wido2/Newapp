<?php

namespace App\Filament\Resources\VendorResource\RelationManagers;

use App\Http\Controllers\HargaBarangController;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BarangRelationManager extends RelationManager
{
    protected static string $relationship = 'harga_barang';

    public function form(Form $form): Form
    {
        return $form
            ->schema(
                HargaBarangController::getFormHargaBarang()
            );
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('produk_id')
            ->columns(
                HargaBarangController::getTableHargaBarangonVendorResource()
            )
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
