<?php

namespace App\Filament\Reports;

use App\Models\Barang;
use App\Models\Produk;
use Filament\Forms\Form;
use EightyNine\Reports\Report;
use Illuminate\Support\Collection;
use EightyNine\Reports\Components\Body;
use EightyNine\Reports\Components\Footer;
// use Illuminate\Database\Eloquent\Collection;
use EightyNine\Reports\Components\Header;
use EightyNine\Reports\Components\Body\Table;
use App\Models\SuratJalan as ModelsSuratJalan;
use EightyNine\Reports\Components\Body\TextColumn;
use Filament\Forms\Components\Select;

class SuratJalan extends Report
{
    public ?string $heading = "Report";

    // public ?string $subHeading = "A great report";

    public function header(Header $header): Header
    {
        return $header
            ->schema([
                // ...
            ]);
    }


    public function body(Body $body): Body
    {
        // $dataku=ModelsSuratJalan::with('produk')->where('nomor_surat_jalan','=','1');

        return $body
            ->schema([
                Table::make()
                ->data(
                    fn (?array $filters)=>$this->getData($filters)
                )
                ->columns([
                    TextColumn::make('produk_nama')
                    ->label('Nama Barang')
                    ->weight('Thin')
                    ->wrap(true),
                    TextColumn::make('qty')
                    ->size('small'),
                    TextColumn::make('satuan_nama')
                    ->label('Satuan'),
                    TextColumn::make('deskripsi')
                    ->label('keterangan'),
                ])
            ]);
    }
    private function getData(?array $filters): Collection
    {
        return
        Barang::query()
        ->where('surat_jalan_id','=',$filters)
        ->with('produk')
        ->with('satuan')
        ->get()
        ->map(function($item){
            $item->produk_nama=$item->produk->nama;
            $item->satuan_nama=$item->satuan->nama;
            return $item;
        })
            
        ;
        
    }

    public function footer(Footer $footer): Footer
    {
        return $footer
            ->schema([
                // ...
            ]);
    }

    public function filterForm(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('nomor_surat_jalan')
                ->searchable()
                ->preload()
                ->options(
                    ModelsSuratJalan::all()
                    ->pluck('nomor_surat_jalan', 'id')
                    ->toArray()

                )
                ->label('Nomor Surat Jalan')

            ]);
    }
}
