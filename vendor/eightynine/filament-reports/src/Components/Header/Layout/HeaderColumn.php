<?php

namespace EightyNine\Reports\Components\Header\Layout;

use Closure;
use Illuminate\Support\Collection;
use EightyNine\Reports\Components\Component;
use EightyNine\Reports\Components\Concerns\CanBeAligned;

class HeaderColumn extends Component
{
    use CanBeAligned;

    /**
     * @var view-string
     */
    protected Collection $data;

    protected string $view = 'filament-reports::components.header.layout.header-column';

    public function data(Closure $dataClosure): static
    {
        $this->data = $this->evaluate($dataClosure);

        return $this;
    }
    public static function make(): static
    {
        $static = app(static::class);

        return $static;
    }
    public function getFilters()
    {
        return reports()->getFilterState();
    }
}
