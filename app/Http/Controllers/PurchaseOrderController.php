<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use App\Models\Vendor;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use Awcodes\TableRepeater\Header;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Components\Section;
use function PHPUnit\Framework\isNull;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use App\Http\Controllers\PaymetTermController;
use App\Models\HargaBarang;
use App\Models\Produk;
use Awcodes\TableRepeater\Components\TableRepeater;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;

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
                        ->default(
                            nomorPO::generate(PurchaseOrder::count()+1)
                        )
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
                            ->label('Keterangan'),
                        ])
                        ->schema([
                            Select::make('produk_id')
                            ->relationship('product','nama')
                            ->createOptionForm(
                                FormProduk::getFormProduk()
                            )
                            // ->live(onBlur:true,debounce:1500)
                            ->preload()
                            ->searchable()
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
                            Textarea::make('deskripsi')
                            ->hidden(fn (Get $get)=>!$get('subtotal'))
                            
                        ]),
                Textarea::make('note') ,     
                Section::make('Total')
                ->description('Total Belanja Keseluruhan')
                ->aside()
                ->compact()
                ->icon('heroicon-o-shopping-cart')
                ->schema([

                    Placeholder::make('Total')
                    ->content(
                        function (Get $get): string {
                            $total = collect($get('items'))->reduce(function ($carry, $item) {
                                return $carry + $item['subtotal'];
                            }, 0);
                            return "Rp. ".number_format($total, 2);
                        }
                    ),
                    Placeholder::make('Total Disc'),
                    Hidden::make('total_po')
                    ->default(fn(Get $get)=>$get('Total'))
                ])
                        
                           
                            
                    ])
            
            ])
            ->startOnStep(4)
            ->columnSpanFull()
        ];
    }
}
