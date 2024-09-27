<?php

namespace App\Filament\Clusters\Project\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ProjectItem;
use Filament\Resources\Resource;
use App\Filament\Clusters\Project;
use Filament\Tables\Grouping\Group;
use App\Http\Controllers\FormSatuan;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Project\Resources\ProjectItemResource\Pages;
use App\Filament\Clusters\Project\Resources\ProjectItemResource\RelationManagers;
use Filament\Tables\Filters\SelectFilter;

class ProjectItemResource extends Resource
{
    protected static ?string $model = ProjectItem::class;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Project::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                ->columnSpan(3)
                ->required(),
            TextInput::make('qty')
                ->required()
                ->columnSpan(1)
                ->numeric(),
            Select::make('satuan_id')
                ->required()
                ->columnSpan(1)
                ->searchable()
                ->preload()
                ->createOptionForm(
                    FormSatuan::getFormSatuan()
                )
                ->placeholder('Satuan')
                ->relationship(
                    'satuan',
                    'nama',
                )
                ->label('Satuan'),
            Textarea::make('deskripsi')
                ->nullable()
                ->columnSpan(3),
            Toggle::make('is_active')
                ->default(true)
                ->columnSpan(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->groups    ([
            Group::make('project.nama')
        ])
        ->defaultGroup('project.nama')
            ->columns([
                TextColumn::make('nama')
                ->searchable()
                ->sortable()
                ->copyable(),
                TextColumn::make('qty')
                ->sortable(),
                TextColumn::make('satuan.nama')
                ->searchable(),
                TextColumn::make('deskripsi')
                ->searchable()
            ])
            ->filters([
                SelectFilter::make('project')
                ->label('Project')
                ->relationship('project','nama')
                ->searchable()
                ->preload(),
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
            'index' => Pages\ListProjectItems::route('/'),
            'create' => Pages\CreateProjectItem::route('/create'),
            'edit' => Pages\EditProjectItem::route('/{record}/edit'),
        ];
    }
}
