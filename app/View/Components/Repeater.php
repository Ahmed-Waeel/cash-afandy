<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class Repeater extends Component
{
    /**
     * View path for the component.
     */
    public string $view = 'components.repeater';

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $title = null,
        public ?string $hint = null,
        public array|string|Collection|null $value = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->id ??= uniqid('repeater-');

        // Convert array to JSON string
        if (is_array($this->value) || $this->value instanceof Collection) {
            $this->value = json_encode($this->value, JSON_UNESCAPED_UNICODE);
        }

        return function (): View {
            return view($this->view, [
                'required' => str_contains($this->attributes->get('validation') ?: '', 'required'),
            ]);
        };
    }
}
