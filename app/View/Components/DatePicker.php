<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;

class DatePicker extends Component
{
    /**
     * View path for the component.
     */
    public string $view = 'components.date-picker';

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
        $this->id ??= uniqid('date-picker-');

        return function (): View {
            return view($this->view, [
                'required' => str_contains($this->attributes->get('validation') ?: '', 'required'),
            ]);
        };
    }
}
