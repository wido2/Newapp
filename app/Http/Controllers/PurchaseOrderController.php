<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Http\Request;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;

class PurchaseOrderController extends Controller
{
    static function formPO():array{
        return [
            Wizard::make([
                Wizard\Step::make('Order')
                    ->columns(3)
                    ->description('Order Number')
                    ->schema([
                        Select::make('user_id')
                            ->label('Pembuat')
                            ->relationship('user','name')
                            ->default(
                                app('auth')->user()->id
                            ),
                        TextInput::make('nomor_po')
                        // ->readOnly()
                        ,
                        TextInput::make('nomor_penawaran')
                        ->label('Nomor Penawaran'),
                        
                    ]),
                Wizard\Step::make('Delivery')
                ->columns(3)
                ->description('Supplier')
                    ->schema([
                        Select::make('vendor_id')
                            ->label('Vendor')
                            ->live()
                            ->preload()
                            ->searchable()
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
                            ->searchable()
                            ->relationship('kontak','nama',fn (Builder $query, Get $get)=>$query->where('vendor_id','=',$get('vendor_id')))
                            ,
                        DatePicker::make('tanggal_pengiriman')
                        ->default(date(now()))
                            ->label('Tanggal Pengiriman'),
                        Section::make('Supplier')
                        ->columns(4)
                        ->collapsed()
                        ->description('Informasi SUpplier ( alamat, npwp, telpon, email)')
                            // ->hidden(fn (Get $get):bool=>!$get('vendor_id'))
                            ->schema([
                                Placeholder::make('nama')
                                ->content(
                                    function (Get $get): string {
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
                                    function (Get $get): string {
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
                                    function (Get $get): string {
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
                                    function (Get $get): string {
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
                                    function (Get $get): string {
                                        $vendor = Vendor::find($get('vendor_id'));
                                        if (!$vendor){
                                            return 'Pilih Vendor terlebih dahulu';
                                        }elseif($vendor){
                                            return $vendor? $vendor->email : 'okok';
                                        }else{
                                            
                                            return'Pilih Vendor';
                                        }
                                    })
                                
                            ])
                       
                    ]),
                Wizard\Step::make('Project')
                ->description('Purchase for Project ')
                    ->schema([
                        // ...
                    ]),
            
            ])
            ->startOnStep(2)
            ->columnSpanFull()
        ];
    }
}
