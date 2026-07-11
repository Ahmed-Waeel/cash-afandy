<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;

class RadiosColored extends Radios
{
    /**
     * View path for the component.
     */
    public string $view = 'components.radios-colored';

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        foreach ($this->options as $index => $option) {
            $this->options[$index] = $this->getColor($option);
        }

        return parent::render();
    }

    /**
     * Get the color for the given option.
     */
    protected function getColor(string $color): string
    {
        $color = trim($color);
        $isDirectColor = preg_match('/^[a-zA-Z]+$/', $color);

        return $isDirectColor ? "var(--tblr-$color, $color)" : $color;
    }
}
