<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Filament\Forms\Set;
use Illuminate\Http\Request;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Tables\Columns\ToggleColumn;

class FormAddress extends Controller
{
    static function getFormAddress():array{
        return [
            // Add form components for the address form
            Select::make('customer_id')
            ->required()
            ->searchable()
            ->createOptionForm(
                FormCustomer::getFormCustomer()
            )
            ->editOptionForm(
                FormCustomer::getFormCustomer()
            )
            ->preload()
            ->relationship('customer','nama'),

            TextInput::make('city')
            ->label('Kota'),
            TextInput::make('state')
            ->label('Provinsi')
            ->required(),
            TextInput::make('country')
            ->label('Negara')
            ->default('Indonesia'),
            TextInput::make('zip_code')
            ->label('Kode Pos')
            ->numeric()
            ->required(),
            Toggle::make('is_primary')
            ->required()
            ->default(false),
            ToggleButtons::make('address_type')
            ->options([
                'Office' => 'Office',
                'Workshop' => 'Workshop',
                'Warehouse' => 'Warehouse',
                'Other' =>'Other'
            ])
            ->required()
            ->icons(
                [
                    'Office' => 'heroicon-o-building-office-2',
                    'Workshop' => 'heroicon-o-cog',
                    'Warehouse' => 'heroicon-o-building-office',
                    'Other' => 'heroicon-o-map',
                ])
            ->colors(
                [
                    'Office' => 'success',
                    'Workshop' => 'danger',
                    'Warehouse' => 'primary',
                    'Other' => 'warning',
                ])
                ->default('Office')
            ->inline()
            ->columnSpanFull()
            ,
            Textarea::make('street')
            ->label('Alamat')
            ->columnSpanFull()
            ->required(),
            // Add other fields as needed
        ];
    }
    static function getTableAddress():array{
        return [
            TextColumn::make('customer.nama')
            ->searchable()
            ->label('Customer'),
            TextColumn::make('city'),
            TextColumn::make('state'),
            TextColumn::make('address_type'),
            TextColumn::make('zip_code'),
            TextColumn::make('street')
            ->limit(50),
            ToggleColumn::make('is_primary')
        ];
    }
}
