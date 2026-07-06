<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BukuCard extends Component
{
    public $buku;
    public bool $showActions;
    public bool $selectable;

    public function __construct(
        $buku,
        bool $showActions = true,
        bool $selectable = false
    ) {
        $this->buku = $buku;
        $this->showActions = $showActions;
        $this->selectable = $selectable;
    }

    public function render(): View|Closure|string
    {
        return view('components.buku-card');
    }
}