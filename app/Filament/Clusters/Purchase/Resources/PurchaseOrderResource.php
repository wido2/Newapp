<?php

namespace App\Filament\Clusters\Purchase\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Setting;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Tables\Table;
use App\Models\PurchaseOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Resources\Resource;
use App\Filament\Clusters\Purchase;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Filament\Pages\SubNavigationPosition;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\PurchaseOrderController;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Purchase\Resources\PurchaseOrderResource\Pages;
use App\Filament\Clusters\Purchase\Resources\PurchaseOrderResource\Pages\infoPO;
use App\Filament\Clusters\Purchase\Resources\PurchaseOrderResource\RelationManagers;

class PurchaseOrderResource extends Resource
{
    protected static ?string $model = PurchaseOrder::class;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Orders';

    protected static ?string $cluster = Purchase::class;

    public static function getNavigationBadge(): ?string
    {

        $start=Carbon::today()->startOfMonth();
        return static::getModel()::whereBetween('created_at',[$start,Carbon::today()])->count().' New in this month';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(PurchaseOrderController::formPO());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(fn (Model $record):string=>infoPO::getUrl([$record->id]))
            ->columns(
                PurchaseOrderController::getTablePurchaseOrderResource()
            )
            ->filters([
                SelectFilter::make('vendor_id')
                ->relationship('vendor','nama',fn (Builder $query)=>$query->whereHas('vendor_category',function (Builder $query ){
                    return $query->where('nama','=','Supplier');
                }))
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('print')
                ->icon('fas-print')
                ->action(
                          function(Model $record){
                            return PurchaseOrderController::downloadPDF($record);
                          }

                )
            ])
            ->defaultSort('created_at','desc')
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
            'viewPO'=> infoPO::route('/{record}/viewPO'),
            'index' => Pages\ListPurchaseOrders::route('/'),
            'create' => Pages\CreatePurchaseOrder::route('/create'),
            'edit' => Pages\EditPurchaseOrder::route('/{record}/edit'),
        ];
    }
}
