<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;
use Filament\Pages\SubNavigationPosition;

class Customer extends Cluster
{
    // protected static ?string 
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;


}
