<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    //     filament::serving(
    //         function(){
    //             Filament::registerNavigationGroups([
    //                 'Surat Jalan',
    //                 'Data Customer / Vendor',
    //                 'Data Barang'
    //             ]);
    //         }
    //     );
    }
}
