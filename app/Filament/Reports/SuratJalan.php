<?php

namespace App\Filament\Reports;

use App\Models\Barang;
use App\Models\Produk;
use Filament\Forms\Form;
use EightyNine\Reports\Report;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
// use Illuminate\Database\Eloquent\Collection;
use EightyNine\Reports\Components\Body;
use EightyNine\Reports\Components\Text;
use EightyNine\Reports\Components\Image;
use EightyNine\Reports\Components\Footer;
use EightyNine\Reports\Components\Header;
use EightyNine\Reports\Components\Body\Table;
use App\Models\SuratJalan as ModelsSuratJalan;
use EightyNine\Reports\Components\Body\TextColumn;
use EightyNine\Reports\Components\Footer\Layout\FooterRow;
use EightyNine\Reports\Components\Header\Layout\HeaderRow;
use EightyNine\Reports\Components\Header\Layout\HeaderColumn;
use EightyNine\Reports\Enums\FontSize;

class SuratJalan extends Report
{
    public ?string $heading = "Report";

    // public ?string $subHeading = "A great report";

    public function header(Header $header): Header
    {
        
        $k=Auth::user();
        return $header
            ->schema([
                HeaderRow::make()
                ->schema([

                    HeaderColumn::make()
                    ->schema([
                    Image::make('/storage/logo.png')
                    ->widthX400(),     
                    ])->alignLeft(),
                    HeaderColumn::make()
                    ->schema([
                        
                    ]),

                    HeaderColumn::make()
                    ->schema([
                        Text::make('Sidoarjo, '.'Tanggal , '.date('d-m-Y')),
                        // Text::make('No. SJ : '.$customerName->nomor_surat_jalan),
                        // Text::make('Penerima : '.$customerName->customer->nama),
                        // Text::make('Alamat : '.$customerName->address),
                        // Text::make('Kontak : '.$customerName->kontak->nama),
                        // Text::make(dd($form))

                    ])->alignRight()
                    ]),
                
                HeaderRow::make()
                ->schema(
                    [
                        Text::make('Surat Jalan')
                        ->font3Xl()
                    ]
                )->alignCenter()
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
    public function getData(?array $filters): Collection
    {
        // $data = $this->getData(['nomor_surat_jalan' => $this->filters['nomor_surat_jalan']]);

        return
        Barang::query()
        ->where('surat_jalan_id','=',$filters)
        ->with('produk')
        ->with('satuan')
        // ->with('suratJalan')
        ->get()
        ->map(function($item){
            $item->produk_nama=$item->produk->nama;
            $item->satuan_nama=$item->satuan->nama;
            // $item->customer_nama=$item->suratJalan->customer->nama; // Access the customer's name

            return $item;
        })
            
        ;
        
    }

    public function footer(Footer $footer): Footer
    {
        return $footer
            ->schema([
                FooterRow::make()
                ->schema([

                ])
            ]);
    }

    
    public function filterForm(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('nomor_surat_jalan')
                ->searchable()
                ->preload()
                ->optionsLimit(1)
                ->searchingMessage('Mencari...')
                ->noSearchResultsMessage('Nomor tidak ditemukan')
                ->searchPrompt('Nomor Surat Jalan')
                ->options(
                    ModelsSuratJalan::all()
                    ->pluck('nomor_surat_jalan', 'id')
                    ->toArray()

                )
                ->label('Nomor Surat Jalan')

            ]);
    }
}
