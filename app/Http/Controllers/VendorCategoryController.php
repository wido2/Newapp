<?php

namespace App\Http\Controllers;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Http\Request;

class VendorCategoryController extends Controller
{
    static function getformcategoryvendor():array{
        return [
            TextInput::make('nama')
            ->required(),
            Textarea::make('deskripsi'),
            Toggle::make('is_active')
        ];
    }
}
