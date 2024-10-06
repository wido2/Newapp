<?php

namespace App\Http\Controllers;

use App\Models\Pajak;
use App\Models\Kontak;
use App\Models\Produk;
use App\Models\Vendor;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\HargaBarang;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use Awcodes\TableRepeater\Header;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;

use Filament\Forms\Components\Wizard;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Components\Section;
use function PHPUnit\Framework\isNull;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\MarkdownEditor;
use App\Http\Controllers\PaymetTermController;
use Awcodes\TableRepeater\Components\TableRepeater;
use Filament\Tables\Columns\TextColumn;

class PurchaseOrderController extends Controller
{
    static function formPO():array{
        return [
            Wizard::make([
                Wizard\Step::make('Order')
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
                        // ->default(
                        //     nomorPO::generate(PurchaseOrder::count()+1)
                        // )
                        // ->readOnly()
                        ,
                        Select::make('paymet_term_id')
                        ->label('Terms of Payment')
                        ->relationship('paymetTerm','nama')
                        ->preload()
                        ->editOptionForm(PaymetTermController::getForm())
                        ->createOptionForm(PaymetTermController::getForm())
                        ->searchable()
                        ->placeholder('Payment Term')
                        ,
                        TextInput::make('nomor_penawaran')
                        ->label('Nomor Penawaran'),
                        
                    ]),
                Wizard\Step::make('Delivery')
                ->columns(3)
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
                        ->default(date(now()))
                            ->label('Tanggal Pengiriman'),
                        Section::make('Supplier')
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
                        function (Get $get){
                            $total = 0;
                            foreach ($get('items') as $item) {
                                $total += $item['price']*$item['quantity'];
                            }
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
                    Placeholder::make('grandtotal')
                    ->columnSpanFull()
                    
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
                        $grandtotal = $total+ $ppn - $disc ;
                        $set('total_po',$grandtotal);
                        return 'Rp '. number_format($grandtotal, 2, ',', '.');
                        }
                    )

                    ,
                    // Placeholder::make('yay'),
                    TextInput::make('total_po')
                    ->numeric(),
                    TextInput::make('ppn'),
                    TextInput::make('diskon')
                    ]),
                MarkdownEditor::make('note')
                ->maxHeight('100px'),  
                     
                    ])
            
            ])
            ->startOnStep(4)
            ->columnSpanFull()
        ];
    }
    static function getTablePurchaseOrderResource(): array {
        return [
                TextColumn::make('id')->sortable(),
                TextColumn::make('nomor_po')->sortable(),
                TextColumn::make('tanggal_po')->sortable(),
                TextColumn::make('tanggal_kirim')->sortable(),
                TextColumn::make('tanggal_terima')->sortable(),
                TextColumn::make('status')->sortable(),
                TextColumn::make('total_po')->sortable(),
                TextColumn::make('customer_id')->sortable(),
                TextColumn::make('supplier_id')->sortable(),
                TextColumn::make('user_id')->sortable(),
                TextColumn::make('created_at')->sortable(),
                TextColumn::make('updated_at')->sortable(),
          
        ];
    }
}
