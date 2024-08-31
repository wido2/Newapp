<?php

namespace EightyNine\Reports;

use EightyNine\Reports\Concerns\HasFilterState;
use EightyNine\Reports\Concerns\HasPageSettings;
use Filament\Panel\Concerns\HasComponents;
use Livewire\Livewire;

class ReportsManager
{
    use HasComponents;
    use HasFilterState;
    use HasPageSettings;

    protected array $reports = [];

    private static $instance;

    public static function getInstance()
    {
        if (! self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function discoverReports(string $in, string $for)
    {
        $this->discoverComponents(
            Report::class,
            $this->reports,
            directory: $in,
            namespace: $for,
        );

        collect($this->reports)->each(function ($report) {
            $this->queueLivewireComponentForRegistration($report);
        });

        foreach ($this->livewireComponents as $componentName => $componentClass) {
            Livewire::component($componentName, $componentClass);
        }

        $this->livewireComponents = [];
    }
}
