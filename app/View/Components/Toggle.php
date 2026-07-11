<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;

class Toggle extends Component
{
    /**
     * View path for the component.
     */
    public string $view = 'components.toggle';

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $title = null,
        public ?string $hint = null,
        public ?bool $value = false,
        public ?string $on = null,
        public ?string $off = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->id ??= uniqid('toggle-');
        $this->value ??= false;

        return function (): View {
            return view($this->view, [
                'required' => str_contains($this->attributes->get('validation') ?: '', 'required'),
            ]);
        };
    }
}
