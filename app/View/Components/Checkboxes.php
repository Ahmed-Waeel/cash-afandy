<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class Checkboxes extends Component
{
    /**
     * View path for the component.
     */
    public string $view = 'components.checkboxes';

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
        public array|string|null $value = [],
        public array|string $disabled = [],
        public bool $inline = false,
        public ?string $validation = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->id ??= uniqid('checkboxes-');

        if (str_contains($this->validation ?: '', 'required')) {
            $this->required = true;
        }

        // If the value is csv, we will convert it to an array.
        if (! is_array($this->value)) {
            $this->value = is_string($this->value) ? parse_csv($this->value) : [$this->value];
        }

        // If the disabled is csv, we will convert it to an array.
        if (! is_array($this->disabled)) {
            $this->disabled = is_string($this->disabled) ? parse_csv($this->disabled) : [$this->disabled];
        }

        return view($this->view);
    }
}
