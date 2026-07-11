<?php

namespace App\View\Components;

use Illuminate\View\Component as LaravelComponent;
use Illuminate\View\ComponentAttributeBag;

abstract class Component extends LaravelComponent
{
    /**
     * Manipulate the component's attributes.
     */
    protected function attributes(callable $callback): void
    {
        $attributes = new ComponentAttributeBag($this->attributes->getAttributes());

        $this->withAttributes($callback($attributes)->getAttributes());
    }
}
