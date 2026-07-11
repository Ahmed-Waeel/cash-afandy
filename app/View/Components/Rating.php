<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;

class Rating extends Component
{
    /**
     * View path for the component.
     */
    public string $view = 'components.rating';

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $title = null,
        public ?string $hint = null,
        public ?string $name = null,
        public ?string $value = null,
        public int $stars = 5,
        public string|int $size = '24px',
        public string $icon = 'fas fa-star',
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->id ??= uniqid('rating-');
        $this->size = is_numeric($this->size) ? $this->size . 'px' : $this->size;

        return function ($data): View {
            return view($this->view, [
                'required' => str_contains($this->attributes->get('validation') ?: '', 'required'),
            ]);
        };
    }
}
