<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use App\Http\Controllers\ActionTable;
use App\Http\Controllers\FormProduk;
use App\Http\Controllers\FormProject;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectRelationManager extends RelationManager
{
    protected static string $relationship = 'project';
    protected static ?string $badge = 'new';
    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {   $count=$ownerRecord->count();
        return $count>0?$count:null;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns(
                FormProject::getTableProject()
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
