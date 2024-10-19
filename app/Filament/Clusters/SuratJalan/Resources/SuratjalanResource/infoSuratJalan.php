<?php
namespace App\Filament\Clusters\SuratJalan\Resources\SuratjalanResource;

use App\Models\SuratJalan;
use Filament\Actions\EditAction;
use Filament\Infolists\Infolist;
use Filament\Actions\ActionGroup;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\View;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\IconPosition;
use Filament\Infolists\Components\Section;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Tabs\Tab;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use App\Filament\Clusters\SuratJalan\Resources\SuratjalanResource;
use Filament\Actions\Action;

class infoSuratJalan extends ViewRecord
{
    protected static string $resource = SuratjalanResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Surat Jalan #' . $this->record->nomor_surat_jalan;
    }
    
    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                EditAction::make('Edit')->color('primary'),
                Action::make('ExportPDF')
                ->label('Export to PDF')
                ->color('info')
                ->icon('fas-file-pdf'),
            ])->label('More Action')->button()
        ];
    }
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('')->schema([
                Tabs::make('Tabs')
                ->contained(false)
                
                ->tabs([
                    Tabs\Tab::make('Home')
                    ->icon('fas-home')
                    ->iconPosition(IconPosition::After)
                    // ->columns(4)
                    ->schema([
                        Section::make('suratjalan')
                        ->collapsible()
                        ->columns(4)
                        ->description('Informasi Surat jalan')
                        ->icon('fas-book')
                        ->schema([
                            TextEntry::make('nomor_surat_jalan')
                        ->label('Nomor Surat Jalan'),
                        TextEntry::make('tanggal_pengiriman')->date()->sinceTooltip(),
                        TextEntry::make('created_at')
                        ->sinceTooltip()
                        ->date(),
                        TextEntry::make('updated_at')
                        ->sinceTooltip()
                        ->date(),
                        TextEntry::make('customer.nama'),
                            TextEntry::make('kontak.nama'),
                            TextEntry::make('kontak.telepon'),
                            TextEntry::make('address')
                            ->badge()
                            ->color('success'),
                        ]),
                        Section::make('Detail Barang ')
                        ->collapsible()
                        ->schema([

                        View::make('Items')
                        ->label('Detail Barang')
                        ->view('infolists.components.tabel-items-suratjalan')
                        
                        ])
                    ]),
                    
                    Tabs\Tab::make('Kendaraan')
                    ->icon('fas-truck')
                    ->iconPosition(IconPosition::After)
                    // ->columns(5)
                    ->schema([
                    Section::make('Detail Kendaraan')
                    ->columns(5)
                    ->collapsible()
                    ->description('Infromasi Lengkap Kendaraan NOPOL, No. Rangka, BPKB dll')
                    ->schema([
                        TextEntry::make('kendaraan.nomor_polisi')
                        ->label('Nomor Polisi'),
                        TextEntry::make('kendaraan.jenis_kendaraan')
                        ->label('Jenis Kendaraan'),
                        TextEntry::make('kendaraan.merk')
                        ->label('Merk'),
                        TextEntry::make('kendaraan.tahun_pembuatan')
                        ->label('Tahun Pembuatan'),
                        TextEntry::make('kendaraan.warna')
                        ->label('Warna Kendaraan'),
                        TextEntry::make('kendaraan.nomor_rangka')
                        ->label('Nomor Rangka'),
                        TextEntry::make('kendaraan.nomor_mesin')
                        ->label('Nomor Mesin'),
                        TextEntry::make('kendaraan.nomor_stnk')
                        ->label('Nomor STNK'),
                        TextEntry::make('kendaraan.nomor_bpkb')
                        ->label('Nomor BPKB'),
                        TextEntry::make('kendaraan.tanggal_stnk')
                        ->label('Tanggal STNK'),
                        TextEntry::make('kendaraan.tanggal_bpkb')
                        ->label('Tanggal BPKB'),
                    ]),
                    Section::make('Dokumen Kendaraan')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->description('Dokumen Kendaraan ')
                    ->schema([
                        ImageEntry::make('kendaraan.scan_stnk')
                        ->label('Scan STNK')
                        ->defaultImageUrl(
                            asset('images/')
                        )
                        ->size(350),
                        ImageEntry::make('kendaraan.scan_bpkb')
                        ->label('Scan BPKB')
                        ->size(350),
                        ImageEntry::make('kendaraan.foto_kendaraan')
                        ->size(350)
                    ])

                    ]),
                    Tabs\Tab::make('Gallery Pengiriman')
                    ->icon('fas-camera')
                    ->iconPosition(IconPosition::After)
                    ->schema([
                        Section::make('Gallery  Pengiriman')
                        ->schema([
                            ImageEntry::make('lampiran')
                            ->label('')
                            ->size(350)
                        ])

                    ]),
                ]),
            ]),
        ]);
    }
}
