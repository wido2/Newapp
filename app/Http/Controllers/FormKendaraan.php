<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Filament\Forms\Get;
use Illuminate\Http\Request;
use function Laravel\Prompts\search;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;

use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;

class FormKendaraan extends Controller
{


    static function getFormKendaraan(): array
    {

        return [
            Section::make('Data Vendor')
            ->collapsible()
            ->description('Pilih data vendor yang sesuai')
            ->schema([
                    Select::make('vendor_id')
                    ->live()
                    ->preload()->searchable()
                    ->createOptionForm(VendorController::getFormVendor())
                    ->editOptionForm(
                        VendorController::getFormVendor()
                    )
                    ->relationship('vendor', 'nama'),
                    Fieldset::make('Data Vendor')
                    ->schema([
                        Placeholder::make('nama')
                        ->content(
                            function (Get $get): string {
                                $vendor =Vendor::find($get('vendor_id'));
                               if ($vendor==null) {
                                    return 'Pilih Vendor terlebih dahulu';
                               }
                               if($vendor->nama==null){
                                return 'Nama vendor tidak terssedia';
                               }
                               else {
                                return $vendor? $vendor->nama : '';
                               }

                            }
                        ),
                        Placeholder::make('npwp')
                        // ->reactive()
                        ->content(
                            function (Get $get): string {
                                $vendor = Vendor::find($get('vendor_id'));
                                if ($vendor==null) {
                                    return 'Pilih Vendor terlebih dahulu';
                                }
                                if($vendor->npwp==null){
                                    return 'Non PKP';
                                }
                                else {
                                    return $vendor? $vendor->npwp : 'Non PKP';

                                }
                            }),
                        Placeholder::make('alamat')
                        ->content(
                            function (Get $get): string {
                                $vendor = Vendor::find($get('vendor_id'));
                                if (!$vendor){
                                    return 'Pilih Vendor terlebih dahulu';
                                }
                                if($vendor==null){
                                    return 'Alamat vendor tidak tersedaia';
                                }
                                else {
                                    return $vendor? $vendor->alamat : '';
                                }
                            }
                        )
                            ,
                        Placeholder::make('telepon')
                        ->content(
                            function (Get $get): string {
                                $vendor = Vendor::find($get('vendor_id'));
                                if ($vendor==null) {
                                    return 'Pilih Vendor terlebih dahulu';
                                }
                                if($vendor->telepon==null){
                                    return 'Nomor Telepon vendor tidak tersedia';
                                }
                                else {
                                    return $vendor? $vendor->telepon : '';
                                }
                            }),
                        Placeholder::make('fax')
                        ->content(
                            function (Get $get): string {
                                $vendor = Vendor::find($get('vendor_id'));
                                if ($vendor==null) {
                                    return 'Pilih Vendor terlebih dahulu';
                                }
                                if($vendor->fax==null){
                                    return 'Nomor Fax vendor tidak tersedia';
                                }
                                else {
                                    return $vendor? $vendor->fax : '';
                                }
                            })
                            ->label('Nomor Fax'),

                        Placeholder::make('email')
                        ->content(
                            function (Get $get): string {
                                $vendor = Vendor::find($get('vendor_id'));
                                if ($vendor==null) {
                                    return 'Pilih Vendor terlebih dahulu';
                                }
                                if($vendor->email==null){
                                    return 'Email vendor tidak tersedia';
                                }
                                else {
                                    return $vendor? $vendor->email : '';
                                }
                            })
                            ->label('Email'),
                        Placeholder::make('website')
                        ->content(
                            function (Get $get): string {
                                $vendor = Vendor::find($get('vendor_id'));
                                if ($vendor==null) {
                                    return 'Pilih Vendor terlebih dahulu';
                                }
                                if($vendor->website==null){
                                    return 'Website vendor tidak tersedia';
                                }
                                else {
                                    return $vendor? $vendor->website : '';
                                }
                            })
                            ->label('Website'),
                        // Placeholder::make('kontak.nama'),
                        // Placeholder::make('kontak_id')


                    ])

                ])->columns(2),


                Section::make('Data Kendaraan')
                ->description('Data Sesuai STNK')
            ->schema([
                TextInput::make('nama')->required(),
                TextInput::make('nomor_polisi')->required(),
                TextInput::make('jenis_kendaraan')->required(),
                TextInput::make('merk')->required(),
                DatePicker::make('tahun_pembuatan'),
                TextInput::make('warna'),
                TextInput::make('nomor_rangka'),
                TextInput::make('nomor_mesin'),
                TextInput::make('nomor_stnk')->label('Nomot STNK'),
                TextInput::make('nomor_bpkb')->label('Nomor BPKB'),
                DatePicker::make('tanggal_stnk')->label('Tanggal STNK'),
                DatePicker::make('tanggal_bpkb')->label('Tanggal BPKB'),
            ])
            ->columns(3)
            ->collapsible(),

            Section::make('Data Gambar')
            ->collapsible()
            ->columns(2 )
            ->description('Lampirkan data gambar hasil foto dan Scan Kendaraan, max file size 3Mb')
            ->schema([
                    FileUpload::make('scan_stnk')->multiple()->image()->maxSize(4080)->maxFiles(2)->label('Scan STNK'),
                    FileUpload::make('scan_bpkb')->multiple()->image()->maxFiles(7)->maxSize(4080)->label('Scan BPKB'),
                    FileUpload::make('foto_kendaraan')->multiple()->image()->maxSize(4080)->label('Foto Kendaraan')
                ->columnSpanFull()]),
        ];
    }
    static function getTableKendaraan(): array
    {
        return [
            // Add table components for the kendaraan table
            TextColumn::make('vendor.nama')->searchable(),
            TextColumn::make('nama')->searchable(),
            TextColumn::make('nomor_polisi')->searchable(),
            TextColumn::make('jenis_kendaraan')->searchable()->sortable(),
            TextColumn::make('merk')->searchable()->sortable(),
            TextColumn::make('tahun_pembuatan')->searchable()->sortable(),
            TextColumn::make('warna')->searchable()->sortable(),
            TextColumn::make('nomor_rangka')->searchable()->sortable()->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('nomor_mesin')->searchable()->sortable()->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('nomor_stnk')->searchable()->sortable()->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('nomor_bpkb')->searchable()->sortable()->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('tanggal_stnk')->sortable()->searchable()->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('tanggal_bpkb')->searchable()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ImageColumn::make('scan_stnk')->toggleable(isToggledHiddenByDefault:true),
            ImageColumn::make('scan_bpkb')->toggleable(isToggledHiddenByDefault: true),
            ImageColumn::make('foto_kendaraan')->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
