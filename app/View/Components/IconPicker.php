<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;

class IconPicker extends Component
{
    /**
     * View path for the component.
     */
    public string $view = 'components.icon-picker';

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $title = null,
        public ?string $hint = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->id ??= uniqid('icon-picker-');

        return function (): View {
            return view($this->view, [
                'required' => str_contains($this->attributes->get('validation') ?: '', 'required'),
            ]);
        };
    }
}
