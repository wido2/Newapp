<?php

namespace App\Filament\Clusters\Project\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\Project as proyek;
use App\Filament\Clusters\Project;
use App\Models\Project as ModelsProject;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Project\Resources\ProjectResource\Pages;
use App\Filament\Clusters\Project\Resources\ProjectResource\RelationManagers;
use App\Filament\Resources\ProjectResource\RelationManagers\ProjectItemRelationManager;
use App\Http\Controllers\ActionTable;
use App\Http\Controllers\FormProject;

class ProjectResource extends Resource
{
    protected static ?string $model = ModelsProject::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    protected static ?int $navigationSort = 1;
    protected static?string $pluralModelLabel = 'Proyek';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Project::class;

    public static function getNavigationBadge():?string
    {
        return static::getModel()::count();
    }

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
            ->columns(FormProject::getTableProject())
            ->filters([
                //
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
            ProjectItemRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
