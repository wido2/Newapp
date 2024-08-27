<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use App\Http\Controllers\ActionTable;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Http\Controllers\FormKontak;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class KontakRelationManager extends RelationManager
{
    protected static string $relationship = 'kontak';

    public function form(Form $form): Form
    {
        return $form
            ->schema(
                FormKontak::getFormKontak()
            );
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns(
                FormKontak::getTableKontak()
                )
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
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
}
