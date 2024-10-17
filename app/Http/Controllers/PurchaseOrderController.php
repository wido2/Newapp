<?php

namespace App\Http\Controllers;

use NumberFormatter;
use App\Models\Pajak;
use App\Models\Kontak;
use App\Models\Produk;
use App\Models\Vendor;
use App\Models\Setting;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\HargaBarang;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use Barryvdh\DomPDF\Facade\Pdf;

use Awcodes\TableRepeater\Header;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\MarkdownEditor;
use App\Http\Controllers\PaymetTermController;
use Symfony\Component\HttpFoundation\Response;
use Awcodes\TableRepeater\Components\TableRepeater;
use Pelmered\FilamentMoneyField\Tables\Columns\MoneyColumn;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;

class PurchaseOrderController extends Controller
{
    public static function downloadPDF(Model $record): Response
    {   
        $setting=Setting::find(1);
        // $options->set('isRemoteEnabled', true);
        // $options->set('isJavascriptEnabled', TRUE);
        $pdf = Pdf::loadView('purchase2',['record'=>$record,'setting'=>$setting],
        )->setPaper('A4')->setOption(['isRemoteEnabled'=> true, 'isJavascriptEnabled'=>true]);
    //return $pdf->download('aaa.pdf');
    return response()->streamDownload(function () use ($pdf) {
        echo $pdf->stream();
    }, str_replace('/','_',$record->nomor_po).'.pdf');
    }


    static function formPO():array{
        return [
            Wizard::make([
                Wizard\Step::make('Order')
                    ->icon('heroicon-o-user-circle')
                    ->columns(4)
                    ->description('Order Number')
                    ->schema([
                        Select::make('user_id')
                            ->label('Pembuat')
                            ->relationship('user','name')
                            ->default(
                                app('auth')->user()->id
                            ),
                        TextInput::make('nomor_po')
                        ->label('Nomor PO')
                        ->readOnly()
                        ->placeholder('KBM/PO/xxx/xx')
                        ->helperText('nomor akan terisi setelah di simpan')
                        // ->default(
                        //     nomorPO::generate(PurchaseOrder::count()+1)
                        // )
                        // ->readOnly()
                        ,
                        Select::make('paymet_term_id')
                        ->label('Terms of Payment')
                        ->required()
                        ->relationship('paymetTerm','nama')
                        ->preload()
                        ->editOptionForm(PaymetTermController::getForm())
                        ->createOptionForm(PaymetTermController::getForm())
                        ->searchable()
                        ->placeholder('Payment Term')
                        ,
                        TextInput::make('nomor_penawaran')
                        ->required()
                        ->label('Nomor Penawaran'),
                        
                    ]),
                Wizard\Step::make('Delivery')
                ->columns(3)
                ->icon('heroicon-o-map')
                ->description('Supplier')
                ->columns(4)
                    ->schema([
                        Select::make('vendor_id')
                            ->label('Vendor')
                            ->live()
                            ->preload()
                            ->searchable()
                            ->editOptionForm(VendorController::getFormVendor())
                            ->createOptionForm(
                                VendorController::getFormVendor()
                            )
                            ->relationship('vendor','nama',
                            fn (Builder $query)=>$query->whereHas('vendor_category',function (Builder $query ){
                                return $query->where('nama','=','Supplier');
                            })
                            )
                            ,
                        Select::make('kontak_id')
                            ->hidden(fn (Get $get):bool=>!$get('vendor_id'))
                            ->label('Kontak')
                            ->preload()
                            ->live(onBlur:true)
                            ->searchable()
                            ->relationship('kontak','nama',fn (Builder $query, Get $get)=>$query->where('vendor_id','=',$get('vendor_id')))
                            ,
                        
                        DatePicker::make('tanggal_pengiriman')
                        // ->default(date(now()))
                        ->hidden(fn (Get $get):bool=>!$get('vendor_id'))
                        ->label('Tanggal Pengiriman'),
                        TextInput::make('biaya_kirim')
                        ->numeric()
                        ->default(0)
                        ->hidden(fn (Get $get):bool=>!$get('vendor_id'))
                        ->prefix('Rp.')
                        ->currencyMask(',','.')
                        
                        ,
                        Section::make('Supplier')
                        ->collapsible()
                        ->hidden(fn (Get $get):bool=>!$get('vendor_id'))
                        
                        ->columns(4)
                        // ->collapsed()
                        ->description('Informasi SUpplier ( alamat, npwp, telpon, email)')
                            // ->hidden(fn (Get $get):bool=>!$get('vendor_id'))
                            ->schema([
                                Placeholder::make('nama')
                                ->content(
                                    function (Get $get): ?string {
                                        $vendor = Vendor::find($get('vendor_id'));
                                        if (!$vendor){
                                            return 'Pilih Vendor terlebih dahulu';
                                        }elseif($vendor){
                                            return $vendor? $vendor->nama : 'okok';
                                        }else{
                                            
                                            return'Pilih Vendor';
                                        }
                                    }
                                ),
                                Placeholder::make('npwp')
                                ->content(
                                    function (Get $get): ?string {
                                        $vendor = Vendor::find($get('vendor_id'));
                                        if (!$vendor){
                                            return 'Pilih Vendor terlebih dahulu';
                                        }elseif($vendor){
                                            return $vendor? $vendor->npwp : 'okok';
                                        }else{
                                            
                                            return'Pilih Vendor';
                                        }
                                    } 
                                ),
                                Placeholder::make('alamat')
                                ->content(
                                    function (Get $get): ?string {
                                        $vendor = Vendor::find($get('vendor_id'));
                                        if (!$vendor){
                                            return 'Pilih Vendor terlebih dahulu';
                                        }elseif($vendor){
                                            return $vendor? $vendor->alamat : 'okok';
                                        }else{
                                            
                                            return'Pilih Vendor';
                                        }
                                    }
                                    )
                                    ->afterStateUpdated(fn (Set $set)=>$set('telpon','e')),
                                Placeholder::make('telpon')
                                ->content(
                                    function (Get $get): ?string {
                                        $vendor = Vendor::find($get('vendor_id'));
                                        if (!$vendor){
                                            return 'Pilih Vendor terlebih dahulu';
                                        }elseif($vendor){
                                            return $vendor? $vendor->telepon : 'okok';
                                        }else{
                                            
                                            return'Pilih Vendor';
                                        }
                                    }
                                    ),
                                Placeholder::make('email')
                                ->content(
                                    function (Get $get): ?string {
                                        $vendor = Vendor::find($get('vendor_id'));
                                        if (!$vendor){
                                            return 'Pilih Vendor terlebih dahulu';
                                        }elseif($vendor){
                                            return $vendor? $vendor->email:'email empty';
                                        }elseif($vendor==null){
                                            
                                            return'email empty';
                                        }
                                    }),
                                Placeholder::make('website')
                                ->content(
                                    function (Get $get): ?string {
                                        $vendor = Vendor::find($get('vendor_id'));
                                        if (!$vendor){
                                            return 'Pilih Vendor terlebih dahulu';
                                        }elseif($vendor){
                                            return $vendor->website;
                                        }else{
                                            
                                            return'empty website';
                                        }
                                
                                    }),
                                Placeholder::make('kontakPerson')
                                ->content(
                                    function (Get $get): ?string {
                                        $k=Kontak::where('id','=',$get('kontak_id'))->get();
                                        if(!$get('kontak_id')){
                                            return'bellum pilih kontak';
                                        }elseif($get('kontak_id')){
                                            return $k[0]->nama;
                                        }
                                    }
                            
                                )
                            
                             
                            ])
                          ]),
                Wizard\Step::make('Project')
                ->icon('heroicon-o-presentation-chart-line')
                ->description('Purchase for Project ')
                ->columns(2)
                ->schema([
                    Select::make('project_id')
                    ->relationship('project','nama')
                    ->preload()
                    ->createOptionForm(
                        FormProject::getFormProject()
                    )
                    ->searchable(),
                    Select::make('project_item_id')
                        ->helperText('Jika tidak ditemukan silahkan Edit Project pada menu Project')
                    ->searchable()
                    ->preload()
                    ->relationship('projectItem','nama',
                    fn(Builder $query, Get $get) =>$query->where('project_id','=',$get('project_id'))
                    )
                    ]),
                    Wizard\Step::make('Barang')
                    ->icon('heroicon-o-qr-code')
                    ->description('Detail item Barang')
                    ->schema([
                        TableRepeater::make('items')
                        ->relationship()
                        ->headers([
                            Header::make('product_id')
                            ->label('Nama Barang')
                            ->align(Alignment::Left)
                            ->width('400px'),
                            Header::make('qty')
                            ->width('90px')
                            ->align(Alignment::Center)
                            ->label('Jumlah'),
                            Header::make('satuan_id')
                            
                            ->width('110px')
                            ->align(Alignment::Center)
                            ->label('Satuan'),
                            Header::make('price')
                            ->width('170px'),
                            Header::make('Disc %'),
                            Header::make('subtotal')
                            ->width('170px'),
                            Header::make('notes')
                            ->label('Pajak %'),
                        ])
                        ->schema([
                            Select::make('produk_id')
                            // ->helperText('pilih barang sesuai dengan data barang')
                            ->relationship('produk','nama')
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                            ->createOptionForm(
                                FormProduk::getFormProduk()
                            )
                            // ->live(onBlur:true,debounce:1500)
                            ->preload()
                            ->searchable()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                if (!$get('produk_id')) {
                                    $set('quantity', null);
                                    $set('price', null);
                                    $set('satuan_id', null);
                                    $set('discount', 0);
                                    $set('subtotal', null);
                                }
                            })
                            ,
                            TextInput::make('quantity')
                            ->numeric()
                            // ->hidden(fn (Get $get):bool =>!$get('produk_id'))
                            ->live(onBlur:true,debounce:1500)
                            ->minValue(1)
                            ->afterStateUpdated(
                                function(Get $get, Set $set){
                                    $cek =HargaBarang::find($get('produk_id'));
                                    if($cek){
                                        $set('price',$cek->harga_terbaru);
                                    }else{
                                        $set('price',Produk::find($get('produk_id'))->harga_beli);
                                    }
                                }
                            )
                            ->afterStateUpdated(
                                function (Get $get, Set $set){
                                    $set('pajak_id',Produk::find($get('produk_id'))->pajak_id);
                                }
                            )
                            ->afterStateUpdated(function (Get $get, Set $set){
                                if(($get('produk_id'))&&($get('price')>1)){
                                 $set('subtotal',($get('price')*$get('quantity'))-($get('price')*$get('quantity')*$get('discount')/100));
                                }
                             }
                            )
                            ->afterStateUpdated(
                                function (Get $get,Set $set){
                                    $set('satuan_id',Produk::find($get('produk_id'))->satuan_id);
                                }
                            )
                            ,
                            Select::make('satuan_id')
                            ->placeholder('unit')
                            ->required()
                            ->hidden(fn (Get $get):bool=>!$get('quantity'))
                            ->relationship('satuan','nama')
                          ,
                            TextInput::make('price')
                            ->hidden(fn (Get $get):bool=>!$get('satuan_id'))
                            ->live(onBlur:true,debounce:1500)
                            ->afterStateUpdated(
                                function (Get $get, Set $set){
                                   if(($get('produk_id'))&&($get('price')>1)){
                                    $set('subtotal',($get('price')*$get('quantity'))-($get('price')*$get('quantity')*$get('discount')/100));
                                   }
                                }
                            )
                            ->prefix('Rp')
                            ->currencyMask('.',',',2)
                            ,
                            TextInput::make('discount')
                            ->numeric()
                            ->default(0)
                            ->live()
                            ->hidden(fn (Get $get ):bool=>!$get('price'))
                            ->afterStateUpdated(
                                function (Get $get, Set $set){
                                    if(($get('produk_id'))&&($get('discount')>0)){
                                     $set('subtotal',($get('price')*$get('quantity'))-($get('price')*$get('quantity')*$get('discount')/100));
                                    }
                                 }
                            )
                            ->minValue(0),
                            TextInput::make('subtotal')
                            ->hidden(fn (Get $get):bool=>!$get('price'))
                            ->prefix('Rp')
                            ->readOnly()
                            // ->live(:)
                            ->currencyMask('.',',',2),
                            Select::make('pajak_id')
                            ->live()
                            ->hidden(fn (Get $get)=>!$get('subtotal'))
                            ->relationship('pajak','nama'),
                            // Textarea::make('notes')  
                            // ->hidden(fn (Get $get)=>!$get('subtotal'))
                            
                        ]),
                 
                Hidden::make('status')->default('Confirmed'),  
                Section::make('Total')
                ->description('Total Belanja Keseluruhan')
                ->aside()
                ->compact()
                ->icon('heroicon-o-shopping-cart')
                ->columns(3)
                ->schema([

                    Placeholder::make('Total')
                    ->content(
                        function (Get $get,Set $set){
                            $total = 0;
                            foreach ($get('items') as $item) {
                                $total += $item['price']*$item['quantity'];
                            }
                            $set('total_po',$total);
                            return 'Rp '. number_format($total, 2, ',', '.');
                            
                        }
                    ),
                    Placeholder::make('Discount')
                    ->content( 
                        function (Get $get, Set $set) {
                        $disc = 0;
                        foreach ($get('items') as $item) {
                            $disc += $item['price'] * $item['quantity'] * $item['discount'] / 100;
                        }
                        $set ('diskon',$disc);
                        return 'Rp. '.number_format($disc,2,',','.');
                    }
                    ),
                    Placeholder::make('ppn')
                    ->content(
                        function (Get $get, Set $set) {
                            $ppn = 0;
                            foreach ($get('items') as $item) {
                                if ($item['pajak_id']) {
                                    $pajak = Pajak::find($item['pajak_id']);
                                    $ppn += $item['subtotal'] * ($pajak->persentase / 100);
                                }
                            }
                            $set('ppn', $ppn);
                            return 'Rp '. number_format($ppn, 2, ',', '.');
                        }
                    
                    ),
                    Placeholder::make('biayakirim')
                    ->content(
                        function (Get $get){
                            $biayakirim=0;
                            if($get('biaya_kirim')){
                                $biayakirim = $get('biaya_kirim');
                            }
                            return 'Rp '. number_format($biayakirim,0,',','.');
                        }
                    ),
                    Placeholder::make('grandtotal')
                    // ->columnSpanFull()
                    
                    ->content(
                        function (Get $get,Set $set){
                            $total = 0;
                            foreach ($get('items') as $item) {
                                $total += $item['price']*$item['quantity'];
                            }
                            
                            $disc = 0;
                        foreach ($get('items') as $item) {
                            $disc += $item['price'] * $item['quantity'] * $item['discount'] / 100;
                            }
                        $ppn = 0;
                            foreach ($get('items') as $item) {
                                if ($item['pajak_id']) {
                                    $pajak = Pajak::find($item['pajak_id']);
                                    $ppn += $item['subtotal'] * ($pajak->persentase / 100);
                                }
                            }
                        $biaya_kirim=$get('biaya_kirim');
                        $grandtotal = $total+ $ppn + $biaya_kirim - $disc ;
                        $set('total_bayar',$grandtotal);
                        return 'Rp '. number_format($grandtotal, 2, ',', '.');
                        }
                    ),
                    Hidden::make('biaya_kirim'),
                    Hidden::make('total_po'),
                    Hidden::make('ppn'),
                    Hidden::make('diskon'),
                    Hidden::make('total_bayar')
                    ]),
                RichEditor::make('note')
                ,  
                     
                    ])
            
            ])
            ->startOnStep(1)
            ->columnSpanFull()
        ];
    }
    static function getTablePurchaseOrderResource(): array {
        return [
                TextColumn::make('nomor_po')->sortable(),
                TextColumn::make('nomor_penawaran')
                ->alignCenter(true)->sortable(),
                TextColumn::make('status')
                ->badge(true)
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
                ->sortable(),
                TextColumn::make('created_at')->label('Creation Date')->date()->sinceTooltip(),
                TextColumn::make('tanggal_pengiriman')->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('tanggal_retur')->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('vendor.nama')->sortable(),
                TextColumn::make('kontak.nama')->sortable()
                ->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('paymetTerm.nama')
                ->toggleable(isToggledHiddenByDefault:true)->sortable(),
                TextColumn::make('status')->sortable(),
                TextColumn::make('total_po')
                ->label('Total PO')

                ->toggleable(isToggledHiddenByDefault:true)
               ->money('idr',0,'id')
               ->searchable()
                ->sortable(),
                TextColumn::make('ppn')
                ->label('PPN')
                ->toggleable(isToggledHiddenByDefault:true)
                ->money('idr',0,'id')->sortable(),
                TextColumn::make('project.nama')
                ->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('diskon')
                ->toggleable(isToggledHiddenByDefault:true)
                ->money('idr',0,'id')->sortable(),
                MoneyColumn::make('biaya_kirim')
                ->toggleable(isToggledHiddenByDefault:true)
                ->sortable()
                ->currency('idr')
                ->locale('id')
                ->money('idr',0,'id'),
                TextColumn::make('total_bayar')
                ->label('Total Pembelian')
                ->money('idr',0,'id')->sortable(),
                TextColumn::make('note')->limit(90)->toggleable(isToggledHiddenByDefault:true)->sortable()->searchable(),
                

          
        ];
    }
}
