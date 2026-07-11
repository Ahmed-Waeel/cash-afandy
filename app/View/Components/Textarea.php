<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\ComponentAttributeBag;

class Textarea extends Component
{
    /**
     * View path for the component.
     */
    public string $view = 'components.textarea';

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $title = null,
        public ?string $hint = null,
        public ?string $value = null,
        public bool $autosize = false,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->id ??= uniqid('textarea-');

        return function (): View {
            if ($this->autosize) {
                $this->attributes(function (ComponentAttributeBag $attributes) {
                    return $attributes->merge(['data-bs-toggle' => 'autosize']);
                });
            }

            return view($this->view, [
                'required' => str_contains($this->attributes->get('validation') ?: '', 'required'),
            ]);
        };
    }
}
