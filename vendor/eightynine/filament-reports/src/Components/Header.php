<?php

namespace EightyNine\Reports\Components;

use Closure;

use EightyNine\Reports\Contracts\HasBody;
use EightyNine\Reports\Contracts\HasFooter;
use EightyNine\Reports\Contracts\HasHeader;
use Illuminate\Support\Collection;
use EightyNine\Reports\ComponentContainer;

class Header extends ComponentContainer {
    // protected Collection $data;
    protected array $filters = [];

    public static function make(HasHeader|HasBody|HasFooter $livewire, array $filters = []): static
    {
        $static = app(static::class, ['livewire' => $livewire]);
        $static->configure();
        $static->filters = $filters;

        return $static;
    }
    public function getFilters(): array
    {
        return $this->filters;
    }
}
