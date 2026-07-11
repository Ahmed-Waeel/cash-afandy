<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class Radios extends Component
{
    /**
     * View path for the component.
     */
    public string $view = 'components.radios';

    /**
     * Determine if the field is required.
     */
    public bool $required = false;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $title = null,
        public ?string $hint = null,
        public ?string $name = null,
        public array|Collection $options = [],
        public ?string $value = null,
        public array|string $disabled = [],
        public bool $inline = false,
        public ?string $validation = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->id ??= uniqid('radios-');

        if (str_contains($this->validation ?: '', 'required')) {
            $this->required = true;
        }

        // If the disabled is csv, we will convert it to an array.
        if (! is_array($this->disabled)) {
            $this->disabled = is_string($this->disabled) ? parse_csv($this->disabled) : [$this->disabled];
        }

        return view($this->view);
    }
}
