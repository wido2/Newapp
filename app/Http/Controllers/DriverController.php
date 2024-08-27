<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use App\Http\Controllers\KendaraanController;
use Filament\Forms\Components\Textarea;

class DriverController extends Controller
{
    static function getDriverForm():array{
        return [
        Section::make('Kendaraan')
            ->description('Pilih Kendaraan, jika driver mempunyai kendaraan')
            ->collapsed()
            ->schema([
                Select::make('kendaraan_id')
                ->preload()
                ->createOptionForm(
                    FormKendaraan::getFormKendaraan()
                )
                ->editOptionForm(
                    FormKendaraan::getFormKendaraan()
                )
                // ->required()
                ->relationship('kendaraan','nomor_polisi')
                ->searchable()
                ->label('Kendaraan')
                // ->options(\App\Models\Kendaraan::all()->pluck('nomor_polisi', 'id'))
            ]),
        Section::make('Detail Driver')
          ->description('Data Driver')
          ->columns(3)
          ->schema([
            TextInput::make('nama')
            ->required()
            ->maxLength(255),
            TextInput::make('telepon')
            ->required()
            ->placeholder('Nomor Telepon / WA')
            ->maxLength(255),
            TextInput::make('ktp')
            ->required()
            ->placeholder('Nomor KTP')
            ->maxLength(255),
            TextInput::make('sim')
            ->label('Nomor SIM')
            ->required()
            ->placeholder('Nomor SIM')
            ->maxLength(255),
            TextInput::make('email')
            ->required()
            ->email()
            ->maxLength(255),
            DatePicker::make('tanggal_lahir'),
            TextInput::make('tempat_lahir')
            ->maxLength(255),
            TextInput::make('agama')
            ->maxLength(255),
            Textarea::make('alamat'),
            FileUpload::make('scan_ktp')
            ->maxFiles(2)
            ->image()
            ->maxSize(2550)
            ->label('Scan KTP')
            ->columnSpanFull(),
          ]),


        ];
    }

    static function getDriverTable():array{
        return[
            TextColumn::make('nama')
            ->searchable()
            ->label('Nama'),
            TextColumn::make('telepon')
            ->searchable()
            ->label('Telepon'),
            TextColumn::make('alamat')
            ->searchable()
            ->limit(80),
            TextColumn::make('email')
            ->searchable()
            ->label('Email'),
            TextColumn::make('tanggal_lahir')
            ->sortable(),
            TextColumn::make('tempat_lahir')
            ->sortable(),
            TextColumn::make('agama')
            ->sortable(),
            ImageColumn::make('scan_ktp')
        ];
    }

    static function infoDriver():array{
        return [


        ];
    }
}
