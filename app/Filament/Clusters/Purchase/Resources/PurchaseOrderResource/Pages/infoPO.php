<?php

namespace App\Filament\Clusters\Purchase\Resources\PurchaseOrderResource\Pages;

use Dompdf\Options;
use Filament\Actions;
use function Livewire\wrap;
use Illuminate\Support\Str;
use App\Models\PurchaseOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\EditAction;
use Filament\Infolists\Infolist;
use Filament\Actions\ActionGroup;
use Illuminate\Support\HtmlString;
use App\Filament\Clusters\Purchase;
use Illuminate\Contracts\View\View;

use Illuminate\Support\Facades\App;
use Filament\Support\Enums\FontWeight;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\DatePicker;
use Filament\Actions\Action as headaction;
use Filament\Infolists\Components\Section;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\PurchaseOrderController;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use App\Filament\Clusters\Purchase\Resources\PurchaseOrderResource;
use App\Models\Setting;

class infoPO extends ViewRecord
{
    protected static string $resource = PurchaseOrderResource::class;
    protected static ?string $title = 'Lihat Purchase Order';
    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                EditAction::make('edit')
                ->color('primary')
                ->icon('fas-x'),
                headaction::make('Cancle')
                ->requiresConfirmation()
                ->color('danger')
                
                ->icon('fas-x')
                ->action(
                    function(Model $record, array $data):Model{
                        $record->status = 'Cancelled';
                        $record->save();
                        return $record;
                    }
                ),
                headaction::make('Export')
                ->label('Export PDF')
                ->openUrlInNewTab(true)
                ->icon('fas-file-pdf')
                ->color('danger')
                ->action(
                    function (Model $record) {
                        return PurchaseOrderController::downloadPDF($record);
                    }
                )
                // ->requiresConfirmation()
                // ->modalHeading('Export to PDF   !')
                ,
                headaction::make('Confirm')
                ->requiresConfirmation()
                ->icon('fas-check-circle')
                ->color('success')
                ->action(
                    function(Model $record, array $data):Model{
                        $record->status = 'Confirmed';
                        $record->save();
                        return $record;
                    }
                ),
                headaction::make('retur')
                ->icon('heroicon-o-arrow-path')
                ->requiresConfirmation()
                ->color('primary')
                ->fillForm(
                    fn(Model $record):array=>[
                        'tanggal_retur'=>$record->tanggal_retur
                    ]
                )
                ->form([
                    DatePicker::make('tanggal_retur')
                ])
                ->label('Return PO')
                ->action(
                    function(Model $record, array $data):Model{
                        $record->tanggal_retur = $data['tanggal_retur'];
                        $record->status='Returned';
                        $record->save();
                        return $record;
                    }
                )
            ])->label('More Actions')->button()->color('success')
            
        ];
    }
    public function getTitle(): string|Htmlable
    {
        return 'Purchase Order #'.$this->record->nomor_po;
    }
    private function downloadPDF(Model $record): Response
    {   
        $setting=Setting::find(1);
        // $options->set('isRemoteEnabled', true);
        // $options->set('isJavascriptEnabled', TRUE);
        $pdf = Pdf::loadView('purchase2',['record'=>$record,'setting'=>$setting],
        )->setPaper('A4')->setOption(['isRemoteEnabled'=> true, 'isJavascriptEnabled'=>true]);
    //return $pdf->download('aaa.pdf');
    return response()->streamDownload(function () use ($pdf) {
        echo $pdf->stream();
    }, 'aaa.pdf');
    }
    
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
        ->schema([
            Section::make('Purchase Order')
            ->compact()
            ->headerActions([
                
               
                Action::make('wa')
                ->label('Whatsapp')
                ->tooltip('Send Whatsapp')
                ->url(
                    function($record) {
                        $items = $record->items; // Assuming you have a relationship named 'items' in your PurchaseOrder model
                        $grandTotal = number_format($record->total_bayar,0,',','.'); // Assuming 'subtotal' is the column that holds the item's subtotal
            
                        $details = '';
                        foreach ($items as $item) {
                            $details .= $item->produk->nama . ' - ' . $item->quantity . ' ' . $item->satuan->nama . ' = ' . number_format($item->subtotal,0,',','.') . '%0A';
                        }
            
                        return 'https://api.whatsapp.com/send?phone=' . Str::replaceFirst('0', '62', $record->kontak->telepon) . '&text=Nomor%20PO:%20' . $record->nomor_po . '%0A%0ADetail%20Items:%0A' . $details . '%0AGrand%20Total: Rp. %20' . $grandTotal.'%0A Confirmed - Dimohon segera di kirim';
                    }
                )
                ->openUrlInNewTab(true)
                ->icon('fab-whatsapp'),
                
                
                Action::make('Delivered')
                ->requiresConfirmation()
                ->icon('heroicon-o-clipboard-document-list')
                ->color('info')
                ->label('Terima Barang')
                ->fillForm(fn (PurchaseOrder $record    ):array=>[
                    'tanggal_pengiriman'=>$record->tanggal_pengiriman
                ])
                ->form([
                    DatePicker::make('tanggal_pengiriman')
                ])
                ->action(fn (array $data, PurchaseOrder $record)=>$record->update([
                    'status'=>'Delivered',
                    'tanggal_pengiriman'=>$data['tanggal_pengiriman']
                ])),
                
            ])
            ->icon('heroicon-o-shopping-bag')
            ->description('Lihat Detail Item Purchase Order')
            ->schema([

                Fieldset::make('Purchase Order')
                ->label('')
                ->columns(5)
                ->schema([
                    TextEntry::make('status')
                    ->suffix(function($record){
                        if($record->status=='Delivered'){

                            return' on : '.$record->tanggal_pengiriman;
                        }elseif($record->status=='Returned')
                            return' on : '.$record->tanggal_retur;
                        elseif($record->status=='Confirmed'){
                            return' on : 
                            '.$record->created_at;
                        }

                    })
                    ->badge()
                    ->color(
                        function ($state) {
                            if ($state=='Confirmed'){
                                return 'success';
                            } elseif ($state=='Cancelled'){
                                return 'danger';
                            }elseif($state=='Delivered'){
                                return'info';
                            }elseif($state=='Returned'){
                                return'warning';
                            }
                        }
                    )
                    ->icon(
                        function($state){
                            if($state=='Confirmed'){
                                return 'heroicon-o-check-badge';
                            }elseif ($state=='Cancelled') {
                                return 'heroicon-o-no-symbol';
                            } elseif($state=='Delivered') {
                                return'heroicon-o-archive-box';
                            }elseif($state=='Returned'){
                                return 'heroicon-o-arrow-path-rounded-square';
                            }
                            
                        }
                    )
                    ,
                    TextEntry::make('nomor_po')
                    ->label('Nomor PO')
                    ->size(TextEntrySize::Large)
                    ->weight(FontWeight::SemiBold)
                    ->copyable()
                    ->tooltip('Click to Copy'),
                    TextEntry::make('user.name')->label('Pembuat'),
                    TextEntry::make('created_at')
                    ->datetime(),
                    TextEntry::make('updated_at')
                    ->datetime(),
                    TextEntry::make('nomor_penawaran'),
                    TextEntry::make('vendor.nama'),
                    TextEntry::make('paymetTerm.nama'),
                    TextEntry::make('kontak.nama'),
                    TextEntry::make('kontak.telepon')
                    ->label('Telepon / WA ')
                    ->url(
                        function($record) {
                            $items = $record->items; // Assuming you have a relationship named 'items' in your PurchaseOrder model
                            $grandTotal = number_format($record->total_bayar,0,',','.'); // Assuming 'subtotal' is the column that holds the item's subtotal
                
                            $details = '';
                            foreach ($items as $item) {
                                $details .= $item->produk->nama . ' - ' . $item->quantity . ' ' . $item->satuan->nama . ' = ' . number_format($item->subtotal,0,',','.') . '%0A';
                            }
                
                            return 'https://api.whatsapp.com/send?phone=' . Str::replaceFirst('0', '62', $record->kontak->telepon) . '&text=Nomor%20PO:%20' . $record->nomor_po . '%0A%0ADetail%20Items:%0A' . $details . '%0AGrand%20Total: Rp. %20' . $grandTotal.'%0A Confirmed - Dimohon segera di kirim';
                        }
                    )
                ]),
                ViewEntry::make('Detail Items')
                ->label('Detail Items')
                ->columnSpanFull()
                ->view('infolists.components.tabel-items') ,
                
                ])
            
        ]);
    }
}
