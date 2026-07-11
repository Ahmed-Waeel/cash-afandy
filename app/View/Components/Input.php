<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;

class Input extends Component
{
    /**
     * View path for the component.
     */
    public string $view = 'components.input';

    /**
     * Determine if the input is password.
     */
    public bool $isPassword = false;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $title = null,
        public ?string $hint = null,
        public ?string $prepend = null,
        public ?string $append = null,
        public string $type = 'text',
        public bool $flat = false,
        public bool $floating = false,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->id ??= uniqid('input-');
        $this->isPassword = strtolower($this->type) === 'password';

        if ($this->isPassword) {
            $this->flat = true;
        }

        return function ($data): View {
            return view($this->view, [
                'isInputGroup' => $data['prepend'] || $data['append'] || $data['isPassword'],
                'required' => str_contains($this->attributes->get('validation') ?: '', 'required'),
            ]);
        };
    }
}
