<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\ComponentAttributeBag;

class Captcha extends Component
{
    /**
     * View path for the component.
     */
    public string $view = 'components.captcha';

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $title = null,
        public ?string $hint = null,
        public string $name = 'captcha',
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->id ??= uniqid('captcha-');

        return function (): View {
            $this->attributes(function (ComponentAttributeBag $attributes) {
                return $attributes->class(['cf-turnstile'])->merge([
                    'init' => 'turnstile',
                ]);
            });

            return view($this->view);
        };
    }
}
