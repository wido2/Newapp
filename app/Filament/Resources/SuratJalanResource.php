<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratJalanResource\Pages;
use App\Filament\Resources\SuratJalanResource\RelationManagers;
use App\Filament\Resources\SuratJalanResource\RelationManagers\BarangsRelationManager;
use App\Http\Controllers\ActionTable;
use App\Http\Controllers\SuratJalan as ControllersSuratJalan;
use App\Models\SuratJalan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SuratJalanResource extends Resource
{
    protected static ?string $model = SuratJalan::class;
    protected static ?string $navigationGroup = 'Surat Jalan';
    protected static?string $navigationLabel = 'Data Surat Jalan';
    protected static?string $pluralModelLabel = 'Data Surat Jalan';

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                ControllersSuratJalan::getFormSuratJalan()
            );
    }

public static function infolist(Infolist $infolist): Infolist
{
    // Add your infolist configuration here
    return $infolist
    ->schema([
        TextEntry::make('nomor_surat_jalan'),
        TextEntry::make('customer.nama'),
        TextEntry::make('kontak.nama'),
        TextEntry::make('address'),
        TextEntry::make('user.name'),
        TextEntry::make('tanggal_pengiriman'),
        TextEntry::make('kendaraan.nama'),
        ImageEntry::make('scan_surat'),
        ImageEntry::make('lampiran'),


    ])
    ;
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns(
                ControllersSuratJalan::getTableSuratJalan()
            )
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
            BarangsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuratJalans::route('/'),
            'create' => Pages\CreateSuratJalan::route('/create'),
            'view' => Pages\ViewSuratJalan::route('/{record}'),
            'edit' => Pages\EditSuratJalan::route('/{record}/edit'),
        ];
    }
}
