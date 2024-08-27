<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Driver;
use App\Models\Address;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Livewire\ViewKendaraans;
use Filament\Infolists\Infolist;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Tabs;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Columns\TextColumn;
use function PHPUnit\Framework\isEmpty;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Infolists\Components\TextEntry;
use App\Models\SuratJalan as ModelsSuratJalan;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Contracts\HasInfolists;
use Illuminate\Support\Carbon as SupportCarbon;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Filament\Infolists\Concerns\InteractsWithInfolists;

class SuratJalan extends Controller
{
    static function getFormSuratJalan(): array
    {
        return [
            Wizard::make([
                Step::make('Informasi ')
                    ->icon('heroicon-o-queue-list')
                    ->description('Pengirim')
                    ->schema([
                        TextInput::make('nomor_surat_jalan')
                            ->required()
                            ->readOnly()
                            ->default(NomorSuratJalan::generate(ModelsSuratJalan::count() + 1))
                            ->label('Nomor Surat Jalan'),
                        DatePicker::make('tanggal_pengiriman')->label('Tanggal Pengiriman')->required()->default(now())->format('Y-m-d')->native(false),
                        Select::make('user_id')
                            ->preload()
                            ->searchable()
                            ->required()
                            ->label('Pengirim')
                            ->default(Auth::user()->id)
                            ->relationship('user', 'name'),
                    ]),
                Step::make('Penerima')
                    ->columns(2 )
                    ->icon('heroicon-o-map')
                    ->description('Alamat, Kontak Penerima')
                    ->schema([
                        Select::make('customer_id')
                        ->preload()
                        ->placeholder('Pilih Customer')
                        ->live()
                        ->createOptionForm(
                            FormCustomer::getFormCustomer()
                        )
                        ->editOptionForm(
                            FormCustomer::getFormCustomer()
                        )
                        ->searchable()
                        ->label('Nama Customer')
                        ->relationship('customer', 'nama')
                        ->required(),
                        Select::make('kontak_id')
                        ->preload()
                        ->hidden(fn (Get $get ):bool =>! $get('customer_id'))
                        ->placeholder('Pilih Penerima')
                        ->createOptionForm(
                            FormKontak::getFormKontak()
                        )
                        ->editOptionForm(
                            FormKontak::getFormKontak()
                        )
                        ->searchable()
                        ->required()
                        ->relationship('kontak', 'nama',
                        fn(Builder $query, Get $get) =>
                            $query->where('customer_id', $get('customer_id'))
                            )
                        ->label('Penerima'),
                        Select::make('address')
                        ->hidden(fn (Get $get):bool =>! $get('kontak_id'))
                        ->columnSpanFull()
                        ->searchable()
                        ->preload()
                        ->required()
                        ->placeholder('Pilih Customer terlebih dahulu')
                        ->relationship(
                            'address', 'street',
                        fn(Builder $query, Get $get) =>
                            $query->where('customer_id', $get('customer_id'))
                            ->where('address_type', 'Warehouse')
                            )
                        ->label('Alamat Penerima')
                        ->createOptionForm(
                            FormAddress::getFormAddress()
                        )
                    ]),

                Step::make('Detail')
                    ->icon('heroicon-o-truck')
                    ->description('Kendaraan')
                    ->columns(2)
                    ->schema([
                        Select::make('kendaraan_id')
                            ->preload()
                            ->searchable()
                            ->createOptionForm(
                                FormKendaraan::getFormKendaraan()
                            )
                            ->editOptionForm(
                                FormKendaraan::getFormKendaraan()
                            )
                            ->live()
                            // ->default(1)

                            ->label('Kendaraan')
                            ->relationship('kendaraan', 'nomor_polisi')
                            ->required(),
                        Select::make('driver_id')
                        ->relationship('driver','nama')
                        ->preload()
                        ->editOptionForm(
                            DriverController::getDriverForm()
                        )
                        ->createOptionForm(
                            DriverController::getDriverForm()
                        )
                        ->live()
                        ->searchable(),
                        Section::make('Detail informasi Kendaraan')
                        ->collapsible()
                        ->collapsed()
                        ->columns(3)
                        ->description('Data Kendaraan sesuai STNK')
                        ->schema([
                            Placeholder::make('nama')
                                ->live()
                                    ->content(function (Get $get): string {
                                        $kendaraan = Kendaraan::find($get('kendaraan_id'));
                                        if (!$kendaraan){
                                            return 'Pilih Kendaraan terlebih dahulu';
                                        }else {
                                            return $kendaraan? $kendaraan->nama : '';
                                        }
                                    })

                                    ->label('Nama Kendaraan'),
                                Placeholder::make('nomor_polisi')
                                    ->label('Nomor Polisi : ')
                                    ->content(
                                        function (Get $get): string {
                                            $kendaraan = Kendaraan::find($get('kendaraan_id'));
                                            if (!$kendaraan){
                                                return 'Pilih Kendaraan terlebih dahulu';
                                            }
                                            if ($kendaraan->nomor_polisi==null){
                                                return 'Nomor Polisi Belum Diinput';
                                            }
                                            else {
                                                return $kendaraan? $kendaraan->nomor_polisi : '';
                                            }
                                        }),
                                Placeholder::make('merk')
                                ->label('Merk : ')
                                ->content(
                                    function (Get $get): string {
                                        $kendaraan = Kendaraan::find($get('kendaraan_id'));
                                        if (!$kendaraan){
                                            return 'Pilih Kendaraan terlebih dahulu';
                                        }
                                        if ($kendaraan->merk==null){
                                            return 'Merk Belum Diinput';
                                        }
                                        else {
                                            return $kendaraan? $kendaraan->merk : '';
                                        }
                                    }),
                                Placeholder::make('tahun_pembuatan')
                                ->label('Tahun Pembuatan : ')
                                ->content(
                                    function (Get $get): string {
                                        $kendaraan = Kendaraan::find($get('kendaraan_id'));
                                        if (!$kendaraan){
                                            return 'Pilih Kendaraan terlebih dahulu';
                                        }
                                        if($kendaraan->tahun_pembuatan==null){
                                            return 'Tahun Pembuatan Belum Diinput';
                                        }
                                        else {
                                            return $kendaraan? $kendaraan->tahun_pembuatan : '';
                                        }
                                    }),
                                Placeholder::make('warna')
                                ->label('Warna : ')
                                ->content(
                                    function (Get $get): string {
                                        $kendaraan = Kendaraan::find($get('kendaraan_id'));
                                        if (!$kendaraan){
                                            return 'Pilih Kendaraan terlebih dahulu';
                                        }
                                        if ($kendaraan->warna==null){
                                            return 'Warna Belum Diinput';
                                        }


                                        else {
                                            return $kendaraan? $kendaraan->warna : '';
                                        }
                                    }),
                                Placeholder::make('nomor_rangka')
                                ->label('Nomor Rangka : ')
                                ->content(
                                    function (Get $get): string {
                                        $kendaraan = Kendaraan::find($get('kendaraan_id'));
                                        if (!$kendaraan){
                                            return 'Pilih Kendaraan terlebih dahulu';
                                        }
                                        if ($kendaraan->nomor_rangka==null){
                                            return 'Nomor Rangka Belum Diinput';
                                        }

                                        else {
                                            return $kendaraan? $kendaraan->nomor_rangka : '';
                                        }
                                    }),
                                Placeholder::make('nomor_mesin')
                                ->label('Nomor Mesin : ')
                                ->content(
                                    function (Get $get): string {
                                        $kendaraan = Kendaraan::find($get('kendaraan_id'));
                                        if (!$kendaraan){
                                            return 'Pilih Kendaraan terlebih dahulu';
                                        }
                                        if ($kendaraan->nomor_mesin==null){
                                            return 'Nomor Mesin Belum Diinput';
                                        }
                                        else {
                                            return $kendaraan? $kendaraan->nomor_mesin : '';
                                        }
                                    }),
                                Placeholder::make('nomor_stnk')
                                ->label('Nomor STNK : ')
                                ->content(
                                    function (Get $get): string {
                                        $kendaraan = Kendaraan::find($get('kendaraan_id'));
                                        if (!$kendaraan){
                                            return 'Pilih Kendaraan terlebih dahulu';
                                        }
                                        if ($kendaraan->nomor_stnk==null){
                                            return 'Nomor STNK Belum Diinput';
                                        }
                                        else {
                                            return $kendaraan? $kendaraan->nomor_stnk : '';
                                        }
                                    }),
                                Placeholder::make('tanggal_stnk')
                                ->label('Tanggal STNK : ')
                                ->content(
                                    function (Get $get): string {
                                        $kendaraan = Kendaraan::find($get('kendaraan_id'));
                                        if (!$kendaraan){
                                            return 'Pilih Kendaraan terlebih dahulu';
                                        }
                                        if($kendaraan->tanggal_stnk==null){
                                            return 'Tanggal STNK Belum Diinput';
                                        }
                                        else {
                                            return $kendaraan? $kendaraan->tanggal_stnk : '';
                                        }
                                    }),
                                Placeholder::make('tanggal_bpkb')
                                ->label('Tanggal BPKB : ')
                                ->content(
                                    function (Get $get): string {
                                        $kendaraan = Kendaraan::find($get('kendaraan_id'));
                                        if (!$kendaraan){
                                            return 'Pilih Kendaraan terlebih dahulu';
                                        }
                                        if($kendaraan->tanggal_bpkb==null){
                                            return 'Tanggal BPKB Belum Diinput';
                                        }
                                        else {
                                            return $kendaraan? $kendaraan->tanggal_bpkb : '';
                                        }
                                    }),
                                Placeholder::make('Vendor')
                                ->label('Vendor')
                                ->content(
                                    function (Get $get): string {
                                        $kendaraan = Kendaraan::find($get('kendaraan_id'));
                                        if (!$kendaraan){
                                            return 'Pilih Kendaraan terlebih dahulu';
                                        }
                                        if (!$kendaraan->vendor){
                                            return 'Vendor Belum Diinput';
                                        }
                                        else {
                                            return $kendaraan->vendor? $kendaraan->vendor->nama : '';
                                        }
                                    }),





                            ]),
                        Section::make('Informasi Driver')
                        ->collapsed()
                        ->columns(3)
                        ->description('KTP, SIM, Alamat, No Telpon, dll')
                        ->schema([
                                Placeholder::make('Nama')
                                ->content(
                                    function (Get $get): string {
                                        $driver = Driver::find($get('driver_id'));
                                        if (!$driver){
                                            return 'Pilih Driver terlebih dahulu';
                                        }
                                        if($driver->nama==null){
                                            return 'Nama driver tidak ada';
                                        }
                                        else {
                                            return $driver? $driver->nama : '';
                                        }
                                    }),
                                Placeholder::make('Telepon')
                                ->content(
                                    function (Get $get): string {
                                        $driver = Driver::find($get('driver_id'));
                                        if (!$driver){
                                            return 'Pilih Driver terlebih dahulu';
                                        }
                                        if($driver->telepon==null){
                                            return 'No Telepon driver tidak ada';
                                        }
                                        else {
                                            return $driver? $driver->telepon : '';
                                        }
                                    }),
                                Placeholder::make('KTP')
                                ->label('No. Kartu Tanda Penduduk ( KTP )')
                                ->content(
                                    function (Get $get): string {
                                        $driver = Driver::find($get('driver_id'));
                                        if (!$driver){
                                            return 'Pilih Driver terlebih dahulu';
                                        }
                                        if($driver->ktp==null){
                                            return 'KTP driver tidak ada';
                                        }
                                        else {
                                            return $driver? $driver->ktp : '';
                                        }
                                    }),
                                Placeholder::make('SIM')
                                ->label('Nomor Surat Ijin Mengemudi ( SIM )')
                                ->content(
                                    function (Get $get): string {
                                        $driver = Driver::find($get('driver_id'));
                                        if (!$driver){
                                            return 'Pilih Driver terlebih dahulu';
                                        }
                                        if($driver->sim==null){
                                            return 'SIM driver tidak ada';
                                        }
                                        else {
                                            return $driver? $driver->sim : '';
                                        }
                                    }),
                                Placeholder::make('Alamat')
                                ->content(
                                    function (Get $get): string {
                                        $driver = Driver::find($get('driver_id'));
                                        if (!$driver){
                                            return 'Pilih Driver terlebih dahulu';
                                        }
                                        if($driver->alamat==null){
                                            return 'Alamat driver tidak ada';
                                        }
                                        else {
                                            return $driver? $driver->alamat : '';
                                        }
                                    }),
                                Placeholder::make('Tanggal Lahir')
                                ->content(
                                    function (Get $get): string {
                                        $driver = Driver::find($get('driver_id'));
                                        if (!$driver){
                                            return 'Pilih Driver terlebih dahulu';
                                        }
                                        if($driver->tanggal_lahir==null){
                                            return 'Tanggal Lahir driver tidak ada';
                                        }
                                        else {
                                            return $driver? $driver->tanggal_lahir : '';
                                        }
                                    }),
                                Placeholder::make('Tempat Lahir')
                                ->content(
                                    function (Get $get): string {
                                        $driver = Driver::find($get('driver_id'));
                                        if (!$driver){
                                            return 'Pilih Driver terlebih dahulu';
                                        }
                                        if($driver->tempat_lahir==null){
                                            return 'Tempat Lahir driver tidak ada';
                                        }
                                        else {
                                            return $driver? $driver->tempat_lahir : '';
                                        }
                                    }),
                                Placeholder::make('Email')
                                ->content(
                                    function (Get $get): string {
                                        $driver = Driver::find($get('driver_id'));
                                        if (!$driver){
                                            return 'Pilih Driver terlebih dahulu';
                                        }
                                        if($driver->email==null){
                                            return 'Email driver tidak ada';
                                        }
                                        else {
                                            return $driver? $driver->email : '';
                                        }
                                    }),
                                Placeholder::make('agama')
                                ->content(
                                    function (Get $get): string {
                                        $driver = Driver::find($get('driver_id'));
                                        if (!$driver){
                                            return 'Pilih Driver terlebih dahulu';
                                        }
                                        if($driver->agama==null){
                                            return 'Agama driver tidak ada';
                                        }
                                        else {
                                            return $driver? $driver->agama : '';
                                        }
                                    }),





                            ])

                        ]),

                Step::make('Lampiran')
                    ->icon('heroicon-o-paper-clip')
                    ->description('Scan')
                    ->schema([
                        FileUpload::make('scan_surat')
                        ->label('Lampiran Scan Surat Jalan')
                        ->multiple()
                        // ->required()
                        ->maxFiles(5),
                        FileUpload::make('lampiran')
                        ->label('lampiran Foto Barang di dalam Kendaraan')
                        ->multiple()
                        // ->required()
                        ->maxFiles(35)]),

                Step::make('Barang')
                    ->icon('heroicon-o-squares-plus')
                    ->description('Items')
                    ->schema([
                        Repeater::make('barangs')
                            ->columns(8)
                            ->relationship()
                            ->schema([
                                Select::make('produk_id')
                                ->required()->searchable()
                                ->preload()
                                ->relationship('produk', 'nama')
                                ->columnSpan(3),
                                TextInput::make('qty')
                                    ->columnSpan(1)
                                    ->numeric()
                                    ->default(1)
                                    ->required(),
                                Select::make('satuan_id')
                                    ->required()
                                    ->placeholder('satuan')
                                    ->searchable()->preload()
                                    ->relationship('satuan', 'nama')
                                    ->columnSpan(1),
                                TextInput::make('deskripsi')
                                    ->columnSpan(3)
                                ])


                    ]),
            ])
                ->startOnStep(5)
                ->columnSpanFull(),
        ];
    }

    static function getTableSuratJalan(): array
    {
        return [TextColumn::make('nomor_surat_jalan')->searchable()->sortable(), TextColumn::make('customer.nama')->searchable()->sortable(), TextColumn::make('kontak.nama')->searchable()->sortable(), TextColumn::make('address')->searchable()->limit(50)->sortable(), TextColumn::make('user.name')->searchable()->sortable(), TextColumn::make('tanggal_pengiriman')->sortable(), TextColumn::make('kendaraan.nomor_polisi')->searchable()->sortable(), ImageColumn::make('scan_surat')->circular()->stacked()->limit(3)->limitedRemainingText(), ImageColumn::make('lampiran')->circular()->limit()->limitedRemainingText()->stacked()];
    }
}
