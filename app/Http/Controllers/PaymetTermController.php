<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class PaymetTermController extends Controller
{
    static function getForm():array{
        return[
            Fieldset::make('PaymentTemr')
            ->label('Payment Term')
            ->columns(2)
            ->schema([
                TextInput::make('nama')
                ->placeholder('( 30 Day, Cash, Transfer )| (Billyet Giro)')
                ->required(),
                TextInput::make('day')
                ->placeholder('30')
                ->required(),
                MarkdownEditor::make('deskripsi')
                ->toolbarButtons([
                    'heading',
                    'bold',
                    'italic',
                    'link',
                    'quote',
                    'code',
                    'bulletedList',
                    'numberedList',
                    'orderedList',
                    'table',
                    'image',
                    'alignment',
                    'codeBlock',
                    'undo',
                    'redo',
                    'removeFormat',
                    'fullscreen',
                    'preview',
                    'help',
                ])
                ->placeholder('Input Deskripsi')
                ->columnSpanFull(),
            ])
        ];
    }
}
