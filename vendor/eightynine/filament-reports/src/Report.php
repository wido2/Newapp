<?php

namespace EightyNine\Reports;

use EightyNine\Reports\Components\Body;
use EightyNine\Reports\Components\Footer;
use EightyNine\Reports\Components\Header;
use EightyNine\Reports\Concerns\HasFilterForm;
use EightyNine\Reports\Concerns\HasReportActions;
use EightyNine\Reports\Concerns\InteractsWithActionsPanel;
use EightyNine\Reports\Concerns\ResolvesDynamicLivewireProperties;
use EightyNine\Reports\Contracts\HasActionsPanel;
use EightyNine\Reports\Contracts\HasBody;
use EightyNine\Reports\Contracts\HasFooter;
use EightyNine\Reports\Contracts\HasHeader;
use Filament\Facades\Filament;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;

class Report extends Page implements HasActionsPanel, HasBody, HasFooter, HasForms, HasHeader
{
    use HasFilterForm;
    use HasReportActions;
    use InteractsWithActionsPanel;
    use ResolvesDynamicLivewireProperties;

    public ?string $heading = '';

    public ?array $sections = ['pad', 'header', 'body', 'footer', 'pad'];

    public ?string $subHeading = '';

    public ?string $icon = 'heroicon-o-document-text';

    public static string $view = 'filament-reports::pages.report';

    public ?string $group = null;

    public ?string $logo = '/img/logo.png';

    public bool $shouldOpenInNewTab = true;

    public int $sort = 0;

    public function getSort(): int
    {
        return $this->sort;
    }

    public function getShouldOpenInNewTab(): bool
    {
        return $this->shouldOpenInNewTab;
    }

    public function getHeading(): string
    {
        return $this->heading;
    }

    public function getSubHeading(): string
    {
        return $this->subHeading;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function getGroup(): ?string
    {
        return $this->group ?? __('filament-reports::menu-page.nav.group');
    }

    public static function getRouteName(?string $panel = null): string
    {
        $panel ??= Filament::getCurrentPanel()->getId();

        return (string) str(static::getSlug())
            ->replace('/', '.')
            ->prepend("filament.{$panel}.reports.");
    }

    public function getTableHeader(): Header
    {
        return $this->header(Header::make($this));
    }

    public function getTableBody(): Body
    {
        return $this->body(Body::make($this, $this->getFilterData()));
    }

    public function getTableFooter(): Footer
    {
        return $this->footer(Footer::make($this));
    }

    public function header(Header $header): Header
    {
        return $header;
    }

    public function body(Body $body): Body
    {
        return $body;
    }

    public function footer(Footer $footer): Footer
    {
        return $footer;
    }
}
