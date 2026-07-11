<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\ComponentAttributeBag;

class Avatar extends Component
{
    /**
     * View path for the component.
     */
    public string $view = 'components.avatar';

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $name = null,
        public ?string $image = null,
        public string $size = 'sm',
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return function (): View {
            $this->attributes(function (ComponentAttributeBag $attributes) {
                $style = sprintf('background-image: url(%s)', $this->image);

                return $attributes->class([
                    'avatar',
                    "avatar-{$this->size}",
                ])->style([
                    $style => $this->image,
                ]);
            });

            return view($this->view);
        };
    }
}
