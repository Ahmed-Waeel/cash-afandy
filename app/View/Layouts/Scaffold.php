<?php

namespace App\View\Layouts;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Redot\Models\Language;

class Scaffold extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $title = null,
        public ?string $direction = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        $this->direction ??= Language::current()->direction;

        if ($this->title) {
            $this->title = $this->title . ' | ' . app_name();
        } else {
            $this->title = app_name();
        }

        return view('layouts.scaffold');
    }
}
