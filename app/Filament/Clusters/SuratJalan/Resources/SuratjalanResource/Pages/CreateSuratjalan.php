<?php

namespace App\Filament\Clusters\SuratJalan\Resources\SuratjalanResource\Pages;

use App\Filament\Clusters\SuratJalan\Resources\SuratjalanResource;
use App\Http\Controllers\NomorSuratJalan;
use App\Models\SuratJalan;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSuratjalan extends CreateRecord
{
    protected static string $resource = SuratjalanResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
       
        $data['nomor_surat_jalan'] = NomorSuratJalan::generate(SuratJalan::count()+1);
        return $data;
    }
}
