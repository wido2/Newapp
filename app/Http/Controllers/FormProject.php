<?php

namespace App\Http\Controllers;

use BladeUI\Icons\Components\Icon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Illuminate\Http\Request;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Tables\Columns\ToggleColumn;
use Symfony\Component\Yaml\Inline;

class FormProject extends Controller
{

    static function getFormProject():array{
        return [
            // Add form components for the project form
            TextInput::make('nama')
            ->required(),
            Select::make('customer_id')
            ->required()
            ->searchable()
            ->preload()
            ->relationship(
                'customer',
                'nama',
            )
            ,
            DatePicker::make('tanggal_mulai')
                ->required()
                ->default(date(now())),
            DatePicker::make('tanggal_selesai')
            ,
            ToggleButtons::make('status')
            ->default('On Progress')
            ->options([
                'Pending' => 'Pending',
                'On Progress' => 'On Progress',
                'Completed' => 'Completed',
                'Cancelled' => 'Cancelled',])
            ->required()
            ->icons(
                [
                    'Pending' => 'heroicon-o-clock',
                    'On Progress' => 'heroicon-o-play',
                    'Completed' =>'heroicon-o-check-circle',
                    'Cancelled' => 'heroicon-o-x-circle',
                ]
            )
            ->colors(
                [
                    'Pending' => 'warning',
                    'On Progress' => 'info',
                    'Completed' => 'success',
                    'Cancelled' => 'danger',

                ]
            )
            ->inline()                          ,
            Textarea::make('deskripsi')
                ->nullable()
                ->columnSpanFull(),

            Toggle::make('is_active')
            ->default(true),
        ];
    }

    static function getTableProject():array{
        return [
            TextColumn::make('nama')
                ->sortable(),
            TextColumn::make('customer.nama'),
            TextColumn::make('status'),
            TextColumn::make('tanggal_mulai')
                ->sortable(),
            TextColumn::make('tanggal_selesai')
                ->sortable(),
            ToggleColumn::make('is_active'),
            TextColumn::make('deskripsi')
            ->limit(50),
        ];
    }

}
