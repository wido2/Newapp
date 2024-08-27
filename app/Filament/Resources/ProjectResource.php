<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Project;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Http\Controllers\FormProject;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProjectResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Filament\Resources\ProjectResource\RelationManagers\ProjectItemRelationManager;
use App\Http\Controllers\ActionTable;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationGroup = 'Data Customer / Vendor';
    protected static?string $navigationLabel = 'Proyek';
    protected static?string $pluralModelLabel = 'Proyek Customer';
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                FormProject::getFormProject()
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(
                FormProject::getTableProject()
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
            ProjectItemRelationManager::class

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'view' => Pages\ViewProject::route('/{record}'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
