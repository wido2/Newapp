<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;

class FormKontak extends Controller
{
    static function getFormKontak():array{
        return [
            Section::make('Jenis Kontak')
            ->description('Pilih Jenis Kontak ( Customer / Vendor ) pilih satu  ')
            ->columns(2)
            ->collapsible()
            ->schema([
                Select::make('customer_id')
                // ->required()
                ->searchable()
                ->preload()
                ->editOptionForm(
                    FormCustomer::getFormCustomer()
                )
                ->createOptionForm(
                    FormCustomer::getFormCustomer()
                )
                ->label('Customer')
                ->relationship('customer','nama')
                ,
                Select::make('vendor_id')
                ->searchable()
                ->editOptionForm(
                    VendorController::getFormVendor()
                )
                ->createOptionForm(
                    VendorController::getFormVendor()
                )
                ->preload()
                ->label('Vendor')
                ->relationship('vendor','nama'),

            ]),
            Section::make('Detail Kontak')
            ->collapsible()
            ->columns(2)
            ->schema([
                TextInput::make('nama')
            ->required()
            ->maxLength(255),
            TextInput::make('email')
            // ->required()
            ->email()
            ->maxLength(255),
            TextInput::make('telepon')
            ->required()
            ->maxLength(255),
            TextInput::make('jabatan')
            ->required()
            ->maxLength(255),

            ]),

        ];
    }
    static function getTableKontak():array{
        return [
            TextColumn::make('customer.nama')
            ->searchable()
            ->label('Customer'),
            TextColumn::make('vendor.nama')
            ->searchable(),
            TextColumn::make('nama')
            ->searchable(),
            TextColumn::make('email')
            ->color('primary')
            ->icon('heroicon-o-envelope-open')
            ->url(
                function (TextColumn $column, $record) {
                    return 'https://mail.google.com/mail/?view=cm&fs=1&to='.urlencode($record->email);
                }
            )
            ->searchable(),
            TextColumn::make('telepon')
            ->tooltip('kirim Whatsapp')
            ->icon('heroicon-o-chat-bubble-oval-left')
            ->color('success')
            ->url(
                function (TextColumn $column, $record) {
                    return 'https://wa.me/'.Str::replaceFirst('0', '62', $record->telepon);
                }
            )
            ->searchable(),
            TextColumn::make('jabatan')
            ->searchable(),
        ];
    }
}
